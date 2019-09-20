<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active align-middle" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-id-badge fa-3x align-middle"></i> Dados Pessoais</a>
        <a class="nav-item nav-link align-middle" id="nav-perfil-tab" data-toggle="tab" href="#nav-perfil" role="tab" aria-controls="nav-perfil" aria-selected="false"><i class="fas fa-user-shield fa-3x align-middle"></i> Perfil no Sistema</a>        
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
                <input type="text" name="cpf" value="{{ old('cpf') ?? ($registro->cpf ?? '') }}" class="cpf form-control {{ $errors->has('cpf') ? ' is-invalid' : '' }}" placeholder="Ex.: 111.222.333-44" required>
                @if ($errors->has('cpf'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('cpf') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-2">
                <label for="sexo">Sexo</label>
                <select name="sexo" id="sexo" class="custom-select">
                    <option {{ (old('sexo') == 'M' ? 'selected' : '') }} @if (isset($registro) && $registro->sexo == 'M') selected @endif value="M">MASCULINO</option>
                    <option {{ (old('sexo') == 'F' ? 'selected' : '') }} @if (isset($registro) && $registro->sexo == 'F') selected @endif value="F">FEMININO</option>
                </select>            
            </div>

            <div class="form-group col-md-2">
                <label for="telefone">Telefone Celular</label>            
                <input type="text" name="telefone" value="{{ old('telefone') ?? ($registro->telefone ?? '') }}" class="phone_with_ddd form-control {{ $errors->has('telefone') ? ' is-invalid' : '' }}" placeholder="(00) 00000-0000">
                @if ($errors->has('telefone'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('telefone') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="email">E-Mail</label>            
                <input type="email" name="email" value="{{ old('email') ?? ($registro->email ?? '') }}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" required>                
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-2">
                <label for="password">Senha</label>            
                <input type="password" name="password" value="{{ old('password') ?? '' }}" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="">
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-2">
                <label for="ativo">Permite Login <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Permite o usuário acessar a área administrativa"></i></span></label>
                <select name="ativo" class="custom-select">                    
                    <option {{ (old('ativo') == 'S' ? 'selected' : '') }} @if (isset($registro) && $registro->ativo == 'S') selected @endif value="S">SIM</option>
                    <option {{ (old('ativo') == 'N' ? 'selected' : '') }} @if (isset($registro) && $registro->ativo == 'N') selected @endif value="N">NÃO</option>                    
                </select>            
            </div>

            <div class="form-group col-md-2">
                <label for="selectTipo">Tipo de Usuário</label>               
                <select name="selectTipo[]" id="selecionaTipo" class="selectpicker form-control custom-select" multiple title="Selecione um tipo" required>
                    @foreach ($tiposUsers as $tipo)
                        @php
                            $selected = '';
                            if(old('selectTipo') ?? false) {
                                foreach(old('selectTipo') as $key => $value) {
                                    if($tipo->valor == $value) {
                                        $selected = 'selected';
                                    }
                                }
                            } else {
                                if($registro ?? false) {                                    
                                    foreach ($tiposDoUsuario as $lista) {
                                        if($tipo->valor == $lista->valor) {
                                            $selected = 'selected';
                                        }
                                    }
                                }
                            }
                        @endphp
                        <option {{ $selected }} value="{{ $tipo->valor }}">{{$tipo->descricao}}</option>    
                    @endforeach                    
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="url_lattes">Currículo Lattes</label>
                <input type="url" name="url_lattes" value="{{ old('url_lattes') ?? ($registro->url_lattes ?? '') }}" class="form-control {{ $errors->has('url_lattes') ? ' is-invalid' : '' }}" placeholder="Ex.: http://lattes.cnpq.br/xyz">
                @if ($errors->has('url_lattes'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('url_lattes') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div id='tipoFuncionario' class="form-row mr-auto ml-auto">
                <hr>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="cargo_funcionario">Cargo do Funcionário</label>
                        <select name="cargo_funcionario" class="custom-select">                    
                            @foreach ($cargos as $cargo)
                                @php
                                    $selected = '';
                                    if(isset($registro) && isset($registro->funcionarios->first()->cargo_id)) {
                                        if($cargo->id == $registro->funcionarios->first()->cargo_id) {
                                            $selected = 'selected';
                                        }
                                    }                                    
                                @endphp                                
                                <option value="{{ $cargo->id }}" {{ $selected }}>{{ $cargo->nome }}</option>
                            @endforeach                   
                        </select>                
                    </div>
                    <div class="form-group col-md-6">
                        <label for="departamento_funcionario">Departamento </label>
                        <select name="departamento_funcionario" class="custom-select">                    
                            @foreach ($departamentos as $departamento)
                                @php
                                    $selected = '';
                                    if(isset($registro) && isset($registro->funcionarios->first()->departamento_id)) {
                                        if($departamento->id == $registro->funcionarios->first()->departamento_id) {
                                            $selected = 'selected';
                                        }
                                    }                                    
                                @endphp 
                                <option value="{{ $departamento->id }}" {{ $selected }}>{{ $departamento->nome }}</option>
                            @endforeach                    
                        </select>                
                    </div>
                                        
                </div>
            </div>
            <div id='tipoDocente' class="form-row mr-auto ml-auto">
                <hr>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="cargo_docente">Cargo do Docente</label>
                        <select name="cargo_docente" class="custom-select">                    
                            @foreach ($cargos as $cargo)
                                @if ($cargo->id == old('cargo_docente'))
                                    <option selected value="{{ $cargo->id }}">{{ $cargo->nome }}</option>
                                @else
                                    @php
                                        $selected = '';
                                        if(isset($registro) && isset($registro->docentes->first()->cargo_id)) {
                                            if($cargo->id == $registro->docentes->first()->cargo_id) {
                                                $selected = 'selected';
                                            }
                                        }                                    
                                    @endphp 
                                    <option value="{{ $cargo->id }}" {{ $selected }} >{{ $cargo->nome }}</option>    
                                @endif                                
                            @endforeach
                        </select>                
                    </div>
                    <div class="form-group col-md-6">
                        <label for="titulacao">Titulação </label>
                        <select name="titulacao" class="custom-select">
                            @foreach ($titulacoes as $titulo)

                                @if ($titulo->valor == old('titulacao'))
                                    <option selected value="{{ $titulo->valor }}">{{ $titulo->descricao }}</option>
                                @else
                                    @php
                                        $selected = '';                                        
                                        if(isset($registro) && isset($registro->docentes->first()->titulacao)) {
                                            if($titulo->valor == $registro->docentes->first()->titulacao) {
                                                $selected = 'selected';
                                            }
                                        }                                    
                                    @endphp 
                                    <option value="{{ $titulo->valor }}" {{ $selected }} >{{ $titulo->descricao }}</option>    
                                @endif                                 
                            @endforeach                            
                        </select>                
                    </div>

                    <div class="form-group col-md-5">
                        <label for="link_compartilhado">Link Compartilhado <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Permite compartilhar de forma pública um endereço ou página pessoal. Exemplo: OneDrive, Google Drive, Dropbox, etc."></i></span></label>
                        <input type="url" name="link_compartilhado" value="{{ old('link_compartilhado') ?? (isset($registro) && isset($registro->docentes->first()->link_compartilhado) ? $registro->docentes->first()->link_compartilhado : '') }}" class="form-control {{ $errors->has('link_compartilhado') ? ' is-invalid' : '' }}" placeholder="Ex.: http://lattes.cnpq.br/xyz">
                        @if ($errors->has('link_compartilhado'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('link_compartilhado') }}</strong>
                            </span>
                        @endif
                    </div>                    
                </div>
            </div>
            <div id='tipoAluno' class="form-row mr-auto ml-auto">
                <hr>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="matricula">Registro Acadêmico (RA)</label>
                        <input type="number" name="matricula" value="{{ old('matricula') ?? (isset($registro) && isset($registro->alunos->first()->matricula) ? $registro->alunos->first()->matricula : '') }}" class="form-control {{ $errors->has('matricula') ? ' is-invalid' : '' }}" placeholder="">
                        @if ($errors->has('matricula'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('matricula') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="curso">Curso</label>
                        <select name="curso" class="custom-select">                    
                            @foreach ($cursos as $curso)
                                @if ($curso->id == old('curso'))
                                    <option selected value="{{ $curso->id }}">{{ $curso->nome }}</option>
                                @else
                                    @php
                                        $selected = '';                                        
                                        if(isset($registro) && isset($registro->alunos->first()->curso_id)) {
                                            if($curso->id == $registro->alunos->first()->curso_id) {
                                                $selected = 'selected';
                                            }
                                        }                                    
                                    @endphp 
                                    <option value="{{ $curso->id }}" {{ $selected }}>{{ $curso->nome }}</option>
                                @endif                                
                            @endforeach
                        </select> 
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
