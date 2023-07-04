<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    {{ Breadcrumbs::render('bulletins.edit',$bulletin) }}
                </div>
                <div class="col-md-2">
                </div>
            </div>
        </div>
    </x-slot>

    <!-- mensagens de erros ou success -->
    <x-alerts :mensagemSucesso="$mensagemSucesso" :errors="$errors" ></x-alerts>
    <!-- mensagens de erros ou success -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!--adicionar no controller -->
                    <!--filtros de search -->
                    <x-bulletins.private_form_create_or_update :action="route('bulletins.update', $bulletin->id)" :update="true" :bulletin="$bulletin"> </x-bulletins.private_form_create_or_update>
                    <!-- fim filtros de search -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
