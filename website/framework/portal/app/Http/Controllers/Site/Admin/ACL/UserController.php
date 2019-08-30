<?php

namespace App\Http\Controllers\Site\Admin\ACL;

use App\Models\Acl\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $route = 'user';    
    private $search = ['nome', 'email'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = "";
        if(isset($request->search)){
            $search = $request->search;
            $user = User::class;
            foreach($this->search as $key => $value) {
                $user = User::orWhere($value, 'like', '%'.$search.'%');
            }
            $list = $user->orderBy('ativo', 'ASC')->orderBy('nome', 'ASC')->get();
        }else{
            $list = User::orderBy('ativo', 'ASC')->orderBy('nome', 'ASC')->get();
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
        return view('site.admin.acl.'.$this->route.'.index', compact('breadcrumb', 'page', 'list', 'colunas', 'rotaNome', 'tituloPagina', 'descricaoPagina', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
