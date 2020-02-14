<?php

namespace App\Http\Controllers\Site\Admin\Curso;


use App\Models\Acl\User;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use App\Classes\ValidaFormCurso;
use App\Models\Cursos\TipoCurso;
use App\Models\Cursos\Modalidade;
use App\Http\Controllers\Controller;
use App\Models\Institucional\TiposUsuarios\Docente;

class CursoController extends Controller
{
    private $route = 'curso';
    private $paginacao = 30;
    private $search = ['titulo'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('read-curso');
        $search = ""; 

        $cursos = Curso::with('tipoCurso', 'modalidade')->get();         
        $tipos = TipoCurso::all();
        $modalidades = Modalidade::all();

        $list = null;
        $colunas = null;

        $rotaNome = $this->route;
        $rotaTipo = 'tipocurso';
        $rotaModalidade = 'modalidade';
        $page = 'Curso';        
        $tituloPagina = 'Cursos da Unidade';
        $descricaoPagina = 'Gerenciamento de Cursos';
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],
            (object)['url' => '', 'title' => $page],
        ];         

        return view('site.admin.'.$this->route.'.index', compact('breadcrumb', 'cursos', 'tipos', 'modalidades', 'page', 'list', 'colunas', 'rotaNome', 'rotaTipo', 'rotaModalidade', 'tituloPagina', 'descricaoPagina', 'search'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-curso');

        $page = 'Adicionar';
        $rotaNome = $this->route;
        $tituloPagina = 'Adicionar Curso';
        $descricaoPagina = 'Cadastro de novo curso da unidade';
        
        $breadcrumb = [
            (object)['url' => route('admin'), 'title' => 'Dashboard'],                     
            (object)['url' => route($this->route.'.index'), 'title' => 'Cursos'],
            (object)['url' => '', 'title' => $page],
        ]; 
        
        $tipos = TipoCurso::all();
        $modalidades = Modalidade::all();        
        $docentes = User::join('docentes', 'users.id', '=', 'docentes.user_id')->orderBy('nome', 'ASC')->select('users.*')->get();        

        return view('site.admin.'.$this->route.'.create', compact('tipos', 'modalidades', 'docentes', 'breadcrumb', 'page', 'tituloPagina', 'descricaoPagina', 'rotaNome'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-curso');

        if(!isset($request->periodos)) {
            session()->flash('msg', 'Você deve informar pelo menos um dos períodos do curso');
            session()->flash('status', 'error');
            return redirect()->back()->withInput();
        }
        
        $formValidate = ValidaFormCurso::validateForm($request)->validate();
        
        if($formValidate) {
            $curso = Curso::firstOrCreate([
                'nome' => $request->nome,
                'duracao' => $request->duracao,
                'conteudo' => $request->conteudo,
                'periodo' => implode(',', $request->periodos),
                'qtde_vagas' => $request->qtde_vagas,
                'email_coordenador' => $request->email,
                'ativo' => $request->ativo,
                'tipo_curso_id' =>  $request->tipoCurso,
                'modalidade_id' =>  $request->modalidade,
                'docente_id' =>  $request->coordenador,
            ]);

            session()->flash('msg', 'Registro cadastrado com sucesso!');
            session()->flash('status', 'success');
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
        $this->authorize('read-curso');

        $registro = Curso::findOrFail($id);

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
                    (object)['url' => route('user.index'), 'title' => 'Cursos'],
                    (object)['url' => '', 'title' => $page],
                ];
            } else {
                $page = 'Detalhes';
                $rotaNome = $this->route;                        
                $tituloPagina = 'Curso: ' . $registro->nome;
                $descricaoPagina = '';
                $breadcrumb = [
                    (object)['url' => route('admin'), 'title' => 'Dashboard'],                    
                    (object)['url' => route('user.index'), 'title' => 'Cursos'],
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
        $this->authorize('delete-curso');

        $curso = Curso::findOrFail($id);
        try{
            if($curso) {
                $curso->delete();
                session()->flash('msg', 'Registro excluído do banco de dados');
                session()->flash('title', 'Sucesso');
                session()->flash('status', 'success');
            }
        } catch(\PDOException $e){
            session()->flash('msg', $e->getMessage());
            session()->flash('title', 'Erro inesperado');
            session()->flash('status', 'error');
        }
        return redirect()->route($this->route.'.index');
    }
}
