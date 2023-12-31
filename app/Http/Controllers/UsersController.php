<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersFormRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class UsersController
{
    public function __construct(private UserRepository $_repository)
    {
    }

     /**
     * Mostra o index com os boletins autênticado.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $_users = User::paginate(10);

        $mensagemSucesso = session('mensagem.sucesso');
        return view('users.index')
            ->with('users', $_users)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    /**
     * Processa a requisição do index_public e devolve para o index publico
     *
     * @param  \App\Http\Requests\BulletinFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function private_results_of_search(Request $request){

        $users = null;
        $users = $this->_repository->simple_search($request);        

        //o erro, ao invés de mandar pra view direto, mandei pra rota, onde sobrescrevia a variável sempre
        //apresentando o erro de buscar sempre todos os boletins
        return view('users.index')
            ->with('users', $users)
            ->with('request', $request)
            ->with('mensagemSucesso', "Pesquisa de usuários com os seguintes termos '{$request->words_to_filter}' executada com sucesso");
    }

    public function edit(User $user)
    {
        $mensagemSucesso = session('mensagem.sucesso');
        return view('users.edit')->with('user', $user)->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        $mensagemSucesso = session('mensagem.sucesso');
        return view('users.create')
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function store(UsersFormRequest $request)
    {
        $data = $request->except(['_token']);
        $data['password'] = Hash::make($data['password']);
        $data['status'] = $request['status'];
        $data['profile'] = $request['profile'];

        //verificar porque o hash não está funcionando

        $user = User::create($data);
        //para logar de imediato
        //Auth::login($user);

        return to_route('users.index');
    }

    public function update(User $user, UsersFormRequest $request)
    {
        if (!Gate::allows('is_admin')) {
            return to_route('users.index')
            ->withErrors("O seu usuário não tem permissão para editar..");
        }
        else{
            //converto o password para hash
            $_data['password'] = Hash::make($request['password']);
            $_data['status'] = $request['status'];
            $_data['profile'] = $request['profile'];
            $user->fill($_data);
            $user->save();
            return to_route('users.index')
                ->with('mensagem.sucesso', "Usuário '{$user->name}' atualizado com sucesso");
        }        
    }

    /**
     * Remove um usuário especifico
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return to_route('users.index')
            ->with('mensagem.sucesso', "Boletim '{$user->name}' removida com sucesso");
    }

    /**
     * Remove um usuário especifico
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function activate(User $user)
    {
        //dd($user);
        if ($user->status == 'actived') {
            $user->status = 'inactived';
        } else {
            $user->status = 'actived';
        }
        $user->save();
        return to_route('users.index')
            ->with('mensagem.sucesso', "Status do usuário '{$user->name}' atualizado com sucesso");                
    }
}
