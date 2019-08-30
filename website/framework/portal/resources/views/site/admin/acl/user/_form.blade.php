
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="nome">Nome (Tag)</label>            
            <input type="text" name="nome" value="{{ old('nome') ?? ($registro->nome ?? '') }}" class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}" placeholder="Ex.: create-user">           
            
            @if ($errors->has('nome'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nome') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" value="{{ old('descricao') ?? ($registro->descricao ?? '') }}" class="form-control {{ $errors->has('descricao') ? ' is-invalid' : '' }}" placeholder="Ex.: Permite CRIAR um usuário">
            @if ($errors->has('descricao'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('descricao') }}</strong>
                </span>
            @endif
        </div>
    </div>       
    <span class="alert alert-secondary d-block text-center">Vincular um perfil a nova permissão</span>
    <div class="form-row table-responsive">
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
