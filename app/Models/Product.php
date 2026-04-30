<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = ['name','description','price', 'category_id'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function Category(){
        return $this->belongsTo(Category::class);
    }
}
