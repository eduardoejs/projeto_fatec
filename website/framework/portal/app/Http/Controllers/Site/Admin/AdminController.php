<?php

namespace App\Http\Controllers\Site\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {           
        return view('site.admin.index');
    }

    public function indexACL()
    {        
        $page = 'ACL';
        $pageHeaderTitle = 'ACL - Access Control List';
        $bodyPageTitle = '';
        //$bodyPageDescription = 'Gerenciamento dos perfis de usuários do sistema';
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],            
            (object)['url' => '', 'title' => $page],
        ];
        $cards = [
            (object)['titulo' => 'Perfil de usuários do sistema', 'descricao' => 'Adicione, visualize, altere e exclua os perfis de usuários do sistema.', 'icon' => 'fa-vcard-o', 'col' => '4', 'route' => route('perfil.index')],
            (object)['titulo' => 'Permissões do sistema', 'descricao' => 'Adicione, visualize, altere e exclua as permissões do sistema.', 'icon' => 'fa-unlock-alt', 'col' => '4', 'route' => route('permissao.index')],
            (object)['titulo' => 'Usuários do Sistema', 'descricao' => 'Adicione, visualize, altere e exclua os dados dos usuários do sistema.', 'icon' => 'fa-user-o', 'col' => '4', 'route' => route('user.index')],
            (object)['titulo' => 'Vincular Permissões com Perfil', 'descricao' => 'Vincula Permissões ao deteminado Perfil de usuário do sistema.', 'icon' => 'fa-retweet', 'col' => '4', 'route' => '#'],
            (object)['titulo' => 'Vincular Perfil com Usuário', 'descricao' => 'Vincula um ou mais Perfis com um usuário do sistema.', 'icon' => 'fa-retweet', 'col' => '4', 'route' => '#'],
            
        ];         
        return view('site.admin.acl.index', compact('cards', 'page', 'pageHeaderTitle', 'breadcrumb'));
    }
}
