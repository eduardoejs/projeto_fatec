<?php

namespace App\Http\Controllers\Site\Admin\Sistema\Aviso;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sistema\Avisos\Aviso;

class AvisoController extends Controller
{
    private $route = 'avisos';
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
            $aviso = Aviso::class;
            foreach($this->search as $key => $value) {    
                $aviso = Aviso::orWhere($value, 'like', '%'.$search.'%');                
            }            
            $list = $aviso->orderBy('created_at', 'ASC')->orderBy('id', 'DESC')->paginate($this->pagination);
        }else{
            $list = Aviso::orderBy('created_at', 'ASC')->orderBy('id', 'DESC')->paginate($this->pagination);
        }
        $routeName = $this->route;        
        $page = 'Avisos';        
        $pageTitle = 'Avisos do Sistema';
        $pageDescription = 'Gerenciamento de Avisos do sistema';
        $columnsTable = ['id' => 'ID', 'titulo' => 'Aviso', 'exibir_ate_data' => 'Exibir até', 'data_criacao' => 'Criado em', 'user' => 'Publicado por'];

        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],
            (object)['url' => '', 'title' => $page],
        ];         
        return view('site.admin.'.$this->route.'.index', compact('breadcrumb', 'page', 'list', 'columnsTable', 'routeName', 'pageTitle', 'pageDescription', 'search'));        
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
        $pageTitle = 'Adicionar Aviso';
        $pageDescription = 'Cadastro de novo aviso';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Avisos'],
            (object)['url' => '', 'title' => $page],
        ];         
        return view('site.admin.'.$this->route.'.create', compact('breadcrumb', 'page', 'pageTitle', 'pageDescription','routeName'));
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
            'resumo' => 'required|string|max:150',
            'data_exibicao' => 'required',
            'conteudo' => 'required',
        ])->validate();

        if($validacao) {
            if(isset($request->data_exibicao)) {
                $date = date('Y-m-d', strtotime(str_replace("/", "-", $request->data_exibicao)));
            }        
            Aviso::create(['titulo' => $request->titulo, 'conteudo' => $request->conteudo, 'resumo' => $request->resumo, 'user_id' => auth()->user()->id, 'data_exibicao' => ($date ?? null)]);
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
    public function edit(Aviso $aviso)
    {
        $this->authorize('updateAviso', $aviso);                 
        $page = 'Alterar';
        $routeName = $this->route;
        $pageTitle = 'Alterar aviso: '.$aviso->titulo;
        $pageDescription = 'Alterar dados do aviso';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Avisos'],
            (object)['url' => '', 'title' => $page],
        ];
        return view('site.admin.'.$this->route.'.edit', compact('breadcrumb', 'page', 'pageTitle', 'pageDescription', 'routeName'), ['registro' => $aviso]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aviso $aviso)
    {
        $this->authorize('updateAviso', $aviso);    
        $validacao = \Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'resumo' => 'required|string|max:150',
            'data_exibicao' => 'required',
            'conteudo' => 'required',
        ])->validate();

        if($validacao) {                        
            if(isset($request->data_exibicao)) {
                $date = date('Y-m-d', strtotime(str_replace("/", "-", $request->data_exibicao)));
            }        
            $aviso->update(['titulo' => $request->titulo, 'conteudo' => $request->conteudo, 'resumo' => $request->resumo, 'user_id' => auth()->user()->id, 'data_exibicao' => ($date ?? null)]);
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
    public function destroy($id)
    {
        //
    }
}
