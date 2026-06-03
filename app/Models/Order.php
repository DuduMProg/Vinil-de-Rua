<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'payment_method',
        'total',
        'tracking_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Labels para exibição
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'Pendente',
            'approved'  => 'Aprovado',
            'cancelled' => 'Cancelado',
            'delivered' => 'Entregue',
            default     => $this->status,
        };
    }

    public function getPaymentLabelAttribute(): string
    {
        return match($this->payment_method) {
            'pix'         => 'PIX',
            'credit_card' => 'Cartão de Crédito',
            default       => '—',
        };
    }
}