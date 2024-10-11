<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id ?? null,
            'nome' => $this->nome ?? null,
            'email' => $this->email ?? null,
            'telefone' => $this->telefone ?? null,
            'endereco' => $this->endereco ?? null,
            'complemento' => $this->complemento ?? null,
            'bairro' => $this->bairro ?? null,
            'cep' => $this->cep ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
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
        ];
    }
}
