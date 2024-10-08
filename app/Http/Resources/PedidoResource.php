<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'cliente_id' => $this->cliente_id,
            'produtos' => $this->produtos,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'cliente' => new ClienteResource($this->whenLoaded('cliente')),
        ];
    }
}
