<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string',
            'preco' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.string' => 'O campo nome deve ser uma string',
            'preco.required' => 'O campo preço é obrigatório',
            'preco.numeric' => 'O campo preço deve ser um número',
            'foto.required' => 'O campo foto é obrigatório',
            'foto.image' => 'O campo foto deve ser uma imagem',
            'foto.mimes' => 'O campo foto deve ser uma imagem do tipo: jpeg, png, jpg, gif ou svg',
            'foto.max' => 'O campo foto deve ter no máximo 2048 bytes',
        ];
    }
}
