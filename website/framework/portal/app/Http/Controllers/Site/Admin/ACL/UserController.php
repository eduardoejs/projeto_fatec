<?php

namespace App\Http\Controllers\Site\Admin\ACL;

use App\Models\Acl\User;
use App\Models\Acl\Perfil;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use App\Mail\SendEmailNewUser;
use Illuminate\Validation\Rule;
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
            (object)['valor' => 'EX', 'descricao' => 'EX-ALUNO'],
            (object)['valor' => 'C', 'descricao' => 'CONVIDADO'],
        ];

        $perfis = Perfil::orderBy('nome', 'ASC')->get();
        $cargos = Cargo::orderBy('nome', 'ASC')->get();
        $departamentos = Departamento::all();
        $cursos = Curso::all();

        return view('site.admin.acl.'.$this->route.'.create', compact('perfis','breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome', 'cargos', 'departamentos', 'cursos', 'tiposUsers'));
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
                    case 'EX':
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
        $plainPassword = '';
        
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
            if($value == 'A' || $value == 'EX') {
                $validacao = Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($authUser->id)],
                    'password' => 'required|string|min:6',
                    'cpf' => 'required|string|unique:users',
                    'selectTipo' => 'required',
                    'sexo' => 'required',
                    'fone' => 'nullable|string',
                    'status' => 'required',
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
                    'fone' => 'nullable|string',
                    'status' => 'required',
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
                    'fone' => 'nullable|string',
                    'status' => 'required',
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
                    'fone' => 'nullable|string',
                    'status' => 'required',                    
                ])->validate();
            } 
        }
           
        //gravar dados após validacao, usando transaction
        try {
            \DB::beginTransaction();
                       
            
            $user = User::firstOrCreate([
                'nome' => $data['nome'],
                'cpf' => $data['cpf'],
                'sexo' => $data['sexo'],
                'email' => $data['email'],
                'password' => $data['password'],
                'telefone' => $data['fone'],
                'ativo' => $data['status'],
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

                session()->flash('msg', 'Registro cadastrado com sucesso!');
                session()->flash('status', 'success');
                \DB::commit();

                /*try {
                    //enviar email ao usuario com senha descriptografada - plainPassword
                    $user->plainPassword = $plainPassword;                 
                    Mail::to($user->email)->queue(new SendEmailNewUser($user));
                    session()->flash('msg', 'E-mail com os dados de acesso foram enviados ao novo usuário!');
                    session()->flash('status', 'success');
                } catch (\Exception $ex) {
                    session()->flash('msg', 'Erro ao enviar e-mail com os dados de acesso: ' . $ex->getMessage());
                    session()->flash('status', 'error');            
                }*/
            } else {
                // session()->flash('msg', 'Erro: Rollback aplicado!');
                // session()->flash('status', 'error');
                \DB::rollback();
            }
            
        } catch (\PDOException $e) {
            \DB::rollback();
            session()->flash('msg', 'Erro inesperado ao inserir registro: ' . $e->getMessage());
            session()->flash('status', 'error');
        } 

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
