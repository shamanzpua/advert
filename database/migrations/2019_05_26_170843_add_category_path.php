<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Advertisements\Category;
use App\Models\Advertisements\Advertisement;

/**
 * Class AddCategoryPath
 */
class AddCategoryPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('categories', 'category_path')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('category_path');
                $table->index('category_path');
            });
            $this->updateEntities(Category::class);
        }

        if (! Schema::hasColumn('advertisements', 'category_path')) {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->string('category_path');
                $table->index('category_path');
            });
            $this->updateEntities(Advertisement::class);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('categories', 'category_path')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('category_path');
            });
        }

        if (Schema::hasColumn('advertisements', 'category_path')) {
            Schema::table('advertisements', function (Blueprint $table) {
                $table->dropColumn('category_path');
            });
        }
    }

    /**
     * @param $entityModelClass
     */
    private function updateEntities($entityModelClass)
    {
        $entities = $entityModelClass::all();

        foreach ($entities as $entity) {
            $entity->save();
        }
    }
}
