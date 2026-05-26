<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSku extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock',
        'is_active',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'sku_attribute_values');
    }
}
