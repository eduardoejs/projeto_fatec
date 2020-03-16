<div class="form-row ml-auto mr-auto mt-2">
    <div class="form-group col-md-12">
        <input type="hidden" name="noticiaId" value="{{ $noticia->id }}">
        <div class="input-group">                                                
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">                                
                        Selecionar imagens<input type="file" style="display: none;" multiple name='imagens[]' accept="image/jpg, image/jpeg, image/gif, image/png">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
            <span class="help-block">
                Selecione um ou mais arquivos de imagem para a notícia. Formatos aceitos: <b>JPG, JPEG, GIF, PNG</b>
            </span>                        
        </div>
    </div>            
</div>
    