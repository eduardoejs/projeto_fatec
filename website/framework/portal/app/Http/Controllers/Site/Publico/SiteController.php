<?php

namespace App\Http\Controllers\Site\Publico;

use App\Models\Acl\User;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use App\Models\Cursos\TipoCurso;
use App\Models\Cursos\Modalidade;
use App\Http\Controllers\Controller;
use App\Models\Sistema\Avisos\Aviso;
use App\Repositories\FileRepository;
use App\Models\Sistema\Paginas\Pagina;
use App\Models\Sistema\Noticias\Noticia;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{   
    private $tipos = null; 
    private $cursos = null;
    private $paginate = 30; 

    public function __construct()
    {
        $this->tipos = TipoCurso::all();
        $this->cursos = new Curso();
    }

    public function index()
    {        
        $avisos = Aviso::where('data_exibicao','>=', date('Y-m-d'))->orderBy('created_at', 'DESC')->get();
        $avisos = (count($avisos) > 0) ? $avisos : null;
        $estilos = null;
        
        if($avisos) {
            $estilos = ['efeito' => 'fade', 
                            'dimensao_modal' => 'modal-lg', 
                            'scroll' => 'modal-dialog-scrollable', 
                            'cor_fonte' => 'text-dark',
                            'posicao_modal' => 'modal-dialog-centered', 
                            'text_transform' => 'text-uppercase',
                            'static' => 'data-backdrop=static',
                            'botao_fechar' => ''//se quiser sumir com o botão fechar => d-none, senao deixe em branco
                        ];
        }       

        $tipos = TipoCurso::all();
        $cursos = new Curso();
        
        //retornar apenas as 3 últimas noticias        
        $noticias = Noticia::with('imagens')->where('ativo','S')->whereRaw('(data_exibicao is null or data_exibicao >= curdate())')->orderBy('id', 'DESC')->take(3)->get();         
            
        return view('site.publico.index', compact('tipos', 'cursos', 'estilos' , 'avisos', 'noticias'));
    }
    
    public function showFormAtivacao($token, $email)
    {           
        if(isset($token) && isset($email)) {
            $user = User::where('token_create', $token)->where('email', $email)->first();            
            if($user) {
                if(md5($user->cpf) == $token){                    
                    return view('site.publico.ativar_usuario', compact('token', 'email', 'user'));
                }                
            }else {
                
                session()->flash('msg', 'Erro ao localizar usuário!');
                session()->flash('status', 'error');
                return view('site.publico.ativar_usuario', compact('token', 'email', 'user'));
            }
        }
    }

    public function validarConta(Request $request)
    {    
        $rules = [
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);
            
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator->messages())
                        ->withInput();   
        }
        
        if(isset($request->token_create) && isset($request->email)) {            
            $user = User::where('token_create', $request->token_create)->where('email', $request->email)->first();            
            if($user) {                
                if(md5($user->cpf) == $request->token_create){ 
                    $user->update(['password' => bcrypt($request->password)]);                    
                }else{
                    session()->flash('msg', 'Erro ao processar token de validação!');
                    session()->flash('status', 'error');
                    return redirect()->back();
                }
            } else {
                session()->flash('msg', 'Erro ao processar localizar usuário!');
                session()->flash('status', 'error');
                return redirect()->back();
            }
        }
        return redirect()->route('admin');
    }    

    public function allNoticia()
    {        
        $tipos = $this->tipos;
        $cursos = $this->cursos;
        $noticias = Noticia::with('imagens')->where('ativo','S')->whereRaw('(data_exibicao is null or data_exibicao >= curdate())')->orderBy('id', 'DESC')->paginate($this->paginate);
        return view('site.publico.noticias.noticias', compact('noticias', 'tipos', 'cursos'));
    }

    public function lerNoticia($id)
    {
        $tipos = $this->tipos;
        $cursos = $this->cursos;
        $noticia = Noticia::with('imagens', 'arquivos')->where('ativo', 'S')->findOrFail($id);        
        return view('site.publico.noticias.ler_noticia', compact('tipos', 'cursos', 'noticia'));
    }

    public function verCurso($id)
    {        
        $tipos = $this->tipos;
        $cursos = $this->cursos;
        //$curso = Curso::with('arquivos', 'docentes')->findOrFail($id);
        $curso = Curso::where('ativo', 'S')->findOrFail($id);
        
        return view('site.publico.cursos.ver_curso', compact('curso', 'tipos', 'cursos'));
    }

    public function downloadFileNoticia($id, $fileId, FileRepository $repository)
    {        
        $noticia = Noticia::findOrFail($id);
        return $repository->download('noticias', $noticia, $noticia->arquivos()->where('arquivo_noticia.arquivo_id', $fileId)->first()->nome_arquivo);
    }

    public function downloadFileCurso($id, $fileId, FileRepository $repository)
    {        
        $curso = Curso::findOrFail($id);
        return $repository->download('cursos', $curso, $curso->arquivos()->where('arquivo_curso.arquivo_id', $fileId)->first()->nome_arquivo);
    }

    public function downloadFilePagina($id, $fileId, FileRepository $repository)
    {        
        $pagina = Pagina::findOrFail($id);
        return $repository->download('paginas', $pagina, $pagina->arquivos()->where('arquivo_pagina.arquivo_id', $fileId)->first()->nome_arquivo);
    }

    public function verPagina($parametro)
    {
        $tipos = $this->tipos;
        $cursos = $this->cursos;
        $pagina = Pagina::where('parametro_rota', $parametro)->first();
        if(is_null($pagina)) {
            abort(404);
        }
        return view('site.publico.paginas.ver_pagina', compact('pagina', 'tipos', 'cursos'));
    }
}
