<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Dados</a>
        <a class="nav-item nav-link" id="nav-perfil-tab" data-toggle="tab" href="#nav-perfil" role="tab" aria-controls="nav-perfil" aria-selected="false">Perfil</a>        
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-row ml-auto mr-auto mt-2">

            <div class="form-group col-md-6">
                <label for="nome">Nome</label>            
                <input type="text" name="nome" value="{{ old('nome') ?? ($registro->nome ?? '') }}" class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}" placeholder="Nome completo" required>
                @if ($errors->has('nome'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nome') }}</strong>
                    </span>
                @endif
            </div>
            
            <div class="form-group col-md-2">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" value="{{ old('cpf') ?? ($registro->cpf ?? '') }}" class="form-control {{ $errors->has('cpf') ? ' is-invalid' : '' }}" placeholder="Ex.: 111.222.333-44" required>
                @if ($errors->has('cpf'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('cpf') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-2">
                <label for="sexo">Sexo</label>
                <select name="sexo" id="sexo" class="custom-select">
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                </select>            
            </div>

            <div class="form-group col-md-2">
                <label for="fone">Telefone</label>            
                <input type="text" name="fone" value="{{ old('fone') ?? ($registro->telefone ?? '') }}" class="form-control {{ $errors->has('fone') ? ' is-invalid' : '' }}" placeholder="Telefone" required>
                @if ($errors->has('fone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('fone') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="email">E-Mail</label>            
                <input type="text" name="email" value="{{ old('email') ?? ($registro->email ?? '') }}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" required>                
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-2">
                <label for="senha">Senha</label>            
                <input type="password" name="senha" value="{{ old('senha') ?? ($registro->password ?? '') }}" class="form-control {{ $errors->has('senha') ? ' is-invalid' : '' }}" placeholder="" required>                
                @if ($errors->has('senha'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('senha') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-2">
                <label for="status">Permite Login <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Permite o usuário acessar a área administrativa"></i></span></label>
                <select name="status" class="custom-select">                    
                    <option value="S">SIM</option>
                    <option value="N">NÃO</option>                    
                </select>            
            </div>

            <div class="form-group col-md-2">
                <label for="selectTipo">Tipo de Usuário</label>
                <select name="selectTipo" id="selecionaTipo" class="custom-select">
                    <option value="F">Funcionário</option>
                    <option value="D">Docente</option>
                    <option value="A">Aluno</option>
                    <option value="EX">Ex-Aluno</option>
                    <option value="C">Externo / Convidado</option>
                </select>
            </div>
        </div>
        <div id='tipoFuncionario' class="form-row mr-auto ml-auto">
                <hr>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exibe_dados">Cargo</label>
                        <select name="exibe_dados" class="custom-select">                    
                            <option value="S">Analista de Suporte e Gestão - Tecnólogo em Informática</option>
                            <option value="N">NÃO</option>                    
                        </select>                
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exibe_dados">Departamento </label>
                        <select name="exibe_dados" class="custom-select">                    
                            <option value="S">Diretoria de Serviços Administrativos</option>
                            <option value="N">Secretaria Acadêmica</option>                    
                        </select>                
                    </div>
                    <div class="form-group col-md-4">
                        <label for="lattes_funcionario">Currículo Lattes</label>
                        <input type="url" name="lattes_funcionario" value="{{ old('lattes_funcionario') ?? ($registro->url_lattes ?? '') }}" class="form-control {{ $errors->has('lattes_funcionario') ? ' is-invalid' : '' }}" placeholder="Ex.: http://lattes.cnpq.br/xyz">
                        @if ($errors->has('lattes_funcionario'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('lattes_funcionario') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-2">
                        <label for="exibe_dados">Exibir dados <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Permite exibir alguns dados do usuário na página do portal"></i></span></label>
                        <select name="exibe_dados" class="custom-select">                    
                            <option value="S">SIM</option>
                            <option value="N">NÃO</option>                    
                        </select>                
                    </div>
                </div>
            </div>
            <div id='tipoDocente' class="form-row mr-auto ml-auto">
                <hr>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="exibe_dados">Cargo</label>
                        <select name="exibe_dados" class="custom-select">                    
                            <option value="S">Analista de Suporte e Gestão - Tecnólogo em Informática</option>
                            <option value="N">NÃO</option>                    
                        </select>                
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exibe_dados">Titulação </label>
                        <select name="exibe_dados" class="custom-select">                    
                            <option value="D">Doutorado</option>
                            <option value="M">Mestrado</option>                    
                            <option value="PG">Pós-Graduado (Especialização)</option>                    
                            <option value="L">Licenciatura</option>                    
                            <option value="G">Graduação</option>
                        </select>                
                    </div>
                    <div class="form-group col-md-5">
                        <label for="lattes_docente">Currículo Lattes</label>
                        <input type="url" name="lattes_docente" value="{{ old('lattes_docente') ?? ($registro->url_lattes ?? '') }}" class="form-control {{ $errors->has('lattes_docente') ? ' is-invalid' : '' }}" placeholder="Ex.: http://lattes.cnpq.br/xyz">
                        @if ($errors->has('lattes_docente'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('lattes_docente') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-5">
                        <label for="link_compartilhado">Link Compartilhado <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Permite compartilhar de forma pública um endereço ou página pessoal. Exemplo: OneDrive, Google Drive, Dropbox, etc."></i></span></label>
                        <input type="url" name="link_compartilhado" value="{{ old('link_compartilhado') ?? ($registro->link_compartilhado ?? '') }}" class="form-control {{ $errors->has('link_compartilhado') ? ' is-invalid' : '' }}" placeholder="Ex.: http://lattes.cnpq.br/xyz">
                        @if ($errors->has('link_compartilhado'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('link_compartilhado') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-2">
                        <label for="exibe_dados">Exibir dados <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Permite exibir alguns dados do usuário na página do portal"></i></span></label>
                        <select name="exibe_dados" class="custom-select">                    
                            <option value="S">SIM</option>
                            <option value="N">NÃO</option>                    
                        </select>                
                    </div>
                </div>
            </div>
            <div id='tipoAluno' class="form-row mr-auto ml-auto">
                <hr>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="matricula">Matrícula</label>
                        <input type="text" name="matricula" value="{{ old('matricula') ?? ($registro->matricula ?? '') }}" class="form-control {{ $errors->has('matricula') ? ' is-invalid' : '' }}" placeholder="" required>                
                        @if ($errors->has('matricula'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('matricula') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
    </div>
    <div class="tab-pane fade" id="nav-perfil" role="tabpanel" aria-labelledby="nav-perfil-tab">
        
        <div class="form-row table-responsive mt-2 ml-auto mr-auto">
            <h5 >Vincular um perfil ao novo usuário</h5>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Perfil</th>
                        <th>Descrição</th>
                        <th><i class="fa fa-shield-alt"></i></th>                                    
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perfis as $perfil)
                        <tr>
                            <td>{{ $perfil->id }}</td>
                            <td>{{ $perfil->nome }}</td>
                            <td>{{ $perfil->descricao }}</td>
                            <td>
                                <div class="custom-control custom-switch">                                          
                                @php
                                    $checked = '';
                                    if(old('perfis') ?? false) {
                                        foreach(old('perfis') as $key => $id){
                                            if($perfil->id == $id){
                                                $checked = 'checked';
                                            }
                                        }
                                    }else{
                                        if($registro ?? false){
                                            foreach($registro->perfis as $lista){
                                                if($lista->id == $perfil->id){
                                                    $checked = 'checked';
                                                }
                                            }
                                        }
                                    }
                                @endphp                                                                           
                                    <input {{$checked}} type="checkbox" class="custom-control-input" name="perfis[]" id="customSwitch{{ $perfil->id }}" value="{{ $perfil->id }}">
                                    <label class="custom-control-label" for="customSwitch{{ $perfil->id }}"></label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>                        
        </div>
    </div>    
</div>
