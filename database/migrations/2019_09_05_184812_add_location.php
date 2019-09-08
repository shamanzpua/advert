<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Services\LocationParser\Parser;

class AddLocation extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->smallInteger('type_id');
            $table->string('name');
            $table->string('code');
            $table->timestamps();
            $table->foreign('parent_id')
                ->references('id')
                ->on('locations')
                ->delete('set null')
                ->update('set null');
        });

        app()->make(Parser::class)->run();
    }







    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
