<?php

use App\Models\Acl\User;
use App\Models\Acl\Perfil;
use Faker\Factory as Faker;
use App\Models\Cursos\Curso;
use Illuminate\Database\Seeder;
use App\Models\Cursos\TipoCurso;
use App\Models\Cursos\Disciplina;
use App\Models\Cursos\Modalidade;
use App\Models\Institucional\Cargo;
use App\Models\Institucional\Departamento;
use App\Models\Institucional\TiposUsuarios\Aluno;
use App\Models\Institucional\TiposUsuarios\Docente;
use App\Models\Institucional\TiposUsuarios\Funcionario;

class InstitucionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cargos')->delete();
        $c1 = Cargo::firstOrCreate(['nome' => mb_strtoupper('Analista de Suporte e Gestão')]);
        $c2 = Cargo::firstOrCreate(['nome' => mb_strtoupper('Auxiliar Docente')]);
        $c3 = Cargo::firstOrCreate(['nome' => mb_strtoupper('Agente Técnico Administrativo')]);
        $c4 = Cargo::firstOrCreate(['nome' => mb_strtoupper('Professor de Ensino Superior I')]);
        $c5 = Cargo::firstOrCreate(['nome' => mb_strtoupper('Professor de Ensino Superior II')]);
        $c6 = Cargo::firstOrCreate(['nome' => mb_strtoupper('Diretor')]);
        $c7 = Cargo::firstOrCreate(['nome' => mb_strtoupper('Diretor de Serviços Administrativos')]);
        $c8 = Cargo::firstOrCreate(['nome' => mb_strtoupper('Diretor de Serviços Acadêmicos')]);
        $c8 = Cargo::firstOrCreate(['nome' => mb_strtoupper('Coordenador de Curso')]);
        echo "Cargos criados com Sucesso! \n";      
        
        DB::table('departamentos')->delete();
        $d1 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Secretaria Acadêmica')]);
        $d2 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Diretoria de Serviços')]);
        $d3 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Informática')]);
        $d4 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Laboratório Físico-Químico')]);
        $d5 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Laboratório Micro-Biologia')]);
        $d6 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Laboratório Processamento de Alimentos')]);
        $d7 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Biblioteca')]);
        echo "Departamentos criados com Sucesso! \n";      

        DB::table('tipo_cursos')->delete();
        $tp1 = TipoCurso::firstOrCreate(['descricao' => mb_strtoupper('Graduação')]);
        $tp2 = TipoCurso::firstOrCreate(['descricao' => mb_strtoupper('Pós-Graduação')]);
        echo "Tipos de Cursos criados com Sucesso! \n";      
        
        DB::table('modalidades')->delete();
        $m1 = Modalidade::firstOrCreate(['descricao' => mb_strtoupper('Presencial')]);
        $m2 = Modalidade::firstOrCreate(['descricao' => mb_strtoupper('EAD - Ensino à Distância')]);
        echo "Modalidades de Curso criados com Sucesso! \n";      

        DB::table('users')->delete();
        $login1 = User::firstOrCreate(['nome' => 'Eduardo Jose da Silva', 'cpf' => '305.586.538-39', 'sexo' => 'M', 'email' => 'eduardo@mail.com', 'password' => bcrypt('123456'), 'tipo' => 'F', 'token_create' => md5('305.586.538-39')]);        
        $perfil = Perfil::find(1);
        $login1->perfis()->attach($perfil);
        $login2 = User::firstOrCreate(['nome' => 'Marie Oshiwa', 'cpf' => '111.222.333-44', 'sexo' => 'F', 'email' => 'marie@mail.com', 'password' => bcrypt('123456'), 'tipo' => 'D', 'token_create' => md5('111.222.333-44')]);
        $login3 = User::firstOrCreate(['nome' => 'Vitor Silva', 'cpf' => '555.525.525-66', 'sexo' => 'M', 'email' => 'vitor@mail.com', 'password' => bcrypt('123456'), 'tipo' => 'A', 'token_create' => md5('555.525.525-66')]);
        $login2 = User::firstOrCreate(['nome' => 'Sandra Barbalho', 'cpf' => '100.222.333-44', 'sexo' => 'F', 'email' => 'sandra@mail.com', 'password' => bcrypt('123456'), 'tipo' => 'D', 'token_create' => md5('100.222.333-44')]);
        echo "Logins de usuário criados com Sucesso! \n";       
        
        DB::table('docentes')->delete();
        $f1 = Docente::firstOrCreate([ 'cargo_id' => 4, 'titulacao' => 'D', 'user_id' => 2, 'cargo_id' => 4]);
        $f2 = Docente::firstOrCreate([ 'cargo_id' => 4, 'titulacao' => 'D', 'user_id' => 4, 'cargo_id' => 4]);
        
        DB::table('funcionarios')->delete();
        $f1 = Funcionario::firstOrCreate([ 'cargo_id' => 1, 'departamento_id' => 3, 'user_id' => 1]);
        
        DB::table('cursos')->delete();
        $curso = Curso::firstOrCreate(['nome' => 'Tecnologia em Alimentos', 'duracao' => 3, 'conteudo' => 'Bla bla bla', 'periodo' => 'M,N', 'qtde_vagas' => 40, 'tipo_curso_id' => 1, 'modalidade_id' => 1, 'docente_id' => 2]);
        echo "Cursos criados com Sucesso! \n";        

        DB::table('alunos')->delete();
        $f1 = Aluno::firstOrCreate([ 'matricula' => '20190604', 'user_id' => 3, 'curso_id' => 1]);
        echo "Dados de usuários criados com Sucesso! \n";

        /*$faker = Faker::create();        
        foreach (range(1,20) as $i) {
            $aluno = User::firstOrCreate(['nome' => $faker->name, 'cpf' => $faker->unique()->randomNumber($nbDigits = NULL, $strict = true), 'sexo' => 'M', 'email' => $faker->email, 'password' => bcrypt('123456'), 'tipo' => 'A']);
                Aluno::firstOrCreate([ 'matricula' => $faker->numberBetween($min = 1000, $max = 9000), 'user_id' => $aluno->id, 'curso_id' => 1]);
        }*/

        DB::table('disciplinas')->delete();
        $dc1 = Disciplina::firstOrCreate(['nome' => mb_strtoupper('Estatística Aplicada')]);
        $dc2 = Disciplina::firstOrCreate(['nome' => mb_strtoupper('Matemática')]);
        $dc2 = Disciplina::firstOrCreate(['nome' => mb_strtoupper('Bioquímica')]);
        echo "Disciplinas criadas com Sucesso! \n";
    }
}
