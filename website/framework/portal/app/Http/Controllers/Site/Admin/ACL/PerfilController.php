<?php

namespace App\Http\Controllers\Site\Admin\ACL;

use App\Models\Acl\Perfil;
use Illuminate\Http\Request;
use App\Models\Acl\Permissao;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfis = Perfil::all();
        return view('site.admin.acl.perfil.index', compact('perfis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissoes = Permissao::all();
        return view('site.admin.acl.perfil.create', compact('permissoes'));
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

        $validacao = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
        ])->validate();

        if($validacao) {
            
            DB::beginTransaction();            
            try{
                $perfil = Perfil::create($request->all());                        
                if($perfil) {
                    //relacionamento das permissoes com o perfil criado
                    if(isset($data['permissions']) && count($data['permissions'])) {
                        foreach($data['permissions'] as $key => $value) {
                            $perfil->permissoes()->attach($value);
                        }
                    }
                    session()->flash('msg', 'Perfil criado com sucesso');
                    session()->flash('title', 'Sucesso!');
                    session()->flash('status', 'success');
                    DB::commit();
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
                DB::rollback();
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
        $registro = Perfil::findOrFail($id);
        if($registro) {

            $delete = false;
            if($request->delete ?? false) {
                session()->flash('msg', 'Você realmente deseja prosseguir com a exclusão do registro?');
                session()->flash('title', 'Excluir Registro');
                session()->flash('status', 'alert');
                $delete = true;
            }

            return view('site.admin.acl.perfil.show', compact('registro', 'delete'));
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
        $registro = Perfil::findOrFail($id);
        $permissoes = Permissao::all();
        return view('site.admin.acl.perfil.edit', compact('permissoes', 'registro'));
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

        $validacao = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
        ])->validate();

        if($validacao) {
            
            DB::beginTransaction();            
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
                    session()->flash('msg', 'Perfil atualizado com sucesso');
                    session()->flash('title', 'Sucesso!');
                    session()->flash('status', 'success');
                    DB::commit();
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
                DB::rollback();
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
        $perfil = Perfil::findOrFail($id);

        try {
            if($perfil) {
                $perfil->delete();
                session()->flash('msg', 'Perfil excluído do banco de dados');
                session()->flash('title', 'Sucesso');
                session()->flash('status', 'success');
            }
        } catch (\PDOException $e) {
            session()->flash('msg', $e->getMessage());
            session()->flash('title', 'Erro inesperado');
            session()->flash('status', 'error');
        }
        return redirect()->route('perfil.index');
    }
}
