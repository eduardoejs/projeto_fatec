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
    Route::get('/ativar/conta/{token}/{email}', 'SiteController@showFormAtivacao')->name('ativar.conta');
    Route::post('/validar/conta', 'SiteController@validarConta')->name('validar.conta');
    Route::get('/site/view/noticia/{id}', 'SiteController@lerNoticia')->name('ler.noticia');
    Route::get('/view/curso/{id}', 'SiteController@verCurso')->name('ver.curso');
    Route::get('/noticia/{id}/download/{fileId}', 'SiteController@downloadFileNoticia')->name('site.noticia.download.file');
});

Route::prefix('admin')->middleware('auth')->namespace('Site\Admin')->group(function(){
    Route::get('/noticia/{id}/download-image/{imageId}', 'NoticiaController@downloadImage')->name('noticia.download.image');
    Route::get('/noticia/{id}/download-file/{fileId}', 'NoticiaController@downloadFile')->name('noticia.download.file');
});

Route::prefix('admin')->middleware(['auth', 'revalidate', 'login.unique'])->namespace('Site\Admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/acl', 'AdminController@indexACL')->name('admin.acl');    
    Route::get('/user/profile', 'ACL\UserController@profile')->name('user.profile');    
    Route::get('/noticia/{id}/upload/image', 'NoticiaController@uploadImageForm')->name('noticia.upload.image');
    Route::post('/noticia/upload/image', 'NoticiaController@uploadImage')->name('noticia.store.upload.image');
    Route::post('/noticia/upload/file', 'NoticiaController@uploadFile')->name('noticia.store.upload.file');
    Route::delete('/noticia/{id}/destroy/image/{imageId}', 'NoticiaController@destroySingleImage')->name('noticia.destroy.image');
    Route::delete('/noticia/{id}/destroy/file/{FileId}', 'NoticiaController@destroySingleFile')->name('noticia.destroy.file');
    Route::post('/noticia/{id}/capa/image/{imageId}', 'NoticiaController@setCapa')->name('noticia.image.capa');
    Route::get('/noticia/{id}/upload/file', 'NoticiaController@uploadFileForm')->name('noticia.upload.file');    
    Route::resource('/noticia', 'NoticiaController');
    Route::resource('/curso', 'Curso\CursoController');
    Route::get('/curso/{id}/upload/file', 'CursoController@uploadFileForm')->name('curso.upload.file');    
    Route::resource('/curso/tipocurso', 'Curso\TipoCursoController');
    Route::resource('curso/modalidade', 'Curso\ModalidadeController');
    
    Route::prefix('acl')->namespace('ACL')->middleware('auth', 'revalidate')->group(function(){
        Route::get('/user/send-email', 'UserController@sendEMail');
        Route::resource('/perfil', 'PerfilController');    
        Route::resource('/permissao', 'PermissaoController');    
        Route::resource('/user', 'UserController');                    
    });    
});


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('500', function()
{
    abort(500);
});
