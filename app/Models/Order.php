<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=[
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'ordered_date',
        'estimate_delivery_date',
        'process_steps'
    ];

    protected $casts = [
        'process_steps' => 'array', // Cast process_steps to array
    ];
    public function processes()
    {
        return $this->hasMany(OrderProcess::class);
    }

    public static function boot()
    {
        
        parent::boot();

        static::creating(function($order){
            $order->order_number=static::generateOrderNumber();
        });
    }

    public static function generateOrderNumber()
    {
        return 'ORDNO'.date('ymd').mt_rand(1000,9999);
    }
}
