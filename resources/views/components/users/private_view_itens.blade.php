<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center" width="5%" scope="col">Id</th>
            <th class="text-center" width="15%" scope="col">Criado</th>
            <th class="text-center" width="15%" scope="col">Nome</th>
            <th class="text-center" width="15%" scope="col">Email</th>            
            <th class="text-center" width="5%" scope="col">Perfil</th>            
            <th class="text-center" width="15%" scope="col">Status</th>            
            <th class="text-center" width="5%" scope="col">Editar</th>            
            <th class="text-center" width="5%" scope="col">Excluir</th>            
        </tr>
    </thead>
    <tbody>
        @isset($users)
            <!-- linhas -->
            @foreach ($users as $user)
                <!-- linhas -->
                <tr>
                    <th class="text-center" scope="row">{{ $user->id }}</th>
                    <td class="text-center">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y - H:i:s')}}</td>
                    <td class="text-center">{{ $user->name }}</td>
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">{{ $user->profile }}</td>
                    <td class="text-center">
                        <form action="{{ route('user.activate', $user) }}" method="post">
                            @csrf
                            @method('post')
                            <button type="submit"
                                @if ($user->status == 'inactived')
                                    class="btn btn-outline-success w-75"                                
                                @else
                                    class="btn btn-outline-danger w-75"                               
                                @endif
                            >
                            <i class="bi bi-trash"></i>
                            @if ($user->status == 'inactived')
                                Ativar                                
                            @else
                                Desativar                               
                            @endif
                        </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-secondary" >
                            <i class="bi bi-pen"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endisset
    </tbody>
</table>
