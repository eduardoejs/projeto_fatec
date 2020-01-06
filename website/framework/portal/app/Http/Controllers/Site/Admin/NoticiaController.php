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
        $this->authorize('create-noticias'); 
                
        $validacao = \Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required',
        ])->validate();

        if($validacao) {

            if(isset($request->data_exibicao)) {
                $date = date('Y-m-d', strtotime(str_replace("/", "-", $request->data_exibicao)));
            }        
            Noticia::create(['titulo' => $request->titulo, 'conteudo' => $request->conteudo, 'ativo' => $request->status, 'user_id' => auth()->user()->id, 'data_exibicao' => ($date ?? null)]);        
            
            session()->flash('msg', 'Registro cadastrado com sucesso!');
            session()->flash('status', 'success');

            return redirect()->route($this->route.'.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $registro = Noticia::findOrFail($id);
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
                    (object)['url' => route('noticia.index'), 'title' => 'Notícia'],
                    (object)['url' => '', 'title' => $page],
                ];
            } else {
                $page = 'Detalhes';
                $rotaNome = $this->route;                        
                $tituloPagina = 'Notícia: ' . $registro->titulo;
                $descricaoPagina = '';
                $breadcrumb = [
                    (object)['url' => route('admin'), 'title' => 'Dashboard'],                    
                    (object)['url' => route('noticia.index'), 'title' => 'Notícia'],
                    (object)['url' => '', 'title' => $page],
                ];
            }
            return view('site.admin.'.$this->route.'.show', compact('registro', 'delete', 'breadcrumb', 'page', 'delete', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
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
        $this->authorize('edit-noticias');
        $registro = Noticia::findOrFail($id);
                
        $page = 'Alterar';
        $rotaNome = $this->route;
        $tituloPagina = 'Alterar notícia: '.$registro->nome;
        $descricaoPagina = 'Alterar dados da notícia';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Notícia'],
            (object)['url' => '', 'title' => $page],
        ];

        return view('site.admin.'.$this->route.'.edit', compact('registro', 'breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
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
        $this->authorize('edit-noticias');

        $validacao = \Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required',
        ])->validate();

        if($validacao) {
            $noticia = Noticia::findOrFail($id);            
            if(isset($request->data_exibicao)) {
                $date = date('Y-m-d', strtotime(str_replace("/", "-", $request->data_exibicao)));
            }        
            $noticia->update(['titulo' => $request->titulo, 'conteudo' => $request->conteudo, 'ativo' => $request->status, 'user_id' => auth()->user()->id, 'data_exibicao' => ($date ?? null)]);
            session()->flash('msg', 'Registro atualizado com sucesso');
            session()->flash('title', 'Sucesso!');
            session()->flash('status', 'success');
        }
        return redirect()->route($this->route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ImageRepository $repositoryImage)
    {
        $this->authorize('delete-noticia');
        
        $noticia = Noticia::findOrFail($id);

        try {
            if($noticia) {

                /***
                 * remover diretorio com imagens e documentos
                 * 
                 * */
                
                //remove as imagens do diretório 
                $repositoryImage->removeImages('noticias', $noticia);

                //remove as imagens no banco de dados associadas à notícia
                foreach($noticia->imagens as $imagem) {
                    $imagem->delete();
                }

                //remove a notícia
                $noticia->delete();

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

    public function uploadFileForm($id)
    {   
        $noticia = Noticia::find($id);
        $page = 'Anexar Arquivos';
        $rotaNome = $this->route;
        $tituloPagina = 'Envio de arquivos';
        $descricaoPagina = 'Uploads de arquivos da notícia: <strong>' . $noticia->titulo . '</strong>';

        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Notícia'],
            (object)['url' => '', 'title' => $page],
        ];          
        
        $colunas = ['id' => 'ID', 'arquivo' =>'File', 'created_at' => 'Enviado em', 'tamanho_arquivo' => 'Tamanho', 'tipo' => 'Tipo'];        
        $list = Noticia::with('arquivos')->findOrFail($id);         

        return view('site.admin.'.$this->route.'.upload.file', compact('noticia', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome', 'breadcrumb', 'colunas', 'list'));
    }

    public function uploadImageForm($id)
    {  
        $noticia = Noticia::findOrFail($id);
        $page = 'Anexar Imagens';
        $rotaNome = $this->route;
        $tituloPagina = 'Envio de imagens';
        $descricaoPagina = 'Uploads de imagens da notícia: <strong>' . $noticia->titulo . '</strong>';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Notícia'],
            (object)['url' => '', 'title' => $page],
        ];          
        
        $colunas = ['id' => 'ID', 'arquivo' =>'Imagem', 'created_at' => 'Enviado em', 'tamanho_arquivo' => 'Tamanho', 'tipo' => 'Tipo', 'ordem' => 'Capa Notícia'];        
        $list = Noticia::with('imagens')->findOrFail($id); 
        return view('site.admin.'.$this->route.'.upload.image', compact('noticia', 'page', 'rotaNome', 'tituloPagina', 'descricaoPagina', 'breadcrumb', 'colunas', 'list'));        
    }

    public function uploadImage(Request $request, ImageRepository $repository)
    {   
        $files = $request->file('imagens');        
        $rules = [
            'imagem' => 'required|image|dimensions:min_width=800,min_height=600',
        ];
        
        if($request->hasFile('imagens')) {
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
                    //associo a imagem à notícia no banco de dados                   
                    $imagem->noticias()->attach($noticia, ['ordem' => $ordem]);
                    session()->flash('msg', 'Imagem(ns) enviadas com sucesso!');
                    session()->flash('status', 'success');    
                } else {
                    session()->flash('msg', 'Ocorreu um erro ao enviar arquivo!');
                    session()->flash('status', 'error');
                } 
            }
        } else {
            session()->flash('msg', 'Você deve selecionar uma imagem!');
            session()->flash('status', 'error');
        }        
        return redirect()->back();
    }

    public function destroySingleImage($id, $imagemId, ImageRepository $repository)
    {      
        $noticia = Noticia::findOrFail($id);
        $imagem = Imagem::with('noticias')->findOrFail($imagemId); 
        $repository->removeImages('noticias', $noticia, $imagem->nome_arquivo);
        $imagem->noticias()->detach($noticia);
        $imagem->delete();
        session()->flash('msg', 'Imagem removida com sucesso!');
        session()->flash('status', 'success');
        return redirect()->back();
    }

    public function setCapa($id, $imagemId)
    {        
        $noticia = Noticia::findOrFail($id);
        $imagem = Imagem::with('noticias')->findOrFail($imagemId);        
        $ordemReplace = $noticia->imagens()->where('imagem_noticia.imagem_id', $imagemId)->first()->pivot->ordem;
        $imageReplace = $noticia->imagens()->where('imagem_noticia.ordem',1)->first(); 
        
        //Não há imagens com campo ordem = 1
        if($imageReplace){
            $imageReplace->pivot->update(['ordem' => $ordemReplace]);
            $imagem->noticias()->first()->pivot->update(['ordem' => 1]);            
        } else {
            $imagem->noticias()->first()->pivot->update(['ordem' => 1]);
        }
        
        session()->flash('msg', 'Imagem de capa definida com sucesso!');
        session()->flash('status', 'success');
        return redirect()->back();
    }

    public function downloadImage($id, $imageId, ImageRepository $repository)
    {        
        $noticia = Noticia::findOrFail($id);
        return $repository->download('noticias', $noticia, $noticia->imagens()->where('imagem_noticia.imagem_id', $imageId)->first()->nome_arquivo);
    }
}
