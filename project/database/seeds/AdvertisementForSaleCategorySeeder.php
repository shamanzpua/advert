<?php

use Illuminate\Database\Seeder;
use App\Models\Advertisements\Advertisement;
use App\Models\Advertisements\AdvertisementImage;
use App\Models\Advertisements\Category;
use Illuminate\Database\DatabaseManager;
/**
 * Class AdvertisementSeeder
 */
class AdvertisementForSaleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $cities = [
        1140,
        2122,
        2682,
        1847,
        332,
    ];
    public function run()
    {
        $advertsJson = file_get_contents(database_path('data/advert.json'));

        /**
         * @var DatabaseManager $db
         */
        $db = app()->make(DatabaseManager::class);

        $adverts = json_decode(
            $advertsJson,
            true
        );


        foreach ($adverts as $categoryName =>  $adverts) {

            $category = Category::where('title', $categoryName)->where('category_path', 'LIKE', '{1}%')->first();
            if (!$category) dd($categoryName);
            foreach ($adverts as $advert) {
                $db->transaction(function () use ($advert, $category) {
                    $adv = new Advertisement();
                    $adv->title = $advert['title'];
                    $adv->price = $advert['price'];
                    $adv->currency_id = $advert['unit'] == 'грн' ? 1 : 2;
                    $adv->category_id = $category->id;
                    $adv->created_at = \Carbon\Carbon::now();
                    $adv->updated_at = \Carbon\Carbon::now();
                    $adv->city_id = $this->cities[array_rand($this->cities)];
                    $adv->save();
                    $image = new AdvertisementImage();
                    $image->image = $advert['img'];
                    $image->advertisement_id = $adv->id;
                    $image->is_primary = 1;
                    $image->created_at = \Carbon\Carbon::now();
                    $image->updated_at = \Carbon\Carbon::now();
                    $image->save();
                });
            }
//            dd($category);
        }
    }
}
