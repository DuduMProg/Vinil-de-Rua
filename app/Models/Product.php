<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = ['name','description', 'image1', 'image2', 'image3', 'price'];
}
