<?php

namespace App\Http\Controllers\Site\Admin\ACL;

use App\Models\Acl\Perfil;
use Illuminate\Http\Request;
use App\Models\Acl\Permissao;
use App\Http\Controllers\Controller;

class PerfilController extends Controller
{
    private $route = 'perfil';    
    private $search = ['nome', 'descricao'];

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
        $this->authorize('read-perfil');

        $search = "";
        if(isset($request->search)){
            $search = $request->search;
            $perfil = Perfil::class;
            foreach($this->search as $key => $value) {
                $perfil = Perfil::orWhere($value, 'like', '%'.$search.'%');
            }
            $list = $perfil->orderBy('id', 'ASC')->get();
        }else{
            $list = Perfil::all();
        }        
        $colunas = ['id' => 'ID', 'nome' => 'Nome', 'descricao' => 'Descrição'];
        
        $rotaNome = $this->route;        
        $page = 'Perfil';        
        $tituloPagina = 'Perfil de Usuário';
        $descricaoPagina = 'Gerenciamento dos perfis de usuários do sistema';

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
        $this->authorize('create-perfil');

        $page = 'Adicionar';
        $rotaNome = $this->route;
        $tituloPagina = 'Adicionar Perfil';
        $descricaoPagina = 'Cadastro de novo perfil de usuário do sistema';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route('perfil.index'), 'title' => 'Perfil'],
            (object)['url' => '', 'title' => $page],
        ]; 
        $permissoes = Permissao::all();
        return view('site.admin.acl.'.$this->route.'.create', compact('permissoes','breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     
        $this->authorize('create-perfil');

        $data = $request->all();

        $validacao = \Validator::make($data, [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
        ])->validate();

        if($validacao) {
            
            \DB::beginTransaction();            
            try{
                $perfil = Perfil::create($request->all());                        
                if($perfil) {
                    //relacionamento das permissoes com o perfil criado
                    if(isset($data['permissions']) && count($data['permissions'])) {
                        foreach($data['permissions'] as $key => $value) {
                            $perfil->permissoes()->attach($value);
                        }
                    }
                    session()->flash('msg', 'Registro criado com sucesso');
                    session()->flash('title', 'Sucesso!');
                    session()->flash('status', 'success');
                    \DB::commit();
                }
            }catch(\PDOException $e) {                
                if($e->getCode() == '23000'){
                    session()->flash('msg', "Violação de restrição de integridade. Entrada duplicada para a chave: '{$request->nome}'.");
                    session()->flash('title', 'Erro ao inserir registro no banco de dados');
                    session()->flash('status', 'error');    
                }else{
                    session()->flash('msg', $e->getMessage());
                    session()->flash('title', 'Erro ao inserir registro no banco de dados');
                    session()->flash('status', 'error');
                }
                \DB::rollback();
            }            
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $this->authorize('read-perfil');

        $registro = Perfil::findOrFail($id);
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
                    (object)['url' => route('perfil.index'), 'title' => 'Perfil'],
                    (object)['url' => '', 'title' => $page],
                ];
            } else {
                $page = 'Detalhes';
                $rotaNome = $this->route;                        
                $tituloPagina = 'Perfil: ' . $registro->nome;
                $descricaoPagina = '';
                $breadcrumb = [
                    (object)['url' => route('admin'), 'title' => 'Dashboard'],                    
                    (object)['url' => route('perfil.index'), 'title' => 'Perfil'],
                    (object)['url' => '', 'title' => $page],
                ];
            }
            return view('site.admin.acl.'.$this->route.'.show', compact('registro', 'delete', 'breadcrumb', 'page', 'delete', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
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
        $this->authorize('update-perfil');

        $registro = Perfil::findOrFail($id);
        $permissoes = Permissao::all();

        $page = 'Alterar';        
        $rotaNome = $this->route;
        $tituloPagina = 'Alterar Perfil: '. $registro->nome;
        $descricaoPagina = 'Descrição do perfil: ' . $registro->descricao;
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],            
            (object)['url' => route('perfil.index'), 'title' => 'Perfil'],
            (object)['url' => '', 'title' => $page],
        ];
        
        return view('site.admin.acl.'.$this->route.'.edit', compact('permissoes', 'registro', 'page', 'breadcrumb', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
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
        $this->authorize('update-perfil');

        $data = $request->all();

        $validacao = \Validator::make($data, [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
        ])->validate();

        if($validacao) {
            
            \DB::beginTransaction();            
            try{
                $perfil = Perfil::findOrFail($id);
                if($perfil) {                    
                    $permissoes = $perfil->permissoes;
                    if(count($permissoes)) {
                        foreach ($permissoes as $key => $value) {
                            $perfil->permissoes()->detach($value->id);
                        }
                    }

                    if(isset($data['permissions']) && count($data['permissions'])) {
                        foreach($data['permissions'] as $key => $value) {
                            $perfil->permissoes()->attach($value);
                        }
                    }
                    $perfil->update($data);
                    session()->flash('msg', 'Registro atualizado com sucesso');
                    session()->flash('title', 'Sucesso!');
                    session()->flash('status', 'success');
                    \DB::commit();
                }
            }catch(\PDOException $e){                
                if($e->getCode() == '23000'){
                    session()->flash('msg', "Violação de restrição de integridade. Entrada duplicada para a chave: '{$request->nome}'.");
                    session()->flash('title', 'Erro ao inserir registro no banco de dados');
                    session()->flash('status', 'error');    
                }else{
                    session()->flash('msg', $e->getMessage());
                    session()->flash('title', 'Erro ao inserir registro no banco de dados');
                    session()->flash('status', 'error');
                }
                \DB::rollback();
            }            
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-perfil');
        
        $perfil = Perfil::findOrFail($id);

        try {
            if($perfil) {
                $perfil->delete();
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
}
