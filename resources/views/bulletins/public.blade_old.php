<!-- componente personalizado de search -->
<x-bulletins.public_search title="Busca de Boletins" :bulletins="$bulletins" :request="$request" :mensagem-sucesso="$mensagemSucesso">
    <!--filtros de search -->
    <x-bulletins.public_filter_search :request="$request"> </x-bulletins.public_filter_search>    
    <!-- fim filtros de search -->
    
    @if(isset($request))
        @switch($request->filter_type_view)
            @case("type_view_arquivo")
                <!-- visualização de search -->
                <x-bulletins.public_view_files :bulletins="$bulletins"> </x-bulletins.public_view_files>
                <!-- fim visualização de search -->
            @break            
            @case("type_view_texto")
                <!-- visualização de search -->
                <x-bulletins.public_view_sentences :bulletins="$bulletins" :request="$request"> </x-bulletins.public_view_files>
                <!-- fim visualização de search -->
            @break                
        @endswitch        
    @else
        <!-- se não houver requisição mostro os arquivos-->
        <!-- visualização de search -->
        <x-bulletins.public_view_files :bulletins="$bulletins"> </x-bulletins.public_view_files>
        <!-- fim visualização de search -->                 
    @endif
    
</x-bulletins.public_search >
<!-- componente personalizado de search -->