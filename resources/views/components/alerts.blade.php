@isset($mensagemSucesso)
    <div class="alert alert-success d-flex justify-content-center">
        <i class="bi bi-check-circle-fill ml-2"></i>
        {{ $mensagemSucesso }}
    </div>
@endisset

@if ($errors->any())
    <div class="alert alert-danger d-flex justify-content-center">
        <i class="bi bi-exclamation-circle-fill"></i>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
