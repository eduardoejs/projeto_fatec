<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/teste', function () {
    //$cursos = Curso::findOrFail(2)->with(['tipoCurso', 'modalidade', 'docente', 'disciplinas'])->first();    
    $cursos = App\Models\Cursos\Curso::with(['tipoCurso', 'modalidade', 'docente', 'disciplinas'])->get();    
    //dd($cursos);
    foreach ($cursos as $curso) { 
        
        echo "<hr>Alunos do curso $curso->nome<br>";
        foreach($curso->alunos as $aluno){
            
            echo "<ol><li>".$aluno->user->nome ." </li></ol>";
        }
        echo 'Curso: '.$curso->nome .' - '.$curso->tipoCurso->descricao.' - '.
            $curso->modalidade->descricao.' - Coordenador(a): '.$curso->docente->user->nome.'<br>';
        foreach ($curso->disciplinas as $disciplina) {                         
            //dd($disciplina->docentes->where('id', $disciplina->pivot->docente_id)->first()->user->nome);
            //echo '<ul><li>'.$disciplina->nome .' - '.$disciplina->pivot->carga_horaria.' horas. Semestre: '.$disciplina->pivot->semestre.' Docente: '.App\Models\Institucional\TiposUsuarios\Docente::findOrFail($disciplina->pivot->docente_id)->nome.'</li></ul>';
            echo '<ul><li>'.$disciplina->nome .' - '.$disciplina->pivot->carga_horaria.' horas. Semestre: '.
            $disciplina->pivot->semestre.' Docente: '
            .$disciplina->docentes->where('id', $disciplina->pivot->docente_id)->first()->user->nome.'</li></ul>';
        }
        //echo $curso->disciplinas()->where('docente_id',2)->get();
    }
    $tipo = App\Models\Cursos\TipoCurso::find(1);    
    echo $tipo->cursos[0]->nome;
    $aluno = App\Models\Institucional\TiposUsuarios\Aluno::findOrFail(1);
    echo '<br>Aluno: '.$aluno->user->nome.' - Cursando: '.$aluno->curso->nome.' Login:'.$aluno->user->email;
})->name('teste');

Auth::routes(['register' =>false]);

Route::namespace('Site\Publico')->group(function () {
    Route::get('/', 'SiteController@index')->name('site');
    
    Route::get('conta/ativar/{token}/{email}', 'SiteController@showFormAtivacao')->name('ativar.conta');
    Route::post('conta/validar', 'SiteController@validarConta')->name('validar.conta');
    
    Route::get('noticias/{id}', 'SiteController@lerNoticia')->name('ler.noticia');
    Route::get('noticias/{id}/download/{fileId}', 'SiteController@downloadFileNoticia')->name('site.noticia.download.file');
    Route::get('noticias', 'SiteController@allNoticia')->name('todas.noticias');
    
    Route::get('cursos/{id}', 'SiteController@verCurso')->name('ver.curso');    
    Route::get('cursos/{id}/download/{fileId}', 'SiteController@downloadFileCurso')->name('site.curso.download.file');

    Route::get('paginas/{id}/download/{fileId}', 'SiteController@downloadFilePagina')->name('site.pagina.download.file');
    Route::get('paginas/{parametro}', 'SiteController@verPagina')->name('ver.pagina');
});

Route::prefix('admin')->middleware('auth')->namespace('Site\Admin')->group(function() {    
    Route::get('noticias/{news}/download/{typeDownload}/{fileId}', 'Sistema\Noticia\NoticiaController@downloadFile')->name('news.download.file');
    Route::get('curso/{id}/download/{fileId}', 'Sistema\Curso\CursoController@downloadFile')->name('curso.download.file');
    Route::get('paginas/{pagina}/download/{typeDownload}/{fileId}', 'Sistema\Pagina\PaginaController@downloadFile')->name('paginas.download.file');
});

Route::prefix('admin')->middleware(['auth', 'revalidate', 'login.unique'])->namespace('Site\Admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/acl', 'AdminController@indexACL')->name('admin.acl');    
    Route::get('/user/profile', 'ACL\UserController@profile')->name('user.profile');    
    
    Route::resource('/curso/tipocurso', 'Curso\TipoCursoController');
    Route::resource('curso/modalidade', 'Curso\ModalidadeController');
    
    Route::prefix('sistema')->namespace('Sistema')->middleware('auth', 'revalidate')->group(function() {
        Route::get('curso/{id}/upload/file', 'Curso\CursoController@uploadFileForm')->name('curso.upload.file');    
        Route::post('curso/upload/file', 'Curso\CursoController@uploadFile')->name('curso.store.upload.file');
        Route::delete('curso/{id}/destroy/file/{FileId}', 'Curso\CursoController@destroySingleFile')->name('curso.destroy.file');
        Route::resource('curso', 'Curso\CursoController');

        Route::get('noticias/{news}/upload/{typeUpload}', 'Noticia\NoticiaController@uploadForm')->name('news.uploads');
        Route::post('noticias/upload/{typeUpload}/store', 'Noticia\NoticiaController@uploadStore')->name('news.uploads.store');
        Route::post('noticias/{news}/capa/{imageId}', 'Noticia\NoticiaController@setCapa')->name('news.setcapa');
        Route::delete('noticias/{news}/delete/{typeUpload}/{fileId}', 'Noticia\NoticiaController@deleteFile')->name('news.delete.file');
        Route::resource('noticias', 'Noticia\NoticiaController')->names('news')->parameters(['noticias' => 'news']);

        Route::get('paginas/{pagina}/upload/{typeUpload}', 'Pagina\PaginaController@uploadForm')->name('paginas.uploads');
        Route::post('paginas/upload/{typeUpload}/store', 'Pagina\PaginaController@uploadStore')->name('paginas.uploads.store');
        Route::delete('paginas/{nepaginaws}/delete/{typeUpload}/{fileId}', 'Pagina\PaginaController@deleteFile')->name('paginas.delete.file');
        Route::resource('paginas', 'Pagina\PaginaController');

        Route::resource('avisos', 'Aviso\AvisoController');
    });
    
    Route::prefix('acl')->namespace('ACL')->middleware('auth', 'revalidate')->group(function() {
        Route::get('user/send-email', 'UserController@sendEMail');
        Route::resource('perfil', 'PerfilController');    
        Route::resource('permissao', 'PermissaoController');    
        Route::resource('user', 'UserController');                    
    }); 
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('500', function()
{
    abort(500);
});
