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
            'foto' => 'required|image',
        ];
    }
}
