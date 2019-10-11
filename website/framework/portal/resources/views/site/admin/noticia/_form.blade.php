<div class="form-row">
    <div class="form-group col-md-8">
        <label for="titulo">Título da notícia</label>            
        <input type="text" name="titulo" value="{{ old('titulo') ?? ($registro->titulo ?? '') }}" class="form-control {{ $errors->has('titulo') ? ' is-invalid' : '' }}" placeholder="Ex.: Instituição participa de evento voltado à área XYZ">        
        @if ($errors->has('titulo'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('titulo') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group col-md-2">
        <label for="data_exibicao">Visualizar até <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Para exibir a notícia de forma INDETERMINADA deixe o campo VAZIO. Para exibir a notícia até uma data determinada, informe-a no campo abaixo"></i></span></label>
        <input id="datepicker" type="text" name="data_exibicao" value="{{ old('data_exibicao') ?? ($registro->data_exibicao ?? '') }}" class="form-control {{ $errors->has('data_exibicao') ? ' is-invalid' : '' }}" >
        @if ($errors->has('data_exibicao'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('data_exibicao') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group col-md-2">
        <label for="data_exibicao">Ativo <span class="text-info"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="Selecionando NÃO, a notícia não será exibida no portal, independente de ter sido ou não informada uma data no campo 'Visualizar até'"></i></span></label>
        <select name="status" id="" class="form-control">
            <option value="S">SIM</option>
            <option value="N">NÃO</option>
        </select>
    </div>    
</div> 
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="">Conteúdo da notícia</label>
        <textarea class="form-control" id="editor1" name="editor1" rows="500"></textarea>
    </div>    
</div>
