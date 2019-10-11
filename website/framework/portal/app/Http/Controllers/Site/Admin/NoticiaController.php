<?php

namespace App\Http\Controllers\Site\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sistema\Noticias\Noticia;

class NoticiaController extends Controller
{
    private $route = 'noticia';
    private $paginacao = 30;
    private $search = ['titulo'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('read-noticias');
        $search = "";        
        if(isset($request->search)) 
        {   
            $search = $request->search;
            $noticia = Noticia::class;
            foreach($this->search as $key => $value) {    
                $noticia = Noticia::orWhere($value, 'like', '%'.$search.'%');                
            }            
            $list = $noticia->orderBy('id', 'DESC')->paginate($this->paginacao);
        }else{
            $list = Noticia::all();
        }

        $rotaNome = $this->route;        
        $page = 'Notícias';        
        $tituloPagina = 'Notícias do Sistema';
        $descricaoPagina = 'Gerenciamento de Notícias do sistema';
        $colunas = ['id' => 'ID', 'titulo' => 'Título da notícia', 'exibir' => 'Visualizar até', 'user' => 'Publicado por', 'status' => 'Ativo'];

        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],
            (object)['url' => '', 'title' => $page],
        ];         
        return view('site.admin.'.$this->route.'.index', compact('breadcrumb', 'page', 'list', 'colunas', 'rotaNome', 'tituloPagina', 'descricaoPagina', 'search'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-noticias');

        $page = 'Adicionar';
        $rotaNome = $this->route;
        $tituloPagina = 'Adicionar Notícia';
        $descricaoPagina = 'Cadastro de nova notícia';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Notícia'],
            (object)['url' => '', 'title' => $page],
        ]; 
        $noticias = Noticia::all();
        return view('site.admin.'.$this->route.'.create', compact('noticias','breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {           
        if(isset($request->data_exibicao)) {
            $date = date('Y-m-d', strtotime(str_replace("/", "-", $request->data_exibicao)));
        }        
        Noticia::create(['titulo' => $request->titulo, 'conteudo' => $request->editor1, 'ativo' => $request->status, 'user_id' => auth()->user()->id, 'data_exibicao' => ($date ?? null)]);
        return redirect()->route('noticia.index');
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
}
