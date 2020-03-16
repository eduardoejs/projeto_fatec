<?php

namespace App\Http\Controllers\Site\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FileRepository;
use App\Repositories\ImageRepository;
use App\Models\Sistema\Noticias\Noticia;
use Illuminate\Support\Facades\Validator;
use App\Models\Sistema\Gerenciamento\Imagens\Imagem;
use App\Models\Sistema\Gerenciamento\Arquivos\Arquivo;

class NoticiaController extends Controller
{
    private $pathBlade = 'noticias';
    private $route = 'news';
    private $pagination = 30;
    private $search = ['titulo'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('read-'.$this->route);
        $search = "";        
        if(isset($request->search)) {   
            $search = $request->search;
            $noticia = Noticia::class;
            foreach($this->search as $key => $value) {    
                $noticia = Noticia::orWhere($value, 'like', '%'.$search.'%');                
            }            
            $list = $noticia->orderBy('ativo', 'ASC')->orderBy('id', 'DESC')->paginate($this->pagination);
        }else{
            $list = Noticia::orderBy('ativo', 'ASC')->orderBy('id', 'DESC')->paginate($this->pagination);
        }
        $routeName = $this->route;        
        $page = 'Notícias';        
        $pageTitle = 'Notícias do Sistema';
        $pageDescription = 'Gerenciamento de Notícias do sistema';
        $columnsTable = ['id' => 'ID', 'titulo' => 'Título da notícia', 'exibir' => 'Visualizar até', 'user' => 'Publicado por', 'status' => 'Ativo'];

        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],
            (object)['url' => '', 'title' => $page],
        ];         
        return view('site.admin.'.$this->pathBlade.'.index', compact('breadcrumb', 'page', 'list', 'columnsTable', 'routeName', 'pageTitle', 'pageDescription', 'search'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-'.$this->route);
        $page = 'Adicionar';
        $routeName = $this->route;        
        $pageTitle = 'Adicionar Notícia';
        $pageDescription = 'Cadastro de nova notícia';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Notícias'],
            (object)['url' => '', 'title' => $page],
        ];         
        return view('site.admin.'.$this->pathBlade.'.create', compact('breadcrumb', 'page', 'pageTitle', 'pageDescription','routeName'), ['pathBlade' => $this->pathBlade]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-'.$this->route);            
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
     * @param  \App\Models\Sistema\Noticias\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function show(Noticia $news, Request $request)
    {        
        $this->authorize('read-'.$this->route);
        if($news) {
            $page = 'Show';
            $delete = false;
            if($request->delete ?? false) {                
                $delete = true;
                $page = 'Excluir';
                $routeName = $this->route;
                $pageTitle = '';
                $pageDescription = '';
                $breadcrumb = [
                    (object)['url' => route('admin'), 'title' => 'Dashboard'],                              
                    (object)['url' => route($this->route.'.index'), 'title' => 'Notícias'],
                    (object)['url' => '', 'title' => $page],
                ];
            } else {
                $page = 'Detalhes';
                $routeName = $this->route;                        
                $pageTitle = 'Notícia: ' . $news->titulo;
                $pageDescription = '';
                $breadcrumb = [
                    (object)['url' => route('admin'), 'title' => 'Dashboard'],                    
                    (object)['url' => route($this->route.'.index'), 'title' => 'Notícias'],
                    (object)['url' => '', 'title' => $page],
                ];
            }

            if($delete) {
                $this->authorize('delete', $news);
            }
            return view('site.admin.'.$this->pathBlade.'.show', compact('delete', 'breadcrumb', 'page', 'delete', 'pageTitle', 'pageDescription', 'routeName'), ['registro' => $news]);
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sistema\Noticias\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function edit(Noticia $news)
    {        
        $this->authorize('update', $news);                 
        $page = 'Alterar';
        $routeName = $this->route;
        $pageTitle = 'Alterar notícia: '.$news->nome;
        $pageDescription = 'Alterar dados da notícia';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Notícias'],
            (object)['url' => '', 'title' => $page],
        ];
        return view('site.admin.'.$this->pathBlade.'.edit', compact('breadcrumb', 'page', 'pageTitle', 'pageDescription', 'routeName'), ['pathBlade' => $this->pathBlade, 'registro' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sistema\Noticias\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Noticia $news)
    {        
        $this->authorize('update', $news);    
        $validacao = \Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required',
        ])->validate();

        if($validacao) {                        
            if(isset($request->data_exibicao)) {
                $date = date('Y-m-d', strtotime(str_replace("/", "-", $request->data_exibicao)));
            }        
            $news->update(['titulo' => $request->titulo, 'conteudo' => $request->conteudo, 'ativo' => $request->status, 'user_id' => auth()->user()->id, 'data_exibicao' => ($date ?? null)]);
            session()->flash('msg', 'Registro atualizado com sucesso');
            session()->flash('title', 'Sucesso!');
            session()->flash('status', 'success');
        }
        return redirect()->route($this->route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sistema\Noticias\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noticia $news)
    {        
        $this->authorize('delete', $news);        
        try {
            if($news) {                
                //remove os arquivos do diretorio
                $repositoryFile = new FileRepository();
                $repositoryFile->removeFiles('noticias', $news);                
                //remove as imagens do diretório
                $repositoryImage = new ImageRepository();
                $repositoryImage->removeImages('noticias', $news);
                //remove as imagens no banco de dados associadas à notícia
                foreach($news->imagens as $imagem) {
                    $imagem->delete();
                }

                foreach($news->arquivos as $arquivo) {
                    $arquivo->delete();
                }
                //remove a notícia
                $news->delete();
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

    public function uploadForm(Noticia $news, $typeUpload)
    {
        $this->authorize('uploads', $news);
        $typeCollect = $typeUpload == 'file' ? 'arquivos' : 'imagens';
        $page = $typeUpload == 'file' ? 'Anexar Arquivos': 'Anexar Imagens';
        $routeName = $this->route;
        $pageTitle = 'Envio de '. ($typeUpload == 'file' ? 'Arquivos' : 'Imagens');
        $pageDescription = 'Anexar '.$typeCollect.' à notícia: <strong>' . $news->titulo . '</strong>';

        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Notícias'],
            (object)['url' => '', 'title' => $page],
        ];          
        
        if($typeUpload == 'file') {
            $columnsTable = ['id' => 'ID', 'titulo' =>'Arquivo', 'created_at' => 'Enviado em', 'tamanho_arquivo' => 'Tamanho', 'tipo' => 'Tipo'];        
        } else if($typeUpload == 'image') {
            $columnsTable = ['id' => 'ID', 'arquivo' =>'Imagem', 'created_at' => 'Enviado em', 'tamanho_arquivo' => 'Tamanho', 'tipo' => 'Tipo', 'ordem' => 'Capa Notícia'];        
        }
        $list = $news->fresh($typeCollect);        
        $typeForm = $typeUpload == 'file' ? 'file' : 'image';
        return view('site.admin.'.$this->pathBlade.'.upload.'.$typeForm, compact('typeUpload', 'page', 'pageTitle', 'pageDescription', 'routeName', 'breadcrumb', 'columnsTable', 'list'), ['pathBlade' => $this->pathBlade, 'noticia' => $news]);
    }
   
    public function uploadStore($typeUpload, Request $request)
    {        
        if(isset($typeUpload) && $typeUpload == 'file') {
            $file = $request->file('arquivo');
            $rules = [
                'arquivo' => 'required|mimes:doc,docx,xls,xlsx,ppt,pptx,pdf,rar,zip|max:2048'
            ];
    
            if($request->hasFile('arquivo')) {            
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return redirect()->back()->withErrors($validator->messages())->withInput();
                }              
                //transaction            
                $filename = time().random_int(100, 999).'.'.$file->getClientOriginalExtension();
                $noticia = Noticia::findOrFail($request->noticiaId);
                $arquivo = Arquivo::firstOrCreate(['titulo' => $request->titulo_arquivo, 
                                                    'descricao' => $request->descricao_arquivo,
                                                    'nome_arquivo' => $filename,
                                                    'tamanho_arquivo' => $file->getSize()]);
                $repository = new FileRepository();
                $fileRepository = $repository->moveFile($file, $noticia, 'noticias', $filename);                
                // 3 - Associar o arquivo criado com a noticia
                $arquivo->noticias()->attach($noticia);
                session()->flash('msg', 'Arquivo enviado com sucesso!');
                session()->flash('status', 'success');                
            } else {
                session()->flash('msg', 'Você deve selecionar um arquivo!');
                session()->flash('status', 'error');
            }
        } else if(isset($typeUpload) && $typeUpload == 'image') {            
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
                    $repository = new ImageRepository();                
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
        }
        return redirect()->back();
    }

    public function setCapa(Noticia $news, $imagemId)
    {        
        $imagem = Imagem::with('noticias')->findOrFail($imagemId);        
        $ordemReplace = $news->imagens()->where('imagem_noticia.imagem_id', $imagemId)->first()->pivot->ordem;
        $imageReplace = $news->imagens()->where('imagem_noticia.ordem',1)->first(); 
        
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

    public function deleteFile(Noticia $news, $typeDownload, $fileId)
    {        
        $this->authorize('delete', $news);
        if($typeDownload == 'file') {
            $file = Arquivo::with('noticias')->findOrFail($fileId);         
            $file->noticias()->detach($news);
            $file->delete();
            $repository = new FileRepository();
            $repository->removeFiles('noticias', $news, $file->nome_arquivo);
            session()->flash('msg', 'Arquivo removido com sucesso!');
            session()->flash('status', 'success');
        } else if($typeDownload == 'image') { 
            $imagem = Imagem::with('noticias')->findOrFail($fileId);         
            $imagem->noticias()->detach($news);
            $imagem->delete();
            $repository = new ImageRepository();
            $repository->removeImages('noticias', $news, $imagem->nome_arquivo);
            session()->flash('msg', 'Imagem removida com sucesso!');
            session()->flash('status', 'success');
        }
        return redirect()->back();
    }
    
    public function downloadFile(Noticia $news, $typeDownload, $fileId)
    {
        if($typeDownload == 'image') {
            $repository = new ImageRepository();
            return $repository->download('noticias', $news, $news->imagens()->where('imagem_noticia.imagem_id', $fileId)->first()->nome_arquivo);
        } else if($typeDownload == 'file') {
            $repository = new FileRepository();
            return $repository->download('noticias', $news, $news->arquivos()->where('arquivo_noticia.arquivo_id', $fileId)->first()->nome_arquivo);
        }
    }
}