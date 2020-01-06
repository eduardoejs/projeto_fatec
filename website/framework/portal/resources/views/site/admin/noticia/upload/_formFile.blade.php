<div class="form-row ml-auto mr-auto mt-2">
    <div class="form-group col-md-12">
        <input type="hidden" name="noticiaId" value="{{ $noticia->id }}">
        <label for="titulo_arquivo">Nome do arquivo</label>            
        <input type="text" name="titulo_arquivo" value="{{ old('titulo_arquivo') ?? ($registro->titulo_arquivo ?? '') }}" class="form-control" placeholder="" required>
        <label for="sescricao_arquivo">Descrição do arquivo</label>            
        <input type="text" name="descricao_arquivo" value="{{ old('descricao_arquivo') ?? ($registro->descricao_arquivo ?? '') }}" class="form-control" placeholder="">
        <div class="input-group mt-3">                                                
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">                                
                        Selecionar arquivo<input type="file" style="display: none;" name='arquivo' accept="pplication/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                        application/pdf, application/zip, application/rar">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
            <span class="help-block">
                Selecione um arquivo para a notícia. Formatos aceitos: <i class="far fa-file-pdf text-danger"></i> <i class="far fa-file-word text-primary"></i> <i class="far fa-file-excel text-success"></i> <i class="far fa-file-powerpoint text-danger"></i> <i class="fas fa-file-archive text-secondary"></i> 
            </span>                        
        </div>
    </div>            
</div>
    