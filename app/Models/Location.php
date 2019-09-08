<?php
namespace App\Models;

use App\Services\TreePathGenerator\CategoryPathGenerator;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Categories;

/**
 * Class Location
 * @package App\Models\Advertisements
 */
class Location extends Model
{
    public $timestamps = true;

    const REGION_TYPE = 1;
    const CITY_TYPE = 2;
    const AREA_TYPE = 3;
    const VILLAGE_TYPE = 4;
}
