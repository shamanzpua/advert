<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdvertImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('advertisement_id')->unsigned();
            $table->boolean('is_primary');
            $table->timestamps();
            $table->foreign('advertisement_id')
                ->references('id')
                ->on('advertisements')
                ->delete('cascade')
                ->update('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisement_images');
    }
}
