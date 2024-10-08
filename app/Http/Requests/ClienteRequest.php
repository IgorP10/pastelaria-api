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

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.string' => 'O campo nome deve ser uma string',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O campo email deve ser um email válido',
            'email.unique' => 'O email informado já está em uso',
            'telefone.required' => 'O campo telefone é obrigatório',
            'telefone.string' => 'O campo telefone deve ser uma string',
            'telefone.max' => 'O campo telefone deve ter no máximo 15 caracteres',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório',
            'data_nascimento.date' => 'O campo data de nascimento deve ser uma data válida',
            'endereco.required' => 'O campo endereço é obrigatório',
            'endereco.string' => 'O campo endereço deve ser uma string',
            'endereco.max' => 'O campo endereço deve ter no máximo 255 caracteres',
            'complemento.string' => 'O campo complemento deve ser uma string',
            'complemento.max' => 'O campo complemento deve ter no máximo 255 caracteres',
            'bairro.required' => 'O campo bairro é obrigatório',
            'bairro.string' => 'O campo bairro deve ser uma string',
            'bairro.max' => 'O campo bairro deve ter no máximo 255 caracteres',
            'cep.required' => 'O campo cep é obrigatório',
            'cep.string' => 'O campo cep deve ser uma string',
            'cep.max' => 'O campo cep deve ter no máximo 9 caracteres',
        ];
    }
}
