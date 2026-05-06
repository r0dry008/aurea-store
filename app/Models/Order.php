<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'name_client',
        'phone_client',
        'email',
        'message',
        'via',
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
}
