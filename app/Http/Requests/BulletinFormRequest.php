<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulletinFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "words_to_filter" => 'max:255|required',
            //"filter_type_view" => 'required',
            "filter_date_start" => 'required|before:filter_date_end',
            "filter_date_end" => 'required|after:filter_date_start'
        ];
    }

    public function messages()
    {

        return [

            'words_to_filter.max' => 'Você excedeu a quantidade máxima de caracteres permitidos 255.',
            'words_to_filter.required' => 'O campo <<Termo para Pesquisa>> é de preenchimento obrigatório.',
            //'filter_type_view.required' => "O campo 'tipo de visualização' é obrigatório .",
            'filter_date_start.required' => "O campo 'Periodo: Data inicio' é obrigatório .",
            'filter_date_start.before' => "O campo 'Periodo: Data inicio' deve conter datas anteriores ao 'Periodo: Data Fim'.",
            'filter_date_end.required' => "O campo 'Periodo: Data Fim' é obrigatório .",
            'filter_date_end.before' => "O campo 'Periodo: Data Fim' deve conter datas poteriores a 'Periodo: Data Inicio'.",
        ];

    }
}
