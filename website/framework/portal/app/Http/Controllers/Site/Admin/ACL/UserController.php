<?php

namespace App\Http\Controllers\Site\Admin\ACL;

use App\Models\Acl\User;
use App\Models\Acl\Perfil;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
                $query = $query->orWhere($value, 'like', '%'.$search.'%')->where('tipo', $filtro);                
            }            
            $list = $query->orderBy('ativo', 'ASC')->orderBy('nome', 'ASC')->paginate($this->paginacao);
        }else{
            $list = User::where('tipo', 'F')->orderBy('ativo', 'ASC')->orderBy('nome', 'ASC')->paginate($this->paginacao);
        }  

        $colunas = ['id' => 'ID', 'nome' => 'Nome', 'email' => 'E-Mail', 'tipoUser' => 'Tipo', 'status' => 'Status'];
        
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

        $perfis = Perfil::orderBy('nome', 'ASC')->get();
        $cargos = Cargo::orderBy('nome', 'ASC')->get();
        $departamentos = Departamento::all();
        $cursos = Curso::all();

        return view('site.admin.acl.'.$this->route.'.create', compact('perfis','breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome', 'cargos', 'departamentos', 'cursos'));
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
            switch ($request->selectTipo) {
                case 'F':
                    $data = $request->except(['cargo_docente', 'titulacao', 'lattes_docente', 'link_compartilhado', 'exibe_dados_docente', 'matricula', 'curso']);
                break;
                case 'D':
                    $data = $request->except(['cargo_funcionario', 'departamento_funcionario', 'matricula', 'exibe_dados_funcionario', 'lattes_funcionario', 'curso']);
                break;
                case 'A':
                case 'EX':
                    $data = $request->except(['cargo_funcionario', 'departamento_funcionario', 'cargo_docente', 'titulacao', 'lattes_docente', 'exibe_dados_docente', 'exibe_dados_funcionario', 'lattes_funcionario', 'link_compartilhado']);
                break;
                default:
                    $data = $request->except(['cargo_funcionario', 'departamento_funcionario', 'cargo_docente', 'titulacao', 'lattes_docente', 'exibe_dados_docente', 'exibe_dados_funcionario', 'lattes_funcionario', 'link_compartilhado', 'matricula', 'curso']);
                break;
            }            
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
        if($data['selectTipo'] == 'A' || $data['selectTipo'] == 'EX') {
            $validacao = Validator::make($data, [
                'nome' => 'required|string|max:255',
                'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($authUser->id)],
                'password' => 'required|string|min:6',
                'cpf' => 'required|string|unique:users',
                'selectTipo' => 'required',
                'sexo' => 'required',
                'fone' => 'nullable|string',
                'status' => 'required',
                'matricula' => 'required|string',                
                'curso' => 'required',
            ])->validate();
        } else if($data['selectTipo'] == 'F') {                
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
        } else if($data['selectTipo'] == 'D'){
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
        
        //gravar dados após validacao, usando transaction
        try {
            \DB::beginTransaction();
            
            $user = User::create([
                'nome' => $data['nome'],
                'cpf' => $data['cpf'],
                'sexo' => $data['sexo'],
                'email' => $data['email'],
                'password' => $data['password'],
                'telefone' => $data['fone'],
                'ativo' => $data['status'],
                'tipo' => $data['selectTipo'],
            ]);
            
            if($data['selectTipo'] == 'F') {
                $funcionario = Funcionario::create([
                    'url_lattes' => $data['lattes_funcionario'],
                    'exibe_dados' => $data['exibe_dados_funcionario'],
                    'cargo_id' => $data['cargo_funcionario'],
                    'departamento_id' => $data['departamento_funcionario'],
                    'user_id' => $user->id,
                ]);
            } else if($data['selectTipo'] == 'D') {
                $docente = Docente::create([
                    'url_lattes' => $data['lattes_docente'],
                    'exibe_dados' => $data['exibe_dados_docente'],
                    'cargo_id' => $data['cargo_docente'], 
                    'link_compartilhado' => $data['link_compartilhado'],
                    'titulacao' => $data['titulacao'],
                    'user_id' => $user->id,
                ]);
            } else if ($data['selectTipo'] == 'A'  || $data['selectTipo'] == 'EX') {
                $aluno = Aluno::create([
                    'matricula' => $data['matricula'],
                    'curso_id' => $data['curso'],
                    'user_id' => $user->id,
                ]);
            } //se o tipo for "C" já é o próprio objeto user definido acima

            //vincular os perfis ao usuario
            if(isset($data['perfis'])){
                foreach ($data['perfis'] as $key => $value) {
                    $user->perfis()->attach($value);
                }
            }

            session()->flash('msg', 'Registro cadastrado com sucesso!');
            session()->flash('status', 'success');
            \DB::commit();            
        } catch (\PDOException $e) {
            session()->flash('msg', 'Erro inesperado ao inserir registro: ' . $e->getMessage());
            session()->flash('status', 'error');
            \DB::rollback();
        }     
        
        //enviar email ao usuario com senha descriptografada - plainPassword

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
