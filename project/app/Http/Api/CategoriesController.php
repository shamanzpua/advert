<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;
use App\Models\Advertisements\Advertisement;
use App\Http\Resources\Advertisements;
use App\Models\Advertisements\Category;
use App\Http\Resources\Categories;

/**
 * Class CategoriesController
 * @package App\Http\Controllers
 */
class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $parentCategoryId = $request->get('parentCategoryId');

        if ($parentCategoryId) {
            $categories = Category::where('parent_id', $parentCategoryId)->get();
        } else {
            $categories = Category::whereNull('parent_id')->get();
        }

        return [
            'data' => $categories,
        ];
    }

    /**
     * @deprecated
     * @param Request $request
     * @return array
     */
    public function indexOld(Request $request)
    {
        $parentCategoryId = $request->get('parentCategoryId');

        $parent = null;
        if ($parentCategoryId) {
            $parent = Category::where('parent_id', $parentCategoryId)->first();

            if (!$parent) {
                $parent = Category::where('id', $parentCategoryId)->first();
            }
        }


        if ($parent) {
            return [
                'data' => [
                    'all' => Category::getTree($parent),
                ]
            ];
        }

        $data = Category::whereNull('parent_id')->get();
        return [
            'data' => new Categories($data),
            'level' => $data->first()->level ?? null
        ];
    }
}
