<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_type_id',
        'products_name',
        'description',
        'price',
        'stock',
        'img_url',
        'img_name',
    ];
}
