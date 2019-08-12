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
            echo "<ol><li>$aluno->nome - </li></ol>";
        }
        echo 'Curso: '.$curso->nome .' - '.$curso->tipoCurso->descricao.' - '.
        $curso->modalidade->descricao.' - Coordenador(a): '.$curso->docente->nome.'<br>';
        foreach ($curso->disciplinas as $disciplina) {
            //echo '<ul><li>'.$disciplina->nome .' - '.$disciplina->pivot->carga_horaria.' horas. Semestre: '.$disciplina->pivot->semestre.' Docente: '.Docente::findOrFail($disciplina->pivot->docente_id)->nome.'</li></ul>';
            echo '<ul><li>'.$disciplina->nome .' - '.$disciplina->pivot->carga_horaria.' horas. Semestre: '.$disciplina->pivot->semestre.' Docente: '.$curso->docente->where('id', $disciplina->pivot->docente_id)->first()->nome.'</li></ul>';
        }
        //echo $curso->disciplinas()->where('docente_id',2)->get();
    }
    $tipo = App\Models\Cursos\TipoCurso::find(1);    
    echo $tipo->cursos[0]->nome;
    $aluno = App\Models\Institucional\TiposUsuarios\Aluno::findOrFail(1);
    echo '<br>Aluno: '.$aluno->nome.' - Cursando: '.$aluno->curso->nome.' Login:'.$aluno->user->email;
})->name('teste');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'Site\Publico\SiteController@index')->name('site');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
