<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'subtotal',
        'shipping_fee',
        'descount_amount',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'paid_at',
        'shipped_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function  orderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public static function booted(): void {
        static::creating(function ($order){
            if(empty($order->order_number)){
                $nextId = (Order::max('id')?? 0) + 1;
                $order->order_number = 'ORD-'. date('Y'). '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
            }
        });
    }

}
