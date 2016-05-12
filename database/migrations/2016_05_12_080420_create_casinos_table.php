<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casinos', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->index()->unique();
            $table->string("position_lat")->nullable()->index();
            $table->string("position_lng")->nullable()->index();
            $table->string("address")->index();
            $table->text("hours")->nullable();
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
        Schema::drop('casinos');
    }
}
