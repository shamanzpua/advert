<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAdvertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->bigInteger('price')->nullable();
                $table->integer('currency_id')->unsigned()->nullable();
                $table->integer('user_id')->unsigned()->nullable();
                $table->smallInteger('status')->unsigned()->nullable();
                $table->integer('city_id')->unsigned()->nullable();

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->delete('set null')
                    ->update('set null');
                $table->foreign('city_id')
                    ->references('id')
                    ->on('cities')
                    ->delete('set null')
                    ->update('set null');
                $table->foreign('currency_id')
                    ->references('id')
                    ->on('currencies')
                    ->delete('set null')
                    ->update('set null');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->dropForeign('advertisements_currency_id_foreign');
                $table->dropForeign('advertisements_city_id_foreign');
                $table->dropForeign('advertisements_user_id_foreign');
                $table->dropColumn('user_id');
                $table->dropColumn('currency_id');
                $table->dropColumn('city_id');
                $table->dropColumn('status');
                $table->dropColumn('price');
            });
    }
}
