<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable =[
        'order_id',
        'product_id',
        'sku_id',
        'product_name',
        'sku_code',
        'variant_attributes',
        'unit_price',
        'quantity',
        'subtotal',
    ];
    //relaciones
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function sku(){
        return $this->belongsTo(ProductSku::class);
    }
}
