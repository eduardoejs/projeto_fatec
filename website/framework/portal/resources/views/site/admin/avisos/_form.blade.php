<div class="form-row ml-auto mr-auto mt-2">
    <div class="form-group col-md-10">
        <label for="titulo">Título do aviso</label>            
        <input type="text" name="titulo" value="{{ old('titulo') ?? ($registro->titulo ?? '') }}" class="form-control {{ $errors->has('titulo') ? ' is-invalid' : '' }}" placeholder="" required>        
        @if ($errors->has('titulo'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('titulo') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group col-md-2">
        <label for="data_exibicao">Visualizar até <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Para exibir a aviso de forma INDETERMINADA deixe o campo VAZIO. Para exibir a aviso até uma data determinada, informe-a no campo abaixo"></i></span></label>
        <input id="datepicker" type="text" name="data_exibicao" value="{{ old('data_exibicao') ?? ( (isset($registro)) ? ((!is_null($registro->data_exibicao)) ? \Carbon\Carbon::parse($registro->data_exibicao)->format('d/m/Y') : '') : '' ) }}" class="form-control {{ $errors->has('data_exibicao') ? ' is-invalid' : '' }}" >
        @if ($errors->has('data_exibicao'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('data_exibicao') }}</strong>
            </span>
        @endif
    </div> 
    <div class="form-group col-md-12">
        <label for="">Resumo do aviso</label>
        <textarea class="form-control" name="resumo" required>
            {{ old('resumo') ?? ($registro->resumo ?? '') }}
        </textarea>
    </div>   
    <div class="form-group col-md-12">
        <label for="">Conteúdo do aviso</label>
        <textarea class="form-control" id="editor" name="conteudo" required>
            {{ old('conteudo') ?? ($registro->conteudo ?? '') }}
        </textarea>
    </div>
</div>     