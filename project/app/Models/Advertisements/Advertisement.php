<?php
namespace App\Models\Advertisements;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Advertisement
 * @package app\models\advertisements
 */
class Advertisement extends Model
{
    protected $appends = [
        'imageUrl',
        'cityName',
        'categoryName',
        'unit'
    ];

    public function mainImage()
    {
        return $this
            ->hasOne(AdvertisementImage::class, 'id')
            ->where('is_primary', 1);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function city()
    {
        return $this->belongsTo(Location::class, 'city_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function getUnitAttribute()
    {
        $units = [
            Currency::UAH => 'грн',
            Currency::USD => 'у.е',
        ];
        return $units[$this->currency->id] ?? null;
    }

    public function getCityNameAttribute()
    {
        return $this->city->name;
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->title;
    }

    /**
     * @return
     */
    public function getImageUrlAttribute()
    {
        $image = $this->mainImage;
        if ($image) {
            return url("/api/images/advertisements/{$image->id}");
        }
    }
    /**
     * @return
     */
    public function getImageAttribute()
    {
        $image = $this->mainImage()->first();
        if ($image) {
            return $image->image;
        }
    }
}
