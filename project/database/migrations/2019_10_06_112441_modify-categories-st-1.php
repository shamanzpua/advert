<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Advertisements\Category;
use App\Models\Advertisements\Advertisement;

class ModifyCategoriesSt1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::table('categories', function (Blueprint $table) {
            $table->smallInteger('level')->unsigned()->nullable();
            $table->string('category_path')->nullable()->change();
            $table->string('image')->nullable()->change();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        Advertisement::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Artisan::call('db:seed', [
            '--class' => RootCategorySeeder::class,
            '--force' => true,
        ]);
        Artisan::call('db:seed', [
            '--class' => SaleCategorySeeder::class,
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
