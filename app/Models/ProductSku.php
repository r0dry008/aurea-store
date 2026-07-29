<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

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

    //scopes para filtrar SKUs activos
    public function scopeActiveSku(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
