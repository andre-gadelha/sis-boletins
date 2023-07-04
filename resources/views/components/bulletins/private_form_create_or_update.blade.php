<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($update)
        @method('PUT')

        <div class="form-row">
            <div class="col">
                <!-- nome do arquivo -->
                <label for="name_of_file" class="form-label mt-2">Nome do Boletim</label>
                <input type="text" id="name_of_file" name="name_of_file" class="form-control"
                    @isset($bulletin->name_of_file)value="{{ $bulletin->name_of_file }}"@endisset>
                <!-- fim do nome do arquivo -->
            </div>

            <div class="col">
                <!-- Data de Publicação -->
                <label for="date_of_publish" class="form-label mt-2">Data de Publicação</label>
                <input type="date" id="date_of_publish" name="date_of_publish" class="form-control"
                    @isset($bulletin->date_of_publish)value="{{ $bulletin->date_of_publish }}"@endisset>
                <!-- fim da Data de Publicação -->
            </div>

            <div class="col">
                <!-- Data de Publicação -->
                <label for="created_at" class="form-label mt-2">Data de Criação</label>
                <input type="date" id="created_at" name="created_at" class="form-control"
                    @isset($bulletin->created_at)value="{{ $bulletin->created_at }}"@endisset disabled>
                <!-- fim da Data de Publicação -->
            </div>

            <div class="col">
                <!-- Endereço do Arquivo -->
                <label for="path_of_file" class="form-label mt-2">Endereço do Arquivo</label>
                <input type="text" id="path_of_file" name="path_of_file" class="form-control"
                    @isset($bulletin->path_of_file)value="{{ $bulletin->path_of_file }}"@endisset disabled>
                <!-- fim da Endereço do Arquivo -->
            </div>

            <div class="col">
                <!-- Endereço do Arquivo -->
                <label for="original_text" class="form-label mt-2">Texto Extraido</label>
                <textarea id="original_text" name="original_text" class="form-control text-left" disabled rows="6" col="66">
                    @isset($bulletin->original_text)
                    {{ $bulletin->original_text }}
                    @endisset
                </textarea>
                <!-- fim da Endereço do Arquivo -->
            </div>
        </div>
    @else
        <div class="form-row">
            <div class="col">
                <!-- Data de Publicação -->
                <label for="date_of_publish" class="form-label mt-2">Data de Publicação:</label>
                <input type="date" id="date_of_publish" name="date_of_publish" class="form-control"
                    @isset($date_of_publish)value="{{ $date_of_publish }}"@endisset>
                <!-- fim da Data de Publicação -->
            </div>

            <div class="col">
                <!-- Data de Publicação -->
                <x-bulletins.private_input_file></x-bulletins.private_input_file>
                <!-- Data de Publicação -->
            </div>
        </div>
    @endif

    <div class="form-row mt-2">
        <div class="col-7">
        </div>
        <div class="col">
        </div>
        <div class="col">
            <button type="submit"
                class="@if ($update)
                    form-control btn btn-outline-secondary
                @else
                    form-control btn btn-outline-primary @endif">

                @if ($update)
                    <i class="bi bi-send-plus"></i> Atualizar Arquivo
                @else
                    <i class="bi bi-send-plus"></i> Enviar Arquivo
                @endif
            </button>
        </div>
    </div>
</form>
