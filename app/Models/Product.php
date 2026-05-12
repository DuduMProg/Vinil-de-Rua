<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    public $fillable = [
        'name',
        'artist',
        'description',
        'price',
        'stock',
        'category_id',
        'tag_id',
        'slug',
        'spotify_track_id',
        'status',
    ];

    // Gera slug automaticamente ao setar o nome
    protected static function booted(): void
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name . '-' . $product->artist);
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

    public function Tags(){
        return $this->belongsToMany(Tag::class);
    }
}