<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;
use App\Models\Advertisements\Advertisement;
use App\Http\Resources\Advertisements;
use App\Models\Advertisements\Category;
use App\Http\Resources\Categories;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ImagesController
 * @package App\Http\Controllers
 */
class ImagesController extends Controller
{
    private $types = [
        'category' => Category::class,
        'advertisements' => Advertisement::class,
    ];

    public function index($type, $id)
    {
        if (!isset($this->types[$type])) {
            throw new NotFoundHttpException();
        }

        $modelClass = $this->types[$type];

        $model = $modelClass::where('id', (int) $id)->first();

        if  (!$model || !$model->image) {
            throw new NotFoundHttpException();
        }

        $image = storage_path("files/{$type}/{$model->image}");

        if(!file_exists($image)) {
            throw new NotFoundHttpException();
        }
        return response()->file($image);
    }
}
