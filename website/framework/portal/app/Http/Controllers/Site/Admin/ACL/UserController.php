<?php

namespace App\Http\Controllers\Site\Admin\ACL;

use App\Models\Acl\User;
use App\Models\Acl\Perfil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        //$this->authorize('read-user');

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
        $page = 'Adicionar';
        $rotaNome = $this->route;
        $tituloPagina = 'Adicionar Usuário';
        $descricaoPagina = 'Cadastro de novo usuário do sistema';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Usuário'],
            (object)['url' => '', 'title' => $page],
        ]; 
        $perfis = Perfil::all();

        return view('site.admin.acl.'.$this->route.'.create', compact('perfis','breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
