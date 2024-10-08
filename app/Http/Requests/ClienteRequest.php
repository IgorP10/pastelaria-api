<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'required|string|max:15',
            'data_nascimento' => 'required|date',
            'endereco' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cep' => 'required|string|max:9',
        ];
    }
}
