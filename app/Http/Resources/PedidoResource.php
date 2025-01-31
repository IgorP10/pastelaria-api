<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'cliente' => $this->whenLoaded('cliente', function () {
                return [
                    'id' => $this->cliente->id,
                    'nome' => $this->cliente->nome,
                    'email' => $this->cliente->email,
                    'telefone' => $this->cliente->telefone,
                    'endereco' => $this->cliente->endereco,
                    'complemento' => $this->cliente->complemento,
                    'bairro' => $this->cliente->bairro,
                    'cep' => $this->cliente->cep,
                ];
            }),
            'produtos' => $this->produtos,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
