<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Advertisements\Advertisement;
use App\Http\Resources\Advertisements;

/**
 * Class AdvertisementsController
 * @package App\Http\Controllers
 */
class AdvertisementsController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->get('categoryId');

        if ($categoryId) {
            $advertisements = Advertisement::whereHas('category', function ($query) use ($categoryId) {
                $query->where('categories.category_path', 'like', "%{".((int) $categoryId) . "}%");
            })->get();
        } else {
            $advertisements = Advertisement::all();
        }

            return new Advertisements($advertisements);
    }
}
