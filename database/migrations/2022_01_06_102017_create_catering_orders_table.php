<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCateringOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catering_orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('street')->nullable();
            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->string('address')->nullable();
            $table->text('note')->nullable();
            $table->boolean('request_female')->default(0);
            $table->integer('persons_no')->default(0);
            $table->integer('price')->default(0);
            $table->integer('ad_hours')->default(0);
            $table->integer('ad_hours_price')->default(0);
            $table->integer('ad_service')->default(0);
            $table->integer('ad_service_price')->default(0);
            $table->integer('total_price')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('catering_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('catering_id')->references('id')->on('caterings')->cascadeOnDelete();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->foreign('city_id')->references('id')->on('cities')->cascadeOnDelete();
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
        Schema::dropIfExists('catering_orders');
    }
}
