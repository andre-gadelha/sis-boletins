<form action="{{ $action }}" method="post">    
    @csrf
    @method('POST')
    <!-- bloco do input com botão -->    
    <div class="max-w-7xl mx-auto sm:px-10 lg:px-8">
        <div class="input-group input-group-lg mt-2 mb-1">            
            <!-- caixa de texto -->
            <input autofocus name="words_to_filter" id="words_to_filter" type="text" class="form-control" placeholder="O que deseja localizar conteúdo dos boletins?"
                aria-label="O que deseja localizar nos boletins?" aria-describedby="button-addon2" value="{{ old('words_to_filter') }}">
     
            <!-- botão de submit -->
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                <i class="bi bi-search"> </i> Pesquisar
            </button>
        </div>
    </div>
    <!-- bloco dos radios com o tipo de visualização -->
</form>