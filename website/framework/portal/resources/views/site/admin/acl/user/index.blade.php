@extends('layouts.site.admin.app')

@section('css')
    <style>
        .myaccordion {
  max-width: 500px;
  margin: 1px auto;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
 
.myaccordion .card,
.myaccordion .card:last-child .card-header {
  border: none;
}
 
.myaccordion .card-header {
  border-bottom-color: #EDEFF0;
  background: transparent;
}
 
.myaccordion .fa-stack {
  font-size: 10px;
}
 
.myaccordion .btn {
  width: 100%;
  font-weight: bold;
  color: #004987;
  padding: 0;
}
 
.myaccordion .btn-link:hover,
.myaccordion .btn-link:focus {
  text-decoration: none;
}
 
.myaccordion li + li {
  margin-top: 10px;
}    
    </style>
@endsection

@section('content')    
    @page_component(['col' => 12])
    
        @breadcrumb_component(['page' => $page, 'items' => $breadcrumb ?? []])
        @endbreadcrumb_component
    
        @alert_component(['msg' => session('msg'), 'title' => session('title'), 'status' => session('status')])
        @endalert_component
        
        @bodypage_component(['titulo' => $tituloPagina, 'descricao' => $descricaoPagina, 'rotaNome' => $rotaNome, 'page' => $page])
            
            @section('search')
                @busca_component(['rotaNome' => $rotaNome, 'search' => $search, 'page' => $page])
                    <div class="input-group input-group-sm mb-2 ml-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tipo</span>
                        </div>
                        <select name="filtro" class="custom-select" id="inputGroupSelect" aria-label="Example select">                                                        
                            <option {{ ($filtro == 'F' ? 'selected' : '') }} value="F">Funcionário</option>
                            <option {{ ($filtro == 'D' ? 'selected' : '') }} value="D">Docente</option>
                            <option {{ ($filtro == 'A' ? 'selected' : '') }} value="A">Aluno</option>
                            <option {{ ($filtro == 'EX' ? 'selected' : '') }} value="EX">Ex-Aluno</option>
                            <option {{ ($filtro == 'C' ? 'selected' : '') }} value="C">Comunidade Externa / Convidado</option>
                        </select>
                        
                    </div> 
                @endbusca_component            
            @endsection
            
            @table_component(['colunas' => $colunas, 'list' => $list, 'rotaNome' => $rotaNome])
            @endtable_component

            {{ $list->appends(request()->query())->links() }}
        @endbodypage_component
                
    @endpage_component
@endsection

@section('js')
    <script>
    $("#accordion").on("hide.bs.collapse show.bs.collapse", e => {
    $(e.target)
        .prev()
        .find("i:last-child")
        .toggleClass("fa-minus fa-plus");
    });
    </script>
@endsection