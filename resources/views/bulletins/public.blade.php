<!-- componente personalizado de search -->
<x-bulletins.public_search title="Repositório de Boletins Internos da SEF" :bulletins="$bulletins" :request="$request" :mensagem-sucesso="$mensagemSucesso">
    <!--filtros de search -->
    <x-bulletins.public_filter_search :request="$request"> </x-bulletins.public_filter_search>    
    <!-- fim filtros de search -->
   
    <!-- Analisar as direticas do BLADE para OTIMIZAR CÓDIFO ABAIXO-->
    <!-- Testa requisição para apresentar arquivos-->
    <!-- visualização de search -->
    <!-- Testar Request e apresentar arquivos conforme conteúdo disponível (anos, meses e filtro solicitado) -->
    <!-- Apresenta tela para Selecionar ANO-->
    @empty($request)
        <x-bulletins.public_view_years_of_files :bulletins="$bulletins"> </x-bulletins.public_view_years_of_files>
    @endempty
    <!-- Testa se o mês ja foi seleciondo-->
    @isset($request)
        <!-- Apresenta tela para Selecionar MÊS ou arquivos confome o Formulário de Busca-->
        @empty($request->selected_month)
            @empty($request->words_to_filter)
                <x-bulletins.public_view_months_of_files :bulletins="$bulletins"> </x-bulletins.public_view_months_of_files>
            @endempty
            @isset($request->words_to_filter)       
                <x-bulletins.public_view_files :bulletins="$bulletins"> </x-bulletins..public_view_files>
            @endisset
        @endempty
        <!-- Apresenta tela para Selecionar ARQUIVO-->
        @isset($request->selected_month)               
            <x-bulletins.public_view_files :bulletins="$bulletins"> </x-bulletins..public_view_files>
        @endisset 
    @endisset   
    <!-- fim visualização de search -->                 
   
    <!-- paginaÃ§Ã£o do search -->
    <x-bulletins.public_pagination :bulletins="$bulletins"> </x-bulletins.public_pagination>  
    <!-- fim paginaÃ§Ã£o do search -->
</x-bulletins.public_search >
<!-- componente personalizado de search -->