<?php

use Illuminate\Database\Seeder;

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
        $d4 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Laboratório FQ')]);
        $d5 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Laboratório MB')]);
        $d6 = Departamento::firstOrCreate(['nome' => mb_strtoupper('Laboratório PAL')]);
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
        $login1 = User::firstOrCreate(['email' => 'eduardo@mail.com', 'password' => bcrypt('123456'), 'tipo' => 'F']);
        $login2 = User::firstOrCreate(['email' => 'marie@mail.com', 'password' => bcrypt('123456'), 'tipo' => 'D']);
        $login3 = User::firstOrCreate(['email' => 'vitor@mail.com', 'password' => bcrypt('123456'), 'tipo' => 'A']);
        $login2 = User::firstOrCreate(['email' => 'sandra@mail.com', 'password' => bcrypt('123456'), 'tipo' => 'D']);
        echo "Logins de usuário criados com Sucesso! \n";       
        
        DB::table('docentes')->delete();
        $f1 = Docente::firstOrCreate(['nome' => 'Marie Oshiwa', 'cpf' => '11122233344', 'sexo' => 'F', 'cargo_id' => 4, 'titulacao' => 'D', 'user_id' => 2, 'cargo_id' => 4]);
        $f2 = Docente::firstOrCreate(['nome' => 'Sandra Barbalho', 'cpf' => '10022233344', 'sexo' => 'F', 'cargo_id' => 4, 'titulacao' => 'D', 'user_id' => 4, 'cargo_id' => 4]);
        
        DB::table('funcionarios')->delete();
        $f1 = Funcionario::firstOrCreate(['nome' => 'Eduardo Jose da Silva', 'cpf' => '30558653839', 'sexo' => 'M', 'cargo_id' => 1, 'departamento_id' => 3, 'user_id' => 1]);
        
        DB::table('cursos')->delete();
        $curso = Curso::firstOrCreate(['nome' => 'Tecnologia em Alimentos', 'duracao' => 3, 'conteudo' => 'Bla bla bla', 'periodo' => 'M,N', 'qtde_vagas' => 40, 'tipo_curso_id' => 1, 'modalidade_id' => 1, 'docente_id' => 1]);        
        echo "Cursos criados com Sucesso! \n";        

        DB::table('alunos')->delete();
        $f1 = Aluno::firstOrCreate(['nome' => 'Vitor Silva', 'cpf' => '55552552566', 'sexo' => 'M', 'matricula' => '20190604', 'user_id' => 3, 'curso_id' => 1]);
        echo "Dados de usuários criados com Sucesso! \n";

        DB::table('disciplinas')->delete();
        $dc1 = Disciplina::firstOrCreate(['nome' => mb_strtoupper('Estatística Aplicada')]);
        $dc2 = Disciplina::firstOrCreate(['nome' => mb_strtoupper('Matemática')]);
        $dc2 = Disciplina::firstOrCreate(['nome' => mb_strtoupper('Bioquímica')]);
        echo "Disciplinas criadas com Sucesso! \n";
    }
}
