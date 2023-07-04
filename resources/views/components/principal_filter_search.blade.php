<form action="{{ route('bulletins.store_public') }}" method="post">
    
    @csrf
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="input-group input-group-lg mt-2 mb-1">
            <input name="words_to_filter" id="words_to_filter" type="text" class="form-control" placeholder="O que deseja localizar nos boletins?"
                aria-label="O que deseja localizar nos boletins?" aria-describedby="button-addon2">
    
            <!-- Radios de filtro -->
            <div class="input-group-text bg-white">
                <input name="filter_type_view" id="filter_type_view_arquivo" class="form-check-input mt-0" type="radio" value="type_view_arquivo"
                    aria-label="Arquivos?" checked>
                <i class="bi bi-filetype-pdf ml-2" for="filter_type_view_arquivo"></i>
            </div>
            <div class="input-group-text bg-white">
                <input name="filter_type_view" id="filter_type_view_texto" class="form-check-input mt-0" type="radio" value="type_view_texto"
                    aria-label="Texto?">
                <i class="bi bi-justify ml-2" for="filter_type_view_texto"></i>
            </div>
            <!-- fim Radios de filtro -->
    
            <!-- Radios de filtro -->
            <div class="input-group-text bg-white">
                <input name="filter_date_start" name="filter_date_start" class="form-date-input mt-0" type="date" value=""
                    aria-label="Arquivos?">
            </div>
            <div class="input-group-text bg-white">
                <input name="filter_date_end" name="filter_date_end" class="form-date-input mt-0" type="date" value=""
                    aria-label="Texto?">
            </div>
            <!-- fim Radios de filtro -->
    
            
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i
                    class="bi bi-search"></i>Pesquisar</button>
        </div>
    </div>
</form>