<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProcess extends Model
{
    use HasFactory;
    protected $table='order_processes';

    protected $fillable=[
        'order_id',
        'process_id',
        'employee_id',
        'start_time',
        'end_time'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class,'process_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }


    protected $dates = [
        'start_time',
        'end_time',
       
    ];
}
