<div class="form-row">
    <div class="form-group col-md-4">
        <label for="nome">Nome do curso</label>
        <input type="text" name="nome" value="{{ old('nome') ?? ($registro->nome ?? '') }}" class="form-control {{ $errors->has('nome') ? ' is-invalid' : '' }}" placeholder="Ex.: Tecnologia em ..." required>
        @if ($errors->has('nome'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nome') }}</strong>
            </span>
        @endif        
    </div>
    <div class="form-group col-md-2">
        <label for="duracao">Duração (em anos)</label>
        <input type="number" name="duracao" value="{{ old('duracao') ?? ($registro->duracao ?? '') }}" class="form-control {{ $errors->has('duracao') ? ' is-invalid' : '' }}" placeholder="" required>
        @if ($errors->has('duracao'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('duracao') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group col-md-2">
        <label for="qtde_vagas">Quantidade de vagas</label>
        <input type="number" name="qtde_vagas" value="{{ old('qtde_vagas') ?? ($registro->qtde_vagas ?? '') }}" class="form-control {{ $errors->has('qtde_vagas') ? ' is-invalid' : '' }}" placeholder="" required>
        @if ($errors->has('qtde_vagas'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('qtde_vagas') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group col-md-3">
        <label for="periodo">Período do curso </label>        
        @if ($errors->has('periodo'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('periodo') }}</strong>
            </span>
        @endif
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="periodos[]" value="M">
                <label class="form-check-label" for="inlineCheckbox1">Manhã</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="periodos[]" value="T">
                <label class="form-check-label" for="inlineCheckbox2">Tarde</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="periodos[]" value="N">
                <label class="form-check-label" for="inlineCheckbox3">Noite</label>
            </div>
        </div>
    </div>
    <div class="form-group col-md-1">
        <label for="ativo">Ativo</label>
        <select name="ativo" class="custom-select">                    
            <option {{ (old('ativo') == 'S' ? 'selected' : '') }} @if (isset($registro) && $registro->ativo == 'S') selected @endif value="S">SIM</option>
            <option {{ (old('ativo') == 'N' ? 'selected' : '') }} @if (isset($registro) && $registro->ativo == 'N') selected @endif value="N">NÃO</option>                    
        </select>            
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-2">
        <label for="tipoCurso">Tipo de curso</label>
        <select name="tipoCurso" class="custom-select">
            @foreach ($tipos as $tipo)
                <option {{ (old('tipoCurso') == $tipo->id ? 'selected' : '') }} value="{{$tipo->id}}">{{$tipo->descricao}}</option>
            @endforeach
        </select>            
    </div>
    <div class="form-group col-md-2">
        <label for="modalidade">Modalidade de curso</label>
        <select name="modalidade" class="custom-select">
            @foreach ($modalidades as $modalidade)
                <option {{ (old('modalidade') == $modalidade->id ? 'selected' : '') }} value="{{$modalidade->id}}">{{$modalidade->descricao}}</option>
            @endforeach
        </select>            
    </div>
    <div class="form-group col-md-4">
        <label for="coodenador">Coordenador do curso</label>
        <select name="coordenador" class="custom-select">
            @foreach ($docentes as $docente)                        
                <option {{ (old('coordenador') == $docente->id ? 'selected' : '') }} value="{{$docente->id}}">{{$docente->nome}}</option>
            @endforeach
        </select>            
    </div>
    <div class="form-group col-md-4">
        <label for="email">E-Mail do coordenação</label>
        <input type="email" name="email" value="{{ old('email') ?? ($registro->email ?? '') }}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="" required>
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif        
    </div>
</div>
<div class="form-row ml-auto mr-auto mt-2">    
    <div class="form-group col-md-12">
        <label for="">Conteúdo da descrição do curso</label>
        <textarea class="form-control" id="editor" name="conteudo" required>
            {{ old('conteudo') ?? ($registro->conteudo ?? '') }}
        </textarea>
    </div>
</div>