<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'produtos',
    ];

    protected $casts = [
        'produtos' => 'array',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
