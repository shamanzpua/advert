<?php

use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;
use App\Models\Advertisements\Advertisement;
use App\Http\Resources\Advertisements;
use App\Models\Advertisements\Category;
use App\Http\Resources\Categories;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/categories', function (Request $request) {
    $parentCategoryId = $request->get('parentCategoryId');

    $parent =null;
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
    } else {
        $query = Category::whereNull('parent_id');
    }
	$data = $query->get();
    return [
		'data' => new Categories($data),
		'level' => $data->first()->level ?? null	
	];
});


Route::get('/advertisements', function (Request $request) {
    $categoryId = $request->get('categoryId');

    if ($categoryId) {
        $advertisements = Advertisement::where('category_id', (int) $categoryId)->get();
    } else {
        $advertisements = Advertisement::all();
    }

    return new Advertisements($advertisements);
});

/**
Route::middleware('auth:api')->get('/user', function (Request $request) {


    return $request->user();
});
 **/
