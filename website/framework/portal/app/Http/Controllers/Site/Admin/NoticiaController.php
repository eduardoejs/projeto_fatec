<?php

namespace App\Http\Controllers\Site\Admin;

use Image;
use App\Classes\Conversoes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ImageRepository;
use App\Models\Sistema\Noticias\Noticia;
use Illuminate\Support\Facades\Validator;
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
        $noticia = Noticia::findOrFail($id);
        $page = 'Upload';
        $rotaNome = $this->route;
        $tituloPagina = 'Envio de imagens';
        $descricaoPagina = 'Uploads de imagens da notícia: <strong>' . $noticia->titulo . '</strong>';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Notícia'],
            (object)['url' => '', 'title' => $page],
        ];          
        
        $colunas = ['id' => 'ID', 'arquivo' =>'Imagem', 'created_at' => 'Enviado em', 'tamanho_arquivo' => 'Tamanho', 'tipo' => 'Tipo'];        
        $list = Noticia::with('imagens')->findOrFail($id);        

        return view('site.admin.'.$this->route.'.upload.image', compact('noticia', 'page', 'rotaNome', 'tituloPagina', 'descricaoPagina', 'breadcrumb', 'colunas', 'list'));        
    }

    public function uploadImage(Request $request, ImageRepository $repository)
    {   
        $files = $request->file('imagens');
        
        //Valida os arquivos de imagem
        $rules = [
            'imagem' => 'required|image|dimensions:min_width=800,min_height=600',
        ];

        foreach ($files as $imagem) {
            $array = ['imagem' => $imagem];
            $validator = Validator::make($array, $rules);
            if($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->messages())
                    ->withInput(); 
            }
        }
        
        if($request->hasFile('imagens')) { 
            
            $noticia = Noticia::findOrFail($request->noticiaId);                        
            $ordem = 1;            

            foreach ($files as $file) {                                
                $fileName = $repository->moveImage($file, $noticia, 'noticias', true);

                if(!\is_null($fileName)) {
                    $imagem = Imagem::firstOrCreate(['titulo' => null, 
                                                    'descricao' => null, 
                                                    'tamanho_arquivo' => $file->getSize(),
                                                    'nome_arquivo' => ($fileName ?? null)]);
                    
                    if($noticia->imagens()->count()) {                        
                        $aux = $noticia->imagens()->orderBy('ordem','DESC')->first();
                        $ordem = $aux->pivot->ordem + 1;
                    }                    
                    $imagem->noticias()->save($noticia, ['ordem' => $ordem]);
                    session()->flash('msg', 'Imagem(ns) enviadas com sucesso!');
                    session()->flash('status', 'success');    
                } else {
                    session()->flash('msg', 'Ocorreu um erro ao enviar arquivo!');
                    session()->flash('status', 'error');
                } 
            }
        }
        return redirect()->back();
    }
}
