<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewTableTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_reference');
            $table->double('amount');
            $table->enum('status', ['pending', 'canceled', 'success']);
            $table->enum('type', ['c2b', 'b2b']);
            $table->timestamps();
           
            $table->unsignedBigInteger('sender_id'); 
            $table->unsignedBigInteger('receiver_id'); 
    
            $table->foreign('sender_id')->references('id')->on('usuarios');
            $table->foreign('receiver_id')->references('id')->on('usuarios');
       

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
