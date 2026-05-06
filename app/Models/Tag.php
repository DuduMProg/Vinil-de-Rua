<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $fillable = ['name'];

    public function Products(){
        return $this->hasMany(Product::class);
    }
}
