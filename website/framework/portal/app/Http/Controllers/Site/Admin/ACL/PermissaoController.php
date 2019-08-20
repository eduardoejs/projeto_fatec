<?php

namespace App\Http\Controllers\Site\Admin\ACL;

use App\Models\Acl\Perfil;
use Illuminate\Http\Request;
use App\Models\Acl\Permissao;
use App\Http\Controllers\Controller;

class PermissaoController extends Controller
{
    private $route = 'permissao';    
    private $search = ['nome', 'descricao'];
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
            $permissao = Permissao::class;
            foreach($this->search as $key => $value) {
                $permissao = Permissao::orWhere($value, 'like', '%'.$search.'%');
            }
            $list = $permissao->orderBy('id', 'ASC')->get();
        }else{
            $list = Permissao::all();
        }        
        $colunas = ['id' => 'ID', 'nome' => 'Nome', 'descricao' => 'Descrição'];
        
        $rotaNome = $this->route;        
        $page = 'Permissao';        
        $tituloPagina = 'Permissões do Sistema';
        $descricaoPagina = 'Gerenciamento das permissões do sistema';

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
        $page = 'Adicionar';
        $rotaNome = $this->route;
        $tituloPagina = 'Adicionar Permissão';
        $descricaoPagina = 'Cadastro de nova permissão do sistema';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Permissão'],
            (object)['url' => '', 'title' => $page],
        ]; 
        $perfis = Perfil::all();
        return view('site.admin.acl.'.$this->route.'.create', compact('perfis','breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validacao = \Validator::make($data, [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
        ])->validate();

        if($validacao) {
            
            \DB::beginTransaction();            
            try{
                $permissão = Permissao::create($request->all());                        
                if($permissão) {
                    //relacionamento das permissoes com o Permissão criado
                    if(isset($data['perfis']) && count($data['perfis'])) {
                        foreach($data['perfis'] as $key => $value) {
                            $permissão->perfis()->attach($value);
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
        $registro = Permissao::findOrFail($id);
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
                    (object)['url' => route($this->route.'.index'), 'title' => 'Permissão'],
                    (object)['url' => '', 'title' => $page],
                ];
            } else {
                $page = 'Detalhes';
                $rotaNome = $this->route;                        
                $tituloPagina = 'Permissão: ' . $registro->nome;
                $descricaoPagina = '';
                $breadcrumb = [
                    (object)['url' => route('admin'), 'title' => 'Dashboard'],                    
                    (object)['url' => route($this->route.'.index'), 'title' => 'Permissão'],
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
        $registro = Permissao::findOrFail($id);
        $perfis = Perfil::all();

        $page = 'Alterar';        
        $rotaNome = $this->route;
        $tituloPagina = 'Alterar Permissão: '. $registro->nome;
        $descricaoPagina = 'Descrição do Permissão: ' . $registro->descricao;
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],            
            (object)['url' => route($this->route.'.index'), 'title' => 'Permissão'],
            (object)['url' => '', 'title' => $page],
        ];
        
        return view('site.admin.acl.'.$this->route.'.edit', compact('perfis', 'registro', 'page', 'breadcrumb', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
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
        $data = $request->all();

        $validacao = \Validator::make($data, [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
        ])->validate();

        if($validacao) {
            
            \DB::beginTransaction();            
            try{
                $permissão = Permissao::findOrFail($id);
                if($permissão) {                    
                    $perfis = $permissão->perfis;
                    if(count($perfis)) {
                        foreach ($perfis as $key => $value) {
                            $permissão->perfis()->detach($value->id);
                        }
                    }

                    if(isset($data['perfis']) && count($data['perfis'])) {
                        foreach($data['perfis'] as $key => $value) {
                            $permissão->perfis()->attach($value);
                        }
                    }
                    $permissão->update($data);
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
        $permissão = Permissao::findOrFail($id);

        try {
            if($permissão) {
                $permissão->delete();
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
