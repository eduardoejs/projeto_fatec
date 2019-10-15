<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active align-middle" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-keyboard fa-2x align-middle"></i> Escrever Notícia</a>
        <a class="nav-item nav-link align-middle" id="nav-imagens-tab" data-toggle="tab" href="#nav-imagens" role="tab" aria-controls="nav-imagens" aria-selected="false"><i class="fas fa-images fa-2x align-middle"></i> Imagens da Notícia</a>        
        <a class="nav-item nav-link align-middle" id="nav-files-tab" data-toggle="tab" href="#nav-files" role="tab" aria-controls="nav-files" aria-selected="false"><i class="fas fa-file-upload fa-2x align-middle"></i> Arquivos da Notícia</a>        
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-row ml-auto mr-auto mt-2">
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
            
            <div class="form-group col-md-12">
                <label for="">Conteúdo da notícia</label>
                <textarea class="form-control" id="editor1" name="editor1"></textarea>
            </div>    
            
        </div> 
    </div>
    <div class="tab-pane fade" id="nav-imagens" role="tabpanel" aria-labelledby="nav-imagens-tab">
        <div class="form-row ml-auto mr-auto mt-2">                
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Imagens da notícia</h5>
                    <div class="card-body">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Banco de imagem do sistema</h5>
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Go somewhere</a>
                    </div>
                </div>
            </div>
                
        </div>
    </div>
    <div class="tab-pane fade" id="nav-files" role="tabpanel" aria-labelledby="nav-files-tab">
            <div class="form-row ml-auto mr-auto mt-2">
            </div>
        </div>
</div>

