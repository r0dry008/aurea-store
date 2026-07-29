<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'brand',
        'is_active',
        'category_id',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    // Scope para filtrar productos activos
    // public function scopeActive(Builder $query): void
    // {
    //     $query->where('is_active', true);
    // }
    public function scopeActiveProduct(Builder $query) :void {
        $query->where('is_active', true);
    }
    
    public function scopeHasActiveSkus(Builder $query): void{
        $query->whereHas('skus',fn($q)=>$q->activeSku());
    }

}