<?php

use Illuminate\Database\Seeder;
use App\Models\Advertisements\Category;

class RootCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rootCategories = json_decode(
            file_get_contents(database_path('data/rootCategories.json')),
            true
        );

//        dd($rootCategories);
//        Category::insert($rootCategories['items']);

        foreach ($rootCategories['items'] as $item) {
//            dd($item);
            Category::create($item);
        }
    }
}
