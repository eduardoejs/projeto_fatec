<?php

use App\Models\Acl\Perfil;
use App\Models\Acl\Permissao;
use Illuminate\Database\Seeder;

class AclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perfis')->delete();
        Perfil::create([
          'nome' => 'ADMINISTRADOR',
          'descricao' => 'Perfil de usuário ADMINISTRADOR do sistema'          
        ]);
        Perfil::create([
          'nome' => 'DOCENTE',
          'descricao' => 'Perfil de usuário do tipo DOCENTE'
        ]);
        Perfil::create([
          'nome' => 'FUNCIONARIO',
          'descricao' => 'Perfil de usuário do tipo FUNCIONARIO'
        ]);
        Perfil::create([
          'nome' => 'ALUNO',
          'descricao' => 'Perfil de usuário do tipo ALUNO'
        ]);
        Perfil::create([
          'nome' => 'EX-ALUNO',
          'descricao' => 'Perfil de usuário do tipo EX-ALUNO'
        ]);
        Perfil::create([
            'nome' => 'CONVIDADO',
            'descricao' => 'Perfil de usuário do tipo CONVIDADO'
          ]);

        DB::table('permissoes')->delete();
        /*  =============================================================== */
        Permissao::create([
          'nome' => 'create-user',
          'descricao' => 'Permite CRIAR um usuário',
          
        ]);
        Permissao::create([
          'nome' => 'read-user',
          'descricao' => 'Permite LER/ACESSAR os dados de um usuário'
        ]);
        Permissao::create([
          'nome' => 'update-user',
          'descricao' => 'Permite EDITAR um usuário'
        ]);
        Permissao::create([
          'nome' => 'delete-user',
          'descricao' => 'Permite EXCLUIR um usuário'
        ]);
        Permissao::create([
          'nome' => 'set-status-user',
          'descricao' => 'Permite ALTERAR o status do Usuário'
        ]);
        /*  =============================================================== */
        Permissao::create([
          'nome' => 'create-permission',
          'descricao' => 'Permite CRIAR uma nova permissão'
        ]);
        Permissao::create([
          'nome' => 'read-permission',
          'descricao' => 'Permite LER/ACESSAR uma permissão'
        ]);
        Permissao::create([
          'nome' => 'update-permission',
          'descricao' => 'Permite EDITAR uma permissão'
        ]);
        Permissao::create([
          'nome' => 'delete-permission',
          'descricao' => 'Permite EXCLUIR uma permissão'
        ]);
        Permissao::create([
          'nome' => 'set-perfil-user',
          'descricao' => 'Permite VINCULAR um Perfil à um Usuário'
        ]);
        Permissao::create([
          'nome' => 'set-permission-perfil',
          'descricao' => 'Permite VINCULAR uma Permissão à um Perfil'
        ]);
    }
}
