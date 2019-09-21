<?php
namespace App\Models\Advertisements;

use App\Services\TreePathGenerator\CategoryPathGenerator;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Categories;

/**
 * Class Category
 * @package app\models\advertisements
 */
class Category extends Model
{
	public static $parents = [];
	public static function getTree(Category $parent)
	{
		if ($parent->parent_id) {
			self::$parents[] = new Categories(Category::where('parent_id', $parent->parent_id)->get());	
			$highestParent = Category::where('id', $parent->parent_id)->first();
			if ($highestParent) {
				return self::getTree($highestParent);			
			}	
		}

		return array_reverse(self::$parents);
		 
	}


	public function save(array $options = [])
    {
        /**
         * @var CategoryPathGenerator $categoryPathGenerator
         */
        $categoryPathGenerator = app()->make(CategoryPathGenerator::class);
        $this->category_path = $categoryPathGenerator->generate($this);

        return parent::save($options);
    }
}
