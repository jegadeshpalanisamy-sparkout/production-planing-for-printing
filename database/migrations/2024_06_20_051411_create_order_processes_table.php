<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            
            $table->unsignedBigInteger('process_id');
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('cascade');
            
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('emp_id')->on('users')->onDelete('set null');
            
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_processes');
    }
};
