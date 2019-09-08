<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

/**
 * Class LocationsController
 * @package App\Http\Controllers
 */
class LocationsController extends Controller
{
    public function index(Request $request)
    {
        $parentLocationId = $request->get('parentLocationId');

        $criteria =  $parentLocationId ?
            [['parent_id', '=', $parentLocationId]] :
            [['type_id', '=', Location::REGION_TYPE]];


        return [
            'data' => Location::where($criteria)->get(),
        ];
    }
}
