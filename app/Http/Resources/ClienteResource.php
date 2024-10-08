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
            'pedidos' => !empty($this->pedidos) ? PedidoResource::collection($this->whenLoaded('pedidos')) : null,
        ];
    }
}
