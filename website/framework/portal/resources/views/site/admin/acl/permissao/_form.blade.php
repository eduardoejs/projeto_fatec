
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="nome">Nome (Tag)</label>
            @if (isset($registro) && $registro->nome == 'ADMINISTRADOR')
                <input type="text" name="nome" value="{{ old('nome') ?? ($registro->nome ?? '') }}" class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}" placeholder="Ex.: Editor-Site" readonly>    
            @else
                <input type="text" name="nome" value="{{ old('nome') ?? ($registro->nome ?? '') }}" class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}" placeholder="Ex.: Editor-Site">
            @endif
            
            @if ($errors->has('nome'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nome') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-md-6">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" value="{{ old('descricao') ?? ($registro->descricao ?? '') }}" class="form-control {{ $errors->has('descricao') ? ' is-invalid' : '' }}" placeholder="Ex.: Perfil de usuário do tipo Editor-Site">
        </div>
    </div>
    <div class="form-row">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Permissão</th>
                    <th>Descrição</th>
                    <th><i class="fa fa-shield"></i></th>                                    
                </tr>
            </thead>
            <tbody>
                @foreach ($permissoes as $permissao)
                    <tr>
                        <td>{{ $permissao->id }}</td>
                        <td>{{ $permissao->nome }}</td>
                        <td>{{ $permissao->descricao }}</td>
                        <td>
                            <div class="custom-control custom-switch">                                          
                            @php
                                $checked = '';
                                if(old('permissions') ?? false) {
                                    foreach(old('permissions') as $key => $id){
                                        if($permissao->id == $id){
                                            $checked = 'checked';
                                        }
                                    }
                                }else{
                                    if($registro ?? false){
                                        foreach($registro->permissoes as $lista){
                                            if($lista->id == $permissao->id){
                                                $checked = 'checked';
                                            }
                                        }
                                    }
                                }
                            @endphp                                                                           
                                <input {{$checked}} type="checkbox" class="custom-control-input" name="permissions[]" id="customSwitch{{ $permissao->id }}" value="{{ $permissao->id }}">
                                <label class="custom-control-label" for="customSwitch{{ $permissao->id }}"></label>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>                        
    </div>
