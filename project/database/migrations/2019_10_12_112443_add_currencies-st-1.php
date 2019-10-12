<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Advertisements\Category;
use App\Models\Advertisements\Advertisement;

class AddCurrenciesSt1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Artisan::call('db:seed', [
            '--class' => CurrencySeeder::class,
            '--force' => true,
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
