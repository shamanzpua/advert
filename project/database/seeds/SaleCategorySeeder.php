<?php

use Illuminate\Database\Seeder;
use App\Models\Advertisements\Category;

class SaleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryJson = file_get_contents(database_path('data/saleCategories.json'));
        $categoryJson = str_replace('"img"', '"image"', $categoryJson);


        $saleCategories = json_decode(
            $categoryJson,
            true
        );

//        dd($saleCategories);
        foreach ($saleCategories['items'] as $category) {
            $model = Category::create([
                'image' => $category['image'],
                'title' => $category['title'],
                'parent_id' => 1,
                'level' => $category['level']
            ]);
            if (isset($category['items'])) {
                foreach ($category['items'] as $nestedCategory) {
                    Category::create([
                        'image' => $nestedCategory['image'],
                        'title' => $nestedCategory['title'],
                        'parent_id' => $model->id,
                        'level' => $nestedCategory['level']
                    ]);
                }
            }
        }

        foreach (Category::get() as $model) {
            $model->save();
        }

        dd($saleCategories);
    }
}
