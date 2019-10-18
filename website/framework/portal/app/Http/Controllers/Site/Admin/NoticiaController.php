<?php

namespace App\Http\Controllers\Site\Admin;

use App\Classes\Conversoes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sistema\Noticias\Noticia;
use App\Models\Sistema\Gerenciamento\Imagens\Imagem;

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
            $list = Noticia::orderBy('id', 'DESC')->get();
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
        Noticia::create(['titulo' => $request->titulo, 'conteudo' => $request->editor, 'ativo' => $request->status, 'user_id' => auth()->user()->id, 'data_exibicao' => ($date ?? null)]);        
        
        session()->flash('msg', 'Registro cadastrado com sucesso!');
        session()->flash('status', 'success');

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

    public function uploadFileForm($id)
    {   
        $noticia = Noticia::find($id);
        return view('site.admin.'.$this->route.'.upload.file', compact('noticia'));
    }

    public function uploadImageForm($id)
    {  
        $page = 'Upload';
        $rotaNome = $this->route;
        $tituloPagina = 'Envio de imagens';
        $descricaoPagina = 'Uploads de imagens da notícia';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Notícia'],
            (object)['url' => '', 'title' => $page],
        ];  
        $noticia = Noticia::findOrFail($id);        
        return view('site.admin.'.$this->route.'.upload.image', compact('noticia', 'page', 'rotaNome', 'tituloPagina', 'descricaoPagina', 'breadcrumb'));        
    }

    public function uploadImage(Request $request)
    {
        //Validar informacoes
        
        if($request->hasFile('imagens')) {
            $files = $request->file('imagens');
            $noticia = Noticia::findOrFail($request->noticiaId);

            $storagePath = \storage_path().'/imagens/noticias/'.$request->noticiaId;

            $ordem = 1;
            foreach ($files as $file) {                                
                $size = $file->getSize();
                $fileName = md5($file->getClientOriginalName()).'.'.$file->extension();
                
                if(!\file_exists($storagePath.'/'.$fileName)) {
                    $file->move($storagePath, $fileName);
                
                    $imagem = Imagem::firstOrCreate(['titulo' => $request->titulo_imagens, 
                                                    'descricao' => $request->descricao_imagens, 
                                                    'tamanho_arquivo' => $size,
                                                    'nome_arquivo' => $fileName]);
                    
                    if($noticia->imagens()->count()) {                        
                        $aux = $noticia->imagens()->orderBy('ordem','DESC')->first();
                        $ordem = $aux->pivot->ordem + 1;
                    }                    
                    $imagem->noticias()->save($noticia, ['ordem' => $ordem]);
                    session()->flash('msg', 'Imagem(ns) enviadas com sucesso!');
                    session()->flash('status', 'success');    
                } else {
                    session()->flash('msg', 'O sistema detectou que esses arquivos já foram enviados!');
                    session()->flash('status', 'error');
                }                  
            }
        }
        return redirect()->back();
    }
}
