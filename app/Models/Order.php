<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'tipo_documento',
        'numero_documento',
        'celular',
        'organizacion',
        'ticket_type',
        'quantity',
        'donation',
        'unit_price',
        'subtotal',
        'total',
        'status',
        'payment_method',
        'payment_reference',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'donation' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
