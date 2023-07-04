<!-- Formulário com vários selecionados -->
<form action="{{ route('bulletins.selecteds')}}" method="post">
    @csrf
    @method('DELETE')

    <table class="table table-striped">
        <thead>
            <tr>
                <th class="align-middle text-center" width="5%" scope="col"><button type="submit" class="btn btn-outline-danger"><i class="bi bi-check2-square"></i> Apagar</button></th>
                <th class="align-middle text-center" width="5%" scope="col">Id</th>
                <th class="align-middle text-center" width="10%" scope="col">Boletim</th>
                <th class="align-middle text-center" width="15%" scope="col">Data/Hora Upload</th>
                <th class="align-middle text-center" width="15%" scope="col">Data/Hora Publicação</th>
                <th class="align-middle text-center" width="5%" scope="col">Editar</th>
            </tr>
        </thead>
        <tbody>
            @isset($bulletins)
                @foreach ($bulletins as $bulletin)
                    <!-- linhas -->
                    <tr>
                        <th class="align-middle text-center" scope="row">
                            <!-- caixas de seleção -->
                            <input class="form-check-input mt-0" name="bulletins_selecteds[]" type="checkbox"
                                value="{{ $bulletin->id }}" aria-label="Checkbox for following text input">
                        </th>
                        <th class="align-middle text-center" scope="row">{{ $bulletin->id }}</th>
                        <td class="align-middle text-center">
                            <a href="{{ asset('storage/' . $bulletin->path_of_file) }}" target="_blank">
                                {{ $bulletin->name_of_file }}
                            </a>
                        </td>
                        <td class="align-middle text-center">{{ \Carbon\Carbon::parse($bulletin->created_at)->format('d/m/Y - H:i:s')}}</td>
                        <td class="align-middle text-center">{{ \Carbon\Carbon::parse($bulletin->date_of_publish)->format('d/m/Y - H:i:s')}}</td>
                        <td class="align-middle text-center">
                            <a href="{{ route('bulletins.edit', $bulletin->id) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-pen"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endisset
        </tbody>
    </table>
</form>
<!-- fim do Formulário com vários selecionados -->