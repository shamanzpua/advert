<?php

use Illuminate\Database\Seeder;
use App\Models\Advertisements\Advertisement;

/**
 * Class AdvertisementSeeder
 */
class AdvertisementSeeder extends Seeder
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
                'title' => 'Конструктор LEGO',
                'category_id' => 7,
                'description' => 'Куплю конструктор LEGO в хорошем состоянии с инструкией по сборке',
            ],
            [
                'id' => 2,
                'title' => 'Мягкая игрушка медведь',
                'description' => 'Куплю медведя черного или серого. Вес 1 кг, длина 1 метр',
                'category_id' => 7
            ],
            [
                'id' => 3,
                'title' => 'Радиоуправляеммый вертолет',
                'description' => 'Куплю вертолет на радиоуправлении. Батарея должна держать не меньше 10 минут!',
                'category_id' => 7
            ],
            [
                'id' => 4,
                'title' => 'Книга "Колобок"',
                'category_id' => 8,
                'description' => 'Куплю книгу "Колобок"',
            ],
            [
                'id' => 5,
                'title' => 'Книга "3 поросёнка"',
                'category_id' => 8,
                'description' => null,
            ],
        ];

        Advertisement::insert($data);
    }
}
