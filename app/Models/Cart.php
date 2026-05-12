<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Total do carrinho
    public function total(): float
    {
        return $this->items()->get()->sum(fn($item) => $item->price * $item->units);
    }

    // Quantidade total de itens
    public function totalUnits(): int
    {
        return $this->items->sum('units');
    }
}