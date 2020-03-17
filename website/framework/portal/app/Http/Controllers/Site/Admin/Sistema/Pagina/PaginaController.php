<?php

namespace App\Http\Controllers\Site\Admin\Sistema\Pagina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FileRepository;
use App\Models\Sistema\Paginas\Pagina;
use Illuminate\Support\Facades\Validator;
use App\Models\Sistema\Gerenciamento\Imagens\Imagem;
use App\Models\Sistema\Gerenciamento\Arquivos\Arquivo;

class PaginaController extends Controller
{
    private $pathBlade = 'paginas';
    private $route = 'paginas';
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
            $pagina = Pagina::class;
            foreach($this->search as $key => $value) {    
                $pagina = Pagina::orWhere($value, 'like', '%'.$search.'%');                
            }            
            $list = $pagina->orderBy('id', 'DESC')->paginate($this->pagination);
        }else{
            $list = Pagina::orderBy('id', 'DESC')->paginate($this->pagination);
        }        
        $routeName = $this->route;        
        $page = 'Páginas';        
        $pageTitle = 'Páginas do Sistema';
        $pageDescription = 'Gerenciamento de Páginas do sistema';
        $columnsTable = ['id' => 'ID', 'parametro_rota' => 'Parâmetro Rota'];

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
        $pageTitle = 'Adicionar Página';
        $pageDescription = 'Cadastro de nova página';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Páginas'],
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
            'parametro' => 'required|string|max:255',
            'conteudo' => 'required',
        ])->validate();

        if($validacao) {
            Pagina::create(['parametro_rota' => $request->parametro, 'conteudo' => $request->conteudo]);
            session()->flash('msg', 'Registro cadastrado com sucesso!');
            session()->flash('status', 'success');
            return redirect()->route($this->route.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sistema\Paginas\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function show(Pagina $pagina, Request $request)
    {
        $this->authorize('read-'.$this->route);
        if($pagina) {
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
                $pageTitle = 'Parâmetro Rota: ' . $pagina->parametro_rota;
                $pageDescription = '';
                $breadcrumb = [
                    (object)['url' => route('admin'), 'title' => 'Dashboard'],                    
                    (object)['url' => route($this->route.'.index'), 'title' => 'Notícias'],
                    (object)['url' => '', 'title' => $page],
                ];
            }

            if($delete) {
                $this->authorize('delete', $pagina);
            }
            return view('site.admin.'.$this->pathBlade.'.show', compact('delete', 'breadcrumb', 'page', 'delete', 'pageTitle', 'pageDescription', 'routeName'), ['registro' => $pagina]);
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sistema\Paginas\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function edit(Pagina $pagina)
    {
        $this->authorize('update', $pagina);                 
        $page = 'Alterar';
        $routeName = $this->route;
        $pageTitle = 'Alterar página (parâmetro rota): '.$pagina->parametro_rota;
        $pageDescription = 'Alterar dados da página';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Páginas'],
            (object)['url' => '', 'title' => $page],
        ];
        return view('site.admin.'.$this->pathBlade.'.edit', compact('breadcrumb', 'page', 'pageTitle', 'pageDescription', 'routeName'), ['pathBlade' => $this->pathBlade, 'registro' => $pagina]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sistema\Paginas\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pagina $pagina)
    {
        $this->authorize('update', $pagina);    
        $validacao = \Validator::make($request->all(), [
            'parametro' => 'required|string|max:255',
            'conteudo' => 'required',
        ])->validate();

        if($validacao) {                  
            $pagina->update(['parametro_rota' => $request->parametro, 'conteudo' => $request->conteudo]);
            session()->flash('msg', 'Registro atualizado com sucesso');
            session()->flash('title', 'Sucesso!');
            session()->flash('status', 'success');
        }
        return redirect()->route($this->route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sistema\Paginas\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pagina $pagina)
    {
        $this->authorize('delete', $pagina);        
        try {
            if($pagina) {                
                //remove os arquivos do diretorio
                $repositoryFile = new FileRepository();
                $repositoryFile->removeFiles('paginas', $pagina);                
                
                //remove arquivos no banco de dados associadas à página
                foreach($pagina->arquivos as $arquivo) {
                    $arquivo->delete();
                }
                //remove a página
                $pagina->delete();
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

    public function uploadForm(Pagina $pagina, $typeUpload)
    {
        $this->authorize('uploads', $pagina);
        $typeCollect = $typeUpload == 'file' ? 'arquivos' : 'imagens';
        $page = $typeUpload == 'file' ? 'Anexar Arquivos': 'Anexar Imagens';
        $routeName = $this->route;
        $pageTitle = 'Envio de '. ($typeUpload == 'file' ? 'Arquivos' : 'Imagens');
        $pageDescription = 'Anexar '.$typeCollect.' à página (parâmetro rota): <strong>' . $pagina->parametro_rota . '</strong>';

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
        $list = $pagina->fresh($typeCollect);
        $typeForm = $typeUpload == 'file' ? 'file' : 'image';
        return view('site.admin.'.$this->pathBlade.'.upload.'.$typeForm, compact('typeUpload', 'page', 'pageTitle', 'pageDescription', 'routeName', 'breadcrumb', 'columnsTable', 'list'), ['pathBlade' => $this->pathBlade, 'pagina' => $pagina]);
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
                $pagina = Pagina::findOrFail($request->paginaId);
                $arquivo = Arquivo::firstOrCreate(['titulo' => $request->titulo_arquivo, 
                                                    'descricao' => $request->descricao_arquivo,
                                                    'nome_arquivo' => $filename,
                                                    'tamanho_arquivo' => $file->getSize()]);
                $repository = new FileRepository();
                $fileRepository = $repository->moveFile($file, $pagina, 'paginas', $filename);                
                // 3 - Associar o arquivo criado com a pagina
                $arquivo->paginas()->attach($pagina);
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
                $pagina = pagina::findOrFail($request->paginaId);                        
                $ordem = 1;
                foreach ($files as $file) {
                    $repository = new ImageRepository();                
                    $fileName = $repository->moveImage($file, $pagina, 'paginas', true);
                    if(!\is_null($fileName)) {
                        $imagem = Imagem::firstOrCreate(['titulo' => null, 
                                                        'descricao' => null, 
                                                        'tamanho_arquivo' => $file->getSize(),
                                                        'nome_arquivo' => ($fileName ?? null)]);
                        if($pagina->imagens()->count()) {                        
                            $aux = $pagina->imagens()->orderBy('ordem','DESC')->first();
                            $ordem = $aux->pivot->ordem + 1;
                        } 
                        //associo a imagem à notícia no banco de dados                   
                        $imagem->paginas()->attach($pagina, ['ordem' => $ordem]);
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

    public function deleteFile(Pagina $pagina, $typeDownload, $fileId)
    {        
        $this->authorize('delete', $pagina);
        if($typeDownload == 'file') {
            $file = Arquivo::with('paginas')->findOrFail($fileId);         
            $file->paginas()->detach($pagina);
            $file->delete();
            $repository = new FileRepository();
            $repository->removeFiles('paginas', $pagina, $file->nome_arquivo);
            session()->flash('msg', 'Arquivo removido com sucesso!');
            session()->flash('status', 'success');
        } else if($typeDownload == 'image') { 
            $imagem = Imagem::with('paginas')->findOrFail($fileId);         
            $imagem->paginas()->detach($pagina);
            $imagem->delete();
            $repository = new ImageRepository();
            $repository->removeImages('paginas', $pagina, $imagem->nome_arquivo);
            session()->flash('msg', 'Imagem removida com sucesso!');
            session()->flash('status', 'success');
        }
        return redirect()->back();
    }
}
