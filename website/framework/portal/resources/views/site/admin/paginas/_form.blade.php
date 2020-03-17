<div class="form-row ml-auto mr-auto mt-2">
    <div class="form-group col-md-12">
        <label for="parametro">Parâmetro Rota</label>            
        <input type="text" name="parametro" value="{{ old('parametro') ?? ($registro->parametro_rota ?? '') }}" class="form-control {{ $errors->has('parametro') ? ' is-invalid' : '' }}" placeholder="biblioteca ou pagina-xyz" required> 
        @if ($errors->has('parametro'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('parametro') }}</strong>
            </span>
        @endif
    </div>            
    <div class="form-group col-md-12">
        <label for="">Conteúdo da página</label>
        <textarea class="form-control" id="editor" name="conteudo" required>
            {{ old('conteudo') ?? ($registro->conteudo ?? '') }}
        </textarea>
    </div>
</div>