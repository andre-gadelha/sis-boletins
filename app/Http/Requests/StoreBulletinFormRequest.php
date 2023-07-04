<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBulletinFormRequest extends FormRequest
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
            "date_of_publish" => "required",
            "file_to_upload" => "required|file|mimes:pdf"
        ];
    }
    public function messages()
    {
        return [
            'date_of_publish.required' => "A 'Data de Publicação' é obrigatória.",
            'file_to_upload.required' => "Por favor, selecione um arquivo no campo Boletim.",
            'file_to_upload.file.mimes' => "No campo boletim deve ser inserido o Boletim.",
            'file_to_upload.mimes' => "O tipo de arquivo permitido é o PDF.",
        ];
    }
}
