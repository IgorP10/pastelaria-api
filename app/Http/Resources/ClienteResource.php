<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'data_nascimento' => $this->data_nascimento->format('Y-m-d'),
            'endereco' => $this->endereco,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cep' => $this->cep,
            'pedidos' => $this->whenLoaded('pedidos', function () {
                return $this->pedidos->map(function ($pedido) {
                    return [
                        'id' => $pedido->id,
                        'produtos' => $pedido->produtos,
                        'total' => $pedido->total,
                        'created_at' => $pedido->created_at,
                        'updated_at' => $pedido->updated_at,
                    ];
                });
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
