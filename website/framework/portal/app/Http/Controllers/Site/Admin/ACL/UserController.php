<?php

namespace App\Http\Controllers\Site\Admin\ACL;

use App\Mail\MailNotify;
use App\Models\Acl\User;
use App\Jobs\SendEmailJob;
use App\Models\Acl\Perfil;
use App\Events\NovoUsuario;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use App\Mail\SendEmailNewUser;
use Illuminate\Validation\Rule;
use App\Mail\SendEmailToNewUser;
use App\Jobs\SendEmailToNewUserJob;
use App\Models\Institucional\Cargo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendWelcomeEmailNewUser;
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

    public function __construct()
    {
        $this->middleware('auth');        
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

        $colunas = ['id' => 'ID', 'nome' => 'Nome', 'email' => 'E-Mail', 'telefone' => 'Telefone', 'tipoUser' => 'Tipo de Usuário', 'status' => 'Status'];
                
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

        $tiposUsers = [
            (object)['valor' => 'F', 'descricao' => 'FUNCIONÁRIO'],
            (object)['valor' => 'D', 'descricao' => 'DOCENTE'],
            (object)['valor' => 'A', 'descricao' => 'ALUNO'],
            //(object)['valor' => 'EX', 'descricao' => 'EX-ALUNO'],
            (object)['valor' => 'C', 'descricao' => 'CONVIDADO'],
        ];

        $titulacoes = [
            (object)['valor' => 'D', 'descricao' => 'DOUTORADO'],
            (object)['valor' => 'M', 'descricao' => 'MESTRADO'],
            (object)['valor' => 'PG', 'descricao' => 'PÓS-GRADUADO (ESPECIALIZAÇÃO)'],
            (object)['valor' => 'L', 'descricao' => 'LICENCIATURA'],
            (object)['valor' => 'B', 'descricao' => 'GRADUADO'],
        ];

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
        $data = [];
        if(isset($request->selectTipo)) {
            foreach ($request->selectTipo as $key => $value) {
                switch ($value) {
                    case 'F':
                        $data += $request->except(['cargo_docente', 'titulacao', 'lattes_docente', 'link_compartilhado', 'exibe_dados_docente', 'matricula', 'curso']);
                    break;
                    case 'D':
                        $data += $request->except(['cargo_funcionario', 'departamento_funcionario', 'matricula', 'exibe_dados_funcionario', 'lattes_funcionario', 'curso']);
                    break;
                    case 'A':
                    //case 'EX':
                        $data += $request->except(['cargo_funcionario', 'departamento_funcionario', 'cargo_docente', 'titulacao', 'lattes_docente', 'exibe_dados_docente', 'exibe_dados_funcionario', 'lattes_funcionario', 'link_compartilhado']);
                    break;
                    default:
                        $data += $request->except(['cargo_funcionario', 'departamento_funcionario', 'cargo_docente', 'titulacao', 'lattes_docente', 'exibe_dados_docente', 'exibe_dados_funcionario', 'lattes_funcionario', 'link_compartilhado', 'matricula', 'curso']);
                    break;
                }
            }
        } else {
            session()->flash('msg', 'Você deve informar pelo menos um tipo de usuário');
            session()->flash('status', 'error');
            return redirect()->back();
        }

        $authUser = $request->user();
        //$plainPassword = '';
        
        //Verifica se foi informada uma senha no cadastro, caso contrário é gerada uma senha aleatória
        if (isset($data['password'])){
            $plainPassword = $data['password'];
            $data['password'] = bcrypt($plainPassword);
        } else {
            //gerar senha aleatoria no create        
            $plainPassword = str_random(8);        
            $data['password'] = bcrypt($plainPassword);            
        }
                        
        //validar dados
        foreach ($request->selectTipo as $key => $value) {
            if($value == 'A') {
                $validacao = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($authUser->id)],
                    'password' => 'required|string|min:6',
                    'cpf' => 'required|string|unique:users',
                    'selectTipo' => 'required',
                    'sexo' => 'required',
                    'telefone' => 'nullable|string',
                    'ativo' => 'required',
                    'matricula' => 'required|numeric',                
                    'curso' => 'required',
                ])->validate();            
            } else if($value == 'F') {                
                $validacao = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($authUser->id)],
                    'password' => 'required|string|min:6',
                    'cpf' => 'required|string|unique:users',
                    'selectTipo' => 'required',
                    'sexo' => 'required',
                    'telefone' => 'nullable|string',
                    'ativo' => 'required',
                    'lattes_funcionario' => 'nullable|url',                
                ])->validate();
            } else if($value == 'D'){
                $validacao = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($authUser->id)],
                    'password' => 'required|string|min:6',
                    'cpf' => 'required|string|unique:users',
                    'selectTipo' => 'required',
                    'sexo' => 'required',
                    'telefone' => 'nullable|string',
                    'ativo' => 'required',
                    'lattes_docente' => 'nullable|url',                
                ])->validate();
            } else {
                $validacao = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($authUser->id)],
                    'password' => 'required|string|min:6',
                    'cpf' => 'required|string|unique:users',
                    'selectTipo' => 'required',
                    'sexo' => 'required',
                    'telefone' => 'nullable|string',
                    'ativo' => 'required',                    
                ])->validate();
            } 
        }
           
        //gravar dados após validacao, usando transaction
        if($validacao){
            try {
                \DB::beginTransaction();
                   
                $user = User::firstOrCreate([
                    'nome' => $data['nome'],
                    'cpf' => $data['cpf'],
                    'sexo' => $data['sexo'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'token' => bcrypt($data['cpf'].'#'.$data['email'].'#'.$data['nome']),
                    'telefone' => $data['telefone'],
                    'ativo' => $data['ativo'],
                    'tipo' => implode(',', $data['selectTipo']),
                    'url_lattes' => $data['url_lattes'],
                ]);            
                
                foreach (explode(',',$user->tipo) as $key => $value) {
                    if($value == 'F') {
                        $create = Funcionario::firstOrCreate([                    
                            'cargo_id' => $data['cargo_funcionario'],
                            'departamento_id' => $data['departamento_funcionario'],
                            'user_id' => $user->id,
                        ]);     
                    } else if($value == 'D') {
                        $create = Docente::firstOrCreate([
                            'link_compartilhado' => $data['link_compartilhado'],
                            'titulacao' => $data['titulacao'],
                            'cargo_id' => $data['cargo_docente'], 
                            'user_id' => $user->id,
                        ]);    
                    } else if ($value == 'A'  || $value == 'EX') {
                        $create = Aluno::firstOrCreate([
                            'matricula' => $data['matricula'],
                            'curso_id' => $data['curso'],
                            'user_id' => $user->id,
                        ]);    
                       
                    }             
                }
                
                if($user && $create) {
                    
                    //vincular os perfis ao usuario
                    if(isset($data['perfis'])){
                        foreach ($data['perfis'] as $key => $value) {
                            $user->perfis()->attach($value);
                        }
                    }
    
                    \DB::commit();
                    session()->flash('msg', 'Registro cadastrado com sucesso!');
                    session()->flash('status', 'success');                
                    
                    //enviar email ao usuario com senha descriptografada - plainPassword                                    
                    //$this->sendEmailToNewUser($user); 
                    event(new NovoUsuario($user));
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
                
        $page = 'Adicionar';
        $rotaNome = $this->route;
        $tituloPagina = 'Alterar Usuário: '.$registro->nome;
        $descricaoPagina = 'Alterar dados do usuário do sistema';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Usuários'],
            (object)['url' => '', 'title' => $page],
        ];

        $tiposUsers = [
            (object)['valor' => 'F', 'descricao' => 'FUNCIONÁRIO'],
            (object)['valor' => 'D', 'descricao' => 'DOCENTE'],
            (object)['valor' => 'A', 'descricao' => 'ALUNO'],
            //(object)['valor' => 'EX', 'descricao' => 'EX-ALUNO'],
            (object)['valor' => 'C', 'descricao' => 'CONVIDADO'],
        ];

        $titulacoes = [
            (object)['valor' => 'D', 'descricao' => 'DOUTORADO'],
            (object)['valor' => 'M', 'descricao' => 'MESTRADO'],
            (object)['valor' => 'PG', 'descricao' => 'PÓS-GRADUADO (ESPECIALIZAÇÃO)'],
            (object)['valor' => 'L', 'descricao' => 'LICENCIATURA'],
            (object)['valor' => 'B', 'descricao' => 'GRADUADO'],
        ];

        //recupero os tipos de usuário cadastrado
        $array = explode(',', $registro->tipo);
        $arrayTipos = [];
        for($i = 0; $i < count($array); $i++)
        {
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
        if(isset($request->selectTipo)) {
            foreach ($request->selectTipo as $key => $value) {
                switch ($value) {
                    case 'F':
                        $data += $request->except(['cargo_docente', 'titulacao', 'lattes_docente', 'link_compartilhado', 'exibe_dados_docente', 'matricula', 'curso']);
                    break;
                    case 'D':
                        $data += $request->except(['cargo_funcionario', 'departamento_funcionario', 'matricula', 'exibe_dados_funcionario', 'lattes_funcionario', 'curso']);
                    break;
                    case 'A':
                    //case 'EX':
                        $data += $request->except(['cargo_funcionario', 'departamento_funcionario', 'cargo_docente', 'titulacao', 'lattes_docente', 'exibe_dados_docente', 'exibe_dados_funcionario', 'lattes_funcionario', 'link_compartilhado']);
                    break;
                    default:
                        $data += $request->except(['cargo_funcionario', 'departamento_funcionario', 'cargo_docente', 'titulacao', 'lattes_docente', 'exibe_dados_docente', 'exibe_dados_funcionario', 'lattes_funcionario', 'link_compartilhado', 'matricula', 'curso']);
                    break;
                }
            }
        } else {
            session()->flash('msg', 'Você deve informar pelo menos um tipo de usuário');
            session()->flash('status', 'error');
            return redirect()->back();
        }
                        
        //Verifica se foi informada uma senha no cadastro, caso contrário é gerada uma senha aleatória
        $plainPassword = '';
        if (isset($data['password'])){
            $plainPassword = $data['password'];
            $data['password'] = bcrypt($plainPassword);
        } else {
            unset($data['password']);
        }
                        
        //validar dados
        foreach ($request->selectTipo as $key => $value) {
            if($value == 'A') {
                $validacao = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($id)],
                    'password' => 'sometimes|required|string|min:6',
                    'cpf' => ['required','string', Rule::unique('users')->ignore($id)],
                    'selectTipo' => 'required',
                    'sexo' => 'required',
                    'telefone' => 'nullable|string',
                    'ativo' => 'required',
                    'matricula' => 'required|numeric',                
                    'curso' => 'required',
                ])->validate();            
            } else if($value == 'F') {                
                $validacao = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($id)],
                    'password' => 'sometimes|required|string|min:6',
                    'cpf' => ['required','string', Rule::unique('users')->ignore($id)],
                    'selectTipo' => 'required',
                    'sexo' => 'required',
                    'telefone' => 'nullable|string',
                    'ativo' => 'required',
                    'lattes_funcionario' => 'nullable|url',                
                ])->validate();
            } else if($value == 'D'){
                $validacao = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($id)],
                    'password' => 'sometimes|required|string|min:6',
                    'cpf' => ['required','string', Rule::unique('users')->ignore($id)],
                    'selectTipo' => 'required',
                    'sexo' => 'required',
                    'telefone' => 'nullable|string',
                    'ativo' => 'required',
                    'lattes_docente' => 'nullable|url',                
                ])->validate();
            } else {
                $validacao = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($id)],
                    'password' => 'sometimes|required|string|min:6',
                    'cpf' => ['required','string', Rule::unique('users')->ignore($id)],
                    'selectTipo' => 'required',
                    'sexo' => 'required',
                    'telefone' => 'nullable|string',
                    'ativo' => 'required',                    
                ])->validate();
            } 
        }
           
        //gravar dados após validacao, usando transaction
        if($validacao){
            try {
                \DB::beginTransaction();
                                
                $data['tipo'] = implode(',', $data['selectTipo']);
                unset($data['selectTipo']);                

                if(count($user->perfis)) {
                    foreach ($user->perfis as $key => $value) {
                        $user->perfis()->detach($value->id);
                    }
                }
                //vincular os perfis ao usuario
                if(isset($data['perfis']) && count($data['perfis'])){
                    foreach ($data['perfis'] as $key => $value) {
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
                        $createFuncionario = Funcionario::firstOrCreate([                    
                            'cargo_id' => $data['cargo_funcionario'],
                            'departamento_id' => $data['departamento_funcionario'],
                            'user_id' => $id,
                        ]);     
                    } else if($value == 'D') {                        
                        $createDocente = Docente::firstOrCreate([
                            'link_compartilhado' => $data['link_compartilhado'],
                            'titulacao' => $data['titulacao'],
                            'cargo_id' => $data['cargo_docente'], 
                            'user_id' => $id,
                        ]);

                    } else if ($value == 'A'  || $value == 'EX') {
                        $createAluno = Aluno::firstOrCreate([
                            'matricula' => $data['matricula'],
                            'curso_id' => $data['curso'],
                            'user_id' => $id,
                        ]);
                    }             
                }

                $itensRemove = array_diff($arrayTiposOriginal, $arrayTiposNovo);                
                echo '<br>Itens a Remover: '.json_encode($itensRemove);
                foreach ($itensRemove as $key => $value) {
                    if($value == 'F') {                        
                        $deleteFuncionario = Funcionario::find($id)->delete();
                    } else if($value == 'D') {
                        $deleteDocente = Docente::find($id)->delete();    
                    } else if ($value == 'A') {
                        $deleteAluno = Aluno::find($id)->delete(); 
                    }             
                }

                //se nao tem item a inserir ou remover, entao, atualiza as informacoes
                foreach ($request->selectTipo as $key => $value) {
                    
                    if($value == 'F') {                         
                        $updateFuncionario = Funcionario::find($id)->update(['cargo_id' => $data['cargo_funcionario'], 'departamento_id' => $data['departamento_funcionario'], 'user_id' => $id]);                        
                    } else if($value == 'D') {
                        $updateDocente = Docente::find($id)->update(['cargo_id' => $data['cargo_docente'], 'titulacao' => $data['titulacao'], 'user_id' => $id, 'link_compartilhado' => $data['link_compartilhado']]);    
                    } else if ($value == 'A') {
                        $updateAluno = Aluno::find($id)->update(['matricula' => $data['matricula'], 'curso_id' => $data['curso'], 'user_id' => $id,]); 
                    }             
                }
                
                $updateUser = $user->update($data);
                
                if($updateUser && ((isset($createFuncionario) && $createFuncionario) || 
                                    (isset($createDocente) && $createDocente) || 
                                    (isset($createAluno) && $createAluno) || 
                                    (isset($deleteDocente) && $deleteDocente) ||
                                    (isset($deleteFuncionario) && $deleteFuncionario) ||
                                    (isset($deleteAluno) && $deleteAluno) ||
                                    (isset($updateAluno) && $updateAluno) ||
                                    (isset($updateFuncionario) && $updateFuncionario) ||
                                    (isset($updateDocente) && $updateDocente)) ) {                                        
                    \DB::commit();
                    session()->flash('msg', 'Registro alterado com sucesso!');
                    session()->flash('status', 'success');                    
                } else if($updateUser && !((isset($createFuncionario) && $createFuncionario) || 
                                            (isset($createDocente) && $createDocente) || 
                                            (isset($createAluno) && $createAluno) || 
                                            (isset($deleteDocente) && $deleteDocente) ||
                                            (isset($deleteFuncionario) && $deleteFuncionario) ||
                                            (isset($deleteAluno) && $deleteAluno)
                                            (isset($updateAluno) && $updateAluno) ||
                                            (isset($updateFuncionario) && $updateFuncionario) ||
                                            (isset($updateDocente) && $updateDocente)) ) {                                        
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

    public function sendEmailToNewUser($user)
    {   
        //dispatch(new SendEmailToNewUserJob($user));
        Mail::to($user->email)->queue(new SendEmailToNewUser($user));
    }
}
