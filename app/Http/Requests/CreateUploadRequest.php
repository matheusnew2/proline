<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class CreateUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'mimes:json'
            ]
        ];
    }
    public function messages()
    {
        return [
            'file' => [
                'required' => 'Arquivo json obrigatório',
                'mimes' => 'O arquivo deve ser um .json'
            ]
        ];
    }
}
