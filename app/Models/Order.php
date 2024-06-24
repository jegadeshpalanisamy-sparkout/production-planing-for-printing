<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function billing()
    {
        return $this->hasOne(Billing::class,'order_id');
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

   // Scope for on-time orders
   public function scopeOnTime($query)
   {
       return $query->whereHas('processes', function ($query) {
           $query->whereNotNull('end_time');
       })->get()->filter(function ($order) {
           $allProcessesEnded = $order->processes->every(function ($process) {
               return $process->end_time !== null;
           });

           if (!$allProcessesEnded) {
               return false; // Skip orders where not all processes have end_time
           }

           $lastProcess = $order->processes->last();
           return $lastProcess->end_time < new Carbon($order->estimate_delivery_date);
       });
   }

   // Scope for late orders
   public function scopeLate($query)
   {
       return $query->whereHas('processes', function ($query) {
           $query->whereNotNull('end_time');
       })->get()->filter(function ($order) {
           $allProcessesEnded = $order->processes->every(function ($process) {
               return $process->end_time !== null;
           });

           if (!$allProcessesEnded) {
               return false; // Skip orders where not all processes have end_time
           }

           $lastProcess = $order->processes->last();
           return $lastProcess->end_time >= new Carbon($order->estimate_delivery_date);
       });
   }
}
