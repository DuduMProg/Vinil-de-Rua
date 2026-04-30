<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $fillable = ['product_id', 'path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
