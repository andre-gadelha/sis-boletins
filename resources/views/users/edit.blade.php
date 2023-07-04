<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    {{ Breadcrumbs::render('users.edit',$user) }}
                </div>
                <div class="col-md-2">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-success" >
                        <i class="bi bi-backspace-fill ml-2 ml-2"></i> Voltar
                    </a>
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
                    <!--formulário para edição do usuário -->
                    <x-users.private_form_create_or_update :action="route('users.update', $user->id)" :update="true" :user="$user"> </x-users.private_form_create_or_update>
                    <!-- fim formulário para edição do usuário -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
