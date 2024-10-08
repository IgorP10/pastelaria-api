<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'produtos' => 'required|array',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'O campo cliente é obrigatório',
            'cliente_id.exists' => 'O cliente informado não existe',
            'produtos.required' => 'O campo produtos é obrigatório',
            'produtos.array' => 'O campo produtos deve ser um array',
            'produtos.*.id.required' => 'O campo id do produto é obrigatório',
            'produtos.*.id.exists' => 'O produto informado não existe',
            'produtos.*.quantidade.required' => 'O campo quantidade do produto é obrigatório',
            'produtos.*.quantidade.integer' => 'O campo quantidade do produto deve ser um número inteiro',
            'produtos.*.quantidade.min' => 'O campo quantidade do produto deve ser no mínimo 1',
        ];
    }
}
