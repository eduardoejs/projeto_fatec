<?php

namespace App\Http\Controllers\Site\Admin\ACL;

use App\Models\Acl\User;
use App\Models\Acl\Perfil;
use App\Events\NovoUsuario;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use App\Classes\ValidaFormUsuario;
use App\Models\Institucional\Cargo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Institucional\Departamento;
use App\Models\Institucional\TiposUsuarios\Aluno;
use App\Models\Institucional\TiposUsuarios\Docente;
use App\Models\Institucional\TiposUsuarios\Funcionario;

class UserController extends Controller
{
    private $route = 'user';    
    private $search = ['nome', 'email'];
    private $paginacao = 30;  
    private $tiposUsers = [];
    private $titulacoes = [];

    public function __construct()
    {
        $this->middleware('auth');        
        $this->tiposUsers = [
            (object)['valor' => 'F', 'descricao' => 'FUNCIONÁRIO'],
            (object)['valor' => 'D', 'descricao' => 'DOCENTE'],
            (object)['valor' => 'A', 'descricao' => 'ALUNO'],
            (object)['valor' => 'EX', 'descricao' => 'EX-ALUNO'],
            (object)['valor' => 'C', 'descricao' => 'CONVIDADO'],
        ];
        $this->titulacoes = [
            (object)['valor' => 'D', 'descricao' => 'DOUTORADO'],
            (object)['valor' => 'M', 'descricao' => 'MESTRADO'],
            (object)['valor' => 'PG', 'descricao' => 'PÓS-GRADUADO (ESPECIALIZAÇÃO)'],
            (object)['valor' => 'L', 'descricao' => 'LICENCIATURA'],
            (object)['valor' => 'B', 'descricao' => 'GRADUADO'],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('read-user');

        $search = "";
        $filtro = "";
        if(isset($request->search) || isset($request->filtro)) 
        {   
            $search = $request->search;
            $filtro = $request->filtro;

            $query = new User();            
            foreach($this->search as $key => $value) {    
                $query = $query->orWhere($value, 'like', '%'.$search.'%')->where('tipo', 'like', '%'.$filtro.'%');                
            }            
            $list = $query->orderBy('ativo', 'ASC')->orderBy('nome', 'ASC')->paginate($this->paginacao);
        }else{
            $list = User::where('tipo', 'like', '%F%')->orderBy('ativo', 'ASC')->orderBy('nome', 'ASC')->paginate($this->paginacao);
        }  

        $colunas = ['id' => 'ID', 'nome' => 'Nome', 'email' => 'E-Mail', 'telefone' => 'Telefone', 'tipoUser' => 'Tipo de Usuário', 'status' => 'Login'];                
        $rotaNome = $this->route;        
        $page = 'Usuários';        
        $tituloPagina = 'Usuários do Sistema';
        $descricaoPagina = 'Gerenciamento dos Usuários do sistema';

        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],
            (object)['url' => '', 'title' => $page],
        ];         
        return view('site.admin.acl.'.$this->route.'.index', compact('breadcrumb', 'page', 'list', 'colunas', 'rotaNome', 'tituloPagina', 'descricaoPagina', 'search', 'filtro'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create-user');
        $page = 'Adicionar';
        $rotaNome = $this->route;
        $tituloPagina = 'Adicionar Usuário';
        $descricaoPagina = 'Cadastro de novo usuário do sistema';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Usuário'],
            (object)['url' => '', 'title' => $page],
        ];

        $tiposUsers = $this->tiposUsers;
        $titulacoes = $this->titulacoes;
        
        $perfis = Perfil::orderBy('nome', 'ASC')->get();
        $cargos = Cargo::orderBy('nome', 'ASC')->get();
        $departamentos = Departamento::all();
        $cursos = Curso::all();
        return view('site.admin.acl.'.$this->route.'.create', compact('perfis','breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome', 'cargos', 'departamentos', 'cursos', 'tiposUsers', 'titulacoes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $this->authorize('create-user');
        
        if(!isset($request->selectTipo)) {
            session()->flash('msg', 'Você deve informar pelo menos um tipo de usuário');
            session()->flash('status', 'error');
            return redirect()->back();
        }
                        
        //Verifica se foi informada uma senha no cadastro, caso contrário é gerada uma senha aleatória
        if (isset($request->password)){            
            $request['password'] = bcrypt($request->password);
        } else {            
            $request['password'] = bcrypt(str_random(8));
        }        
        
        //Validar os campos do formulario de cadastro
        $formValidate = ValidaFormUsuario::validateForm($request)->validate();
                   
        //gravar dados após validacao, usando transaction
        if($formValidate){
            try {
                \DB::beginTransaction();
                   
                $user = User::firstOrCreate([
                    'nome' => $request->nome,
                    'cpf' => $request->cpf,
                    'sexo' => $request->sexo,
                    'email' => $request->email,
                    'password' => $request->password,
                    'token_create' => md5($request->cpf),
                    'telefone' => $request->telefone,
                    'ativo' => $request->ativo,
                    'tipo' => implode(',', $request->selectTipo),
                    'url_lattes' => $request->url_lattes,
                ]);  
                
                foreach (explode(',',$user->tipo) as $key => $value) {
                    if($value == 'F') {
                        $create = Funcionario::firstOrCreate([                    
                            'cargo_id' => $request->cargo_funcionario,
                            'departamento_id' => $request->departamento_funcionario,
                            'user_id' => $user->id,
                        ]);     
                    } else if($value == 'D') {
                        $create = Docente::firstOrCreate([
                            'link_compartilhado' => $request->link_compartilhado,
                            'titulacao' => $request->titulacao,
                            'cargo_id' => $request->cargo_docente, 
                            'user_id' => $user->id,
                        ]);    
                    } else if ($value == 'A'  || $value == 'EX') {
                        $create = Aluno::firstOrCreate([
                            'matricula' => $request->matricula,
                            'curso_id' => $request->curso,
                            'user_id' => $user->id,
                        ]);    
                       
                    }             
                }
                
                if($user && $create) {                    
                    //vincular os perfis ao usuario
                    if(isset($request->perfis)){
                        foreach ($request->perfis as $key => $value) {
                            $user->perfis()->attach($value);
                        }
                    }
    
                    \DB::commit();
                    session()->flash('msg', 'Registro cadastrado com sucesso!');
                    session()->flash('status', 'success');
                    
                    //Quando o estado do model user é "created".
                    //UserObserver dispara o evento de envio de email para o usuario com os dados de validacao 
                    //da nova conta criada (Model Event)
                } else {                
                    \DB::rollback();
                }                
            } catch (\PDOException $e) {
                \DB::rollback();
                session()->flash('msg', 'Erro inesperado ao inserir registro: ' . $e->getMessage());
                session()->flash('status', 'error');
            } catch (\Exception $ex) {
                \DB::rollback();
                session()->flash('msg', 'Erro inesperado: ' . $ex->getMessage());
                session()->flash('status', 'error');
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $this->authorize('read-user');

        $registro = User::findOrFail($id);
        if($registro) {
            $page = 'Show';
            $delete = false;
            if($request->delete ?? false) {                
                $delete = true;
                $page = 'Excluir';
                $rotaNome = $this->route;
                $tituloPagina = '';
                $descricaoPagina = '';
                $breadcrumb = [
                    (object)['url' => route('admin'), 'title' => 'Dashboard'],                              
                    (object)['url' => route('user.index'), 'title' => 'Usuários'],
                    (object)['url' => '', 'title' => $page],
                ];
            } else {
                $page = 'Detalhes';
                $rotaNome = $this->route;                        
                $tituloPagina = 'Usuário: ' . $registro->nome;
                $descricaoPagina = '';
                $breadcrumb = [
                    (object)['url' => route('admin'), 'title' => 'Dashboard'],                    
                    (object)['url' => route('user.index'), 'title' => 'Usuários'],
                    (object)['url' => '', 'title' => $page],
                ];
            }
            return view('site.admin.acl.'.$this->route.'.show', compact('registro', 'delete', 'breadcrumb', 'page', 'delete', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit-user');
        
        $registro = User::with(['funcionarios', 'docentes', 'alunos'])->findOrFail($id);
                
        $page = 'Alterar';
        $rotaNome = $this->route;
        $tituloPagina = 'Alterar Usuário: '.$registro->nome;
        $descricaoPagina = 'Alterar dados do usuário do sistema';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Usuários'],
            (object)['url' => '', 'title' => $page],
        ];

        $tiposUsers = $this->tiposUsers;
        $titulacoes = $this->titulacoes;

        //recupero os tipos de usuário cadastrado
        $array = explode(',', $registro->tipo);
        $arrayTipos = [];
        for($i = 0; $i < count($array); $i++) {
            $arrayTipos[$i] = (object)$arrayTipos[$i] = $array[$i];
        }
        $tiposDoUsuario = json_decode(str_replace('scalar', 'valor',json_encode($arrayTipos)));
                
        $perfis = Perfil::orderBy('nome', 'ASC')->get();
        $cargos = Cargo::orderBy('nome', 'ASC')->get();
        $departamentos = Departamento::all();
        $cursos = Curso::all();
        
        return view('site.admin.acl.'.$this->route.'.edit', compact('registro', 'tiposDoUsuario', 'perfis','breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome', 'cargos', 'departamentos', 'cursos', 'tiposUsers', 'titulacoes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit-user');

        $user = User::findOrFail($id);
        $data = [];
        if(!isset($request->selectTipo)) {            
            session()->flash('msg', 'Você deve informar pelo menos um tipo de usuário');
            session()->flash('status', 'error');
            return redirect()->back();
        }
                        
        //Verifica se foi informada uma senha no cadastro, caso contrário é gerada uma senha aleatória
        if (isset($request->password)){            
            $request['password'] = bcrypt($request->password);
        } else {            
            unset($request['password']);
        } 
                        
        //validar dados
        $formValidate = ValidaFormUsuario::validateForm($request, $id)->validate();
           
        //gravar dados após validacao, usando transaction
        if($formValidate){
            try {
                \DB::beginTransaction();
                         
                //selectTipo vem do form , porem o array passado para o metodo update deve ter o nome de "tipo"
                $formValidate['tipo'] = implode(',', $request->selectTipo);
                unset($formValidate['selectTipo']);

                if(count($user->perfis)) {
                    foreach ($user->perfis as $key => $value) {
                        $user->perfis()->detach($value->id);
                    }
                }
                //vincular os perfis ao usuario
                if(isset($request->perfis) && count($request->perfis)){
                    foreach ($request->perfis as $key => $value) {
                        $user->perfis()->attach($value);
                    }
                }
                
                //remover e adicionar dados de acordo com o tipo de usuário informado
                $arrayTiposOriginal = explode(',', $user->tipo);
                $arrayTiposNovo = $request->selectTipo;
                
                $itensInsert = array_diff($arrayTiposNovo, $arrayTiposOriginal);                
                echo '<br>Itens a Inserir: '.json_encode($itensInsert);

                foreach ($itensInsert as $key => $value) {
                    if($value == 'F') {                        
                        $create = Funcionario::firstOrCreate([                    
                            'cargo_id' => $request->cargo_funcionario,
                            'departamento_id' => $request->departamento_funcionario,
                            'user_id' => $id,
                        ]);     
                    } else if($value == 'D') {                        
                        $create = Docente::firstOrCreate([
                            'link_compartilhado' => $request->link_compartilhado,
                            'titulacao' => $request->titulacao,
                            'cargo_id' => $request->cargo_docente, 
                            'user_id' => $id,
                        ]);

                    } else if ($value == 'A' || $value == 'EX') {
                        $create = Aluno::firstOrCreate([
                            'matricula' => $request->matricula,
                            'curso_id' => $request->curso,
                            'user_id' => $id,
                        ]);
                    }             
                }

                $itensRemove = array_diff($arrayTiposOriginal, $arrayTiposNovo);                
                echo '<br>Itens a Remover: '.json_encode($itensRemove);
                foreach ($itensRemove as $key => $value) {
                    if($value == 'F') {                        
                        $delete = Funcionario::find($id)->delete();
                    } else if($value == 'D') {
                        $delete = Docente::find($id)->delete();    
                    } else if ($value == 'A' || $value == 'EX') {
                        $delete = Aluno::find($id)->delete(); 
                    }             
                }

                //se nao tem item a inserir ou remover, entao, atualiza as informacoes
                foreach ($request->selectTipo as $key => $value) {                    
                    if($value == 'F') {                         
                        $update = Funcionario::find($id)->update(['cargo_id' => $request->cargo_funcionario, 'departamento_id' => $request->departamento_funcionario, 'user_id' => $id]);                        
                    } else if($value == 'D') {
                        $update = Docente::find($id)->update(['cargo_id' => $request->cargo_docente, 'titulacao' => $request->titulacao, 'user_id' => $id, 'link_compartilhado' => $request->link_compartilhado]);    
                    } else if ($value == 'A' || $value == 'EX') {                        
                        $update = Aluno::find($id)->update(['matricula' => $request->matricula, 'curso_id' => $request->curso, 'user_id' => $id,]); 
                    }             
                }
                                
                $updateUser = $user->update($formValidate);
                
                if($updateUser && ((isset($create) && $create) || (isset($delete) && $delete) || (isset($update) && $update))) {
                    \DB::commit();
                    session()->flash('msg', 'Registro alterado com sucesso!');
                    session()->flash('status', 'success');                    
                } else if($updateUser && !((isset($create) && $create) || (isset($delete) && $delete) || (isset($update) && $update))) {                                       
                    \DB::commit();
                    session()->flash('msg', 'Registro alterado com sucesso!');
                    session()->flash('status', 'success');
                } else {
                    \DB::rollback();
                }
            } catch (\PDOException $e) {
                \DB::rollback();
                session()->flash('msg', 'Erro inesperado ao inserir registro: ' . $e->getMessage());
                session()->flash('status', 'error');
            } catch (\Exception $ex) {
                \DB::rollback();
                session()->flash('msg', 'Erro inesperado: ' . $ex);
                session()->flash('status', 'error');
            }
        }        

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-user');
        
        $user = User::findOrFail($id);

        try {
            if($user) {
                $user->delete();
                session()->flash('msg', 'Registro excluído do banco de dados');
                session()->flash('title', 'Sucesso');
                session()->flash('status', 'success');
            }
        } catch (\PDOException $e) {
            session()->flash('msg', $e->getMessage());
            session()->flash('title', 'Erro inesperado');
            session()->flash('status', 'error');
        }
        return redirect()->route($this->route.'.index');
    }

    public function profile()
    {
        $page = 'Perfil';
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],
            (object)['url' => '', 'title' => $page],
        ];
        return view('site.admin.profile', compact('breadcrumb'));
    }
}
