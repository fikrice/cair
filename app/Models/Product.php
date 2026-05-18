<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'sku', 'name', 'description', 
        'unit', 'purchase_price', 'selling_price', 
        'stock', 'min_stock', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
