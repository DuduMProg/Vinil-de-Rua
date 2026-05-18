<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    public $fillable = [
        'name', 'artist', 'description', 'price',
        'stock', 'category_id', 'tag_id', 'slug',
        'spotify_track_id', 'status',
    ];

    // ── Accessors ──────────────────────────────

    // Chame com $product->preco_com_desconto
    public function getPrecoComDescontoAttribute(): float
    {
        if ($this->tag && $this->tag->name === 'oferta') {
            return $this->price * 0.85;
        }
        return $this->price;
    }

    // Chame com $product->tem_desconto
    public function getTemDescontoAttribute(): bool
    {
        return $this->tag && $this->tag->name === 'oferta';
    }

    // ── Relacionamentos ────────────────────────

    protected static function booted(): void
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $base  = Str::slug($product->name . '-' . $product->artist);
                $slug  = $base;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $count++;
                }
                $product->slug = $slug;
            }
        });
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function coverImage()
    {
        return $this->hasOne(Image::class)->where('is_cover', true);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}