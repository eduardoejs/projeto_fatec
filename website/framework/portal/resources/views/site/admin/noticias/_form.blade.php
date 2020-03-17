<div class="form-row ml-auto mr-auto mt-2">
    <div class="form-group col-md-8">
        <label for="titulo">Título da notícia</label>            
        <input type="text" name="titulo" value="{{ old('titulo') ?? ($registro->titulo ?? '') }}" class="form-control {{ $errors->has('titulo') ? ' is-invalid' : '' }}" placeholder="Ex.: Instituição participa de evento voltado à área XYZ" required>        
        @if ($errors->has('titulo'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('titulo') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group col-md-2">
        <label for="data_exibicao">Visualizar até <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Para exibir a notícia de forma INDETERMINADA deixe o campo VAZIO. Para exibir a notícia até uma data determinada, informe-a no campo abaixo"></i></span></label>
        <input id="datepicker" type="text" name="data_exibicao" value="{{ old('data_exibicao') ?? ( (isset($registro)) ? ((!is_null($registro->data_exibicao)) ? \Carbon\Carbon::parse($registro->data_exibicao)->format('d/m/Y') : '') : '' ) }}" class="form-control {{ $errors->has('data_exibicao') ? ' is-invalid' : '' }}" >
        @if ($errors->has('data_exibicao'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('data_exibicao') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group col-md-2">
        <label for="data_exibicao">Ativo <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Selecionando NÃO, a notícia não será exibida no portal, independente de ter sido ou não informada uma data no campo 'Visualizar até'"></i></span></label>
        <select name="status" id="" class="form-control">
            <option {{ (old('status') == 'S' ? 'selected' : '') }} @if (isset($registro) && $registro->ativo == 'S') selected @endif value="S">SIM</option>
            <option {{ (old('status') == 'N' ? 'selected' : '') }} @if (isset($registro) && $registro->ativo == 'N') selected @endif value="N">NÃO</option>
        </select>
    </div>             
    <div class="form-group col-md-12">
        <label for="">Conteúdo da notícia</label>
        <textarea class="form-control" id="editor" name="conteudo" required>
            {{ old('conteudo') ?? ($registro->conteudo ?? '') }}
        </textarea>
    </div>
</div>     