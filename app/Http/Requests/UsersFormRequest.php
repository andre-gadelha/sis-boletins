<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsersFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'max:255|required',
            'email' => 'max:255|email:rfc|required',
            //'password' => 'max:255|nullable',
            'status' => Rule::in(['actived', 'inactived']),
            'profile' => Rule::in(['user','administrator', 'adminBoletins', 'adminUsuarios']),
        ];
    }
    public function messages()
    {
        return [
            'name.max' => 'Você excedeu a quantidade máxima de caracteres permitidos 255 no campo Nome.',
            'name.required' => 'O campo Nome é obrigatório .',            
            'email.max' => 'Você excedeu a quantidade máxima de caracteres permitidos 255 no campo Email.',
            'email.required' => 'O campo Email é obrigatório .',
            'email.email' => 'Insira um Email válido por favor!',
            //'password.max' => 'Você excedeu a quantidade máxima de caracteres permitidos 255 no campo Senha.',
            //'password.required' => 'O campo onde se insere a Senha é obrigatório .',
        ];
    }
}