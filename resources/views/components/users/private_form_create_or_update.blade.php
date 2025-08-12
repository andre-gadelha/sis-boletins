<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($update)
        @method('PUT')

        <div class="form-row">
            <div class="col">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control"
                @isset($user->name)value="{{ $user->name }}"@endisset>
            </div>

            <div class="col">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control"
                @isset($user->email)value="{{ $user->email }}"@endisset>
            </div>
            
            <div class="col">
                <label for="profile" class="form-label">Perfil</label>
                <select class="form-control" name="profile" id="profile">
                    <option 
                    @if ($user->profile=='administrator')
                        selected                        
                    @endif
                    value="administrator">administrator</option>
                    
                    <option
                    @if ($user->profile=='user')
                        selected                        
                    @endif
                    value="user">Usuário</option>
                  </select>
            </div>
            
            <div class="col">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" name="status" id="status">
                    <option 
                    @if ($user->status=='actived')
                        selected                        
                    @endif
                    value="{{ $user->status }}">Ativo</option>
                    
                    <option
                    @if ($user->status=='actived')
                        selected                        
                    @endif
                    value="{{ $user->status }}">Inativo</option>
                  </select>
            </div>
            <!--
            <div class="col">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control"
                value="">
            </div>
            -->
        </div>
    @else
        <div class="form-row">
            <div class="col">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control" autofocus>
            </div>

            <div class="col">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="col">
                <label for="profile" class="form-label">Perfil</label>
                <select class="form-control" name="profile" id="profile">
                    <option value="administrator" selected>Administrador</option>                    
                    <option value="user">Usuário</option>
                  </select>
            </div>

            <div class="col">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="actived" selected>Ativo</option>                    
                    <option value="inactived">Inativo</option>
                  </select>
            </div>
            <!--
            <div class="col">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            -->
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
                    <i class="bi bi-send-plus"></i> Atualizar Usuário
                @else
                    <i class="bi bi-send-plus"></i> Enviar Dados
                @endif
            </button>
        </div>
    </div>
</form>
