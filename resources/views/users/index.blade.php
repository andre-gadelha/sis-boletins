<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    {{ Breadcrumbs::render('users.index') }}
                </div>
                <div class="col-md-2">
                    
                </div>
            </div>
        </div>
    </x-slot>
    <!-- mensagens de erros ou success -->
    <x-alerts :mensagemSucesso="$mensagemSucesso" :errors="$errors" ></x-alerts>
    <!-- mensagens de erros ou success -->
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <!-- search file -->
                    <x-users.private_simple_filter_search :action="route('users.private_results_of_search')"></x-bulletins.private_simple_filter_search >
                    <!-- search file -->
                </div>
            </div>
        </div>
    </div>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- view nav of itens of bulletins -->
                    <x-users.private_nav_of_view_itens :routeToCreate="route('users.create')"></x-bulletins.private_nav_of_view_itens>
                    <!-- fim do view nav of itens of bulletins -->
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- view itens of bulletins -->
                    <x-users.private_view_itens :users="$users"></x-users.private_view_itens>
                    <!-- fim do view itens of bulletins -->
                </div>
            </div>
        </div>
    </div>    
</x-app-layout>
<!-- paginação do search -->
<x-users.public_pagination :users="$users"> </x-users.public_pagination>
<!-- fim paginação do search -->

