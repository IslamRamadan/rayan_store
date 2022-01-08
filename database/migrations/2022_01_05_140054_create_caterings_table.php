<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCateringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caterings', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('image')->nullable();
            $table->string('hint_ar')->nullable();
            $table->string('hint_en')->nullable();
            $table->string('requirement_ar')->nullable();
            $table->string('requirement_en')->nullable();
            $table->text('desc_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->integer('persons_no')->nullable();
            $table->integer('persons_max')->nullable();
            $table->integer('price')->nullable();
            $table->integer('ad_person_price')->nullable();
            $table->string('setup_time')->nullable();
            $table->string('max_time')->nullable();
            $table->integer('ad_hour_price')->nullable();
            $table->integer('ad_service_price')->nullable();
            $table->string('ad_service_ar')->nullable();
            $table->string('ad_service_en')->nullable();
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
        Schema::dropIfExists('caterings');
    }
}
