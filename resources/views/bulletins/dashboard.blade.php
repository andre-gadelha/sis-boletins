<x-app-layout>
    <x-slot name="header">
        {{ Breadcrumbs::render('dashboard') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">                    
                    @can('is_active')
                        <div class="row">                        
                            @can('is_admin')
                                <div class="col-sm-3">
                                    <x-cards icon="bi bi-people-fill" title="Gestão de Usuários"
                                        description="Adicione, atualize ou remova usuários." :route="route('users.index')"></x-cards>
                                </div>                            
                            @endcan

                            <div class="col-sm-3">
                                <!-- cartões contendo os serviços de gestão de usuários e boletins-->
                                <x-cards icon="bi bi-file-richtext-fill" title="Gestão de Boletins"
                                description="Adicione, atualize ou remova boletins." :route="route('bulletins.index')"></x-cards>
                                <!-- cartões contendo os serviços de gestão de usuários e boletins-->
                            </div>                                                        
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Entre em contato com o setor de informática de sua OM para ativar seu usuário.
                        </div>
                    @endcan                                       
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
