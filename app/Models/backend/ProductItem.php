<?php

namespace App\Models\backend;
use Illuminate\Database\Eloquent\Model;
use App\Models\backend\Product;

class ProductItem extends Model
{
    protected $table = 'product_items';

    protected $fillable = [
        'product_id',
        'price_buy',
        'price_promotion',
        'material',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'status'
    ];

    public function Product() {
        return $this->belongsTo(Product::class);
    }
}
