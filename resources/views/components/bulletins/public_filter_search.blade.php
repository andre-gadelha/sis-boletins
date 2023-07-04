<form action="{{ route('bulletins.results_of_search') }}" method="post">    
    @csrf
    
    <!-- bloco dos radios com o tipo de visualização -->
    <!-- bloco do periodo com date -->    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="input-group input-group-lg mt-2 mb-1">    
            <!-- Radios de filtro -->
            <!--
            <div class="input-group-text bg-white">
                <label class="mr-2">Tipo de visualização</label>
            </div>
        
            <div class="input-group-text bg-white">
                <input name="filter_type_view" id="filter_type_view_file" class="form-check-input mt-0" type="radio" CHECKED value="type_view_arquivo" aria-label="Arquivos?" {{ isset($request) ? ($request->filter_type_view == "type_view_arquivo" ? 'checked':''):''}}>
                <i class="bi bi-filetype-pdf ml-2" for="filter_type_view_file"></i>
            </div>
            
            <div class="input-group-text bg-white">
                <input name="filter_type_view" id="filter_type_view_text" class="form-check-input mt-0" type="radio" value="type_view_texto"
                    aria-label="Texto?" {{ isset($request) ? ($request->filter_type_view == "type_view_texto" ? 'checked':''):''}}>
                <i class="bi bi-justify ml-2" for="filter_type_view_text"></i>
            </div>
            -->
            <!-- fim Radios de filtro -->
            
            <!-- datepickers de filtro -->
            <div class="input-group-text bg-white">
                <label >Período</label>
            </div>
            <div class="input-group-text bg-white">
                <label class="mr-2" for="filter_date_start">Data Início</label>
                <input name="filter_date_start" id="filter_date_start" class="form-date-input mt-0" type="date"
                    aria-label="Arquivos?" value="{{ isset($request) ?  $request->filter_date_start : old('filter_date_start') }}">
            </div>
            <div class="input-group-text bg-white">
                <label class="mr-2" for="filter_date_start">Data Fim</label>
                <input name="filter_date_end" id="filter_date_end" class="form-date-input mt-0" type="date"
                    aria-label="Texto?" value="{{ isset($request) ? $request->filter_date_end : old('filter_date_end') }}">
            </div>
            <!-- datepickers de filtro -->

        </div>
    </div>
    
    <!-- bloco do input com botão -->    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="input-group input-group-lg mt-2 mb-1">            
            <!-- caixa de texto -->
            <input autofocus name="words_to_filter" id="words_to_filter" type="text" class="form-control" placeholder="Informe um termo para pesquisa no conteúdo dos boletins"
                aria-label="Informe um termo para pesquisa no conteúdo dos boletins?" aria-describedby="button-addon2" value="{{ isset($request) ? $request->words_to_filter : old('words_to_filter') }}">
     
            <!-- botão de submit -->
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                <i class="bi bi-search"> </i> Pesquisar
            </button>
        </div>
        <label>*Preenchimento obrigatório dos campos para pesquisa</label>
    </div>    
</form>