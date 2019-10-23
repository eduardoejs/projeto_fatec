<div class="form-row ml-auto mr-auto mt-2">
    <div class="form-group col-md-12">
        <input type="hidden" name="noticiaId" value="{{ $noticia->id }}">
        {{--<label for="titulo_imagens">Título da imagem</label>            
        <input type="text" name="titulo_imagens" value="{{ old('titulo_imagens') ?? ($registro->titulo_imagens ?? '') }}" class="form-control" placeholder="">
        <label for="sescricao_imagens">Descrição da imagem</label>            
        <input type="text" name="descricao_imagens" value="{{ old('descricao_imagens') ?? ($registro->descricao_imagens ?? '') }}" class="form-control" placeholder="">--}}
        <div class="input-group mt-3">                                                
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">                                
                        Selecionar imagens<input type="file" style="display: none;" multiple name='imagens[]' accept="image/*">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
            <span class="help-block">
                Selecione um ou mais arquivos de imagem para a notícia
            </span>                        
        </div>
    </div>            
</div>
    