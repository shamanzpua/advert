<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Advertisements\Category;
use App\Models\Advertisements\Advertisement;

class ModifyAdvertsSt1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('title', 255)->nullable()->change();
            $table->dropIndex('advertisements_category_path_index');
            $table->dropColumn('category_path');
            $table->float('price', 14, 2)->nullable()->change();

            $table->dropForeign('advertisements_city_id_foreign');
            $table->foreign('city_id')
                ->references('id')
                ->on('locations')
                ->delete('set null')
                ->update('set null');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Advertisement::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Artisan::call('db:seed', [
            '--class' => AdvertisementForSaleCategorySeeder::class,
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
