<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hall_orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('street')->nullable();
            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->string('address')->nullable();
            $table->text('note')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('day_price')->nullable();
            $table->integer('days')->nullable();
            $table->integer('total_price')->nullable();
            $table->longText('invoice_id')->nullable();
            $table->longText('invoice_link')->nullable();
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('hall_id')->nullable();
            $table->foreign('city_id')->references('id')->on('city')->cascadeOnDelete();
            $table->foreign('country_id')->references('id')->on('country')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('hall_id')->references('id')->on('halls')->cascadeOnDelete();
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
        Schema::dropIfExists('hall_orders');
    }
}
