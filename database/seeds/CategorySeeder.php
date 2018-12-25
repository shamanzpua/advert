<?php

use Illuminate\Database\Seeder;
use App\Models\Advertisements\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'title' => 'Куплю',
                'parent_id' => null
            ],
            [
                'id' => 2,
                'title' => 'Продам',
                'parent_id' => null
            ],
            [
                'id' => 3,
                'title' => 'Обменяю',
                'parent_id' => null
            ],
            [
                'id' => 4,
                'title' => 'Отдам',
                'parent_id' => null
            ],

            //-------------------------------------------
            [
                'id' => 5,
                'title' => 'Товары для дома',
                'parent_id' => 1
            ],
            [
                'id' => 6,
                'title' => 'Детские товары',
                'parent_id' => 1

            ],
            [
                'id' => 7,
                'title' => 'Игрушки',
                'parent_id' => 6
            ],
            [
                'id' => 8,
                'title' => 'Детские книги',
                'parent_id' => 6
            ],
        ];

        Category::insert($data);
    }
}
