<?php
namespace App\Services\TreePathGenerator;

use App\Models\Advertisements\Category;
use App\Services\TreePathGenerator\Contracts\IPathGenerator;
use App\Services\TreePathGenerator\Exceptions\BadCategoryInstanceException;

/**
 * Class CategoryPathGenerator
 * @package App\Services
 */
class CategoryPathGenerator implements IPathGenerator
{
    /**
     * @var Category $category
     */
    private $category;

    /**
     * @inheritdoc
     */
    public function generate($category)
    {
        if ($category instanceof Category === false) {
            throw new BadCategoryInstanceException();
        }

        $this->category = $category;

        return  $this->ensureParentElement(). $this->ensureCurrentElement();
    }

    /**
     * @return null|string
     */
    private function ensureParentElement()
    {
        if (!$this->category->parent_id) {
            return null;
        }

        $parentCategory = Category::find($this->category->parent_id);

        $generator = new static();
        return $generator->generate($parentCategory);
    }

    /**
     * @return string
     */
    private function ensureCurrentElement()
    {
        return "{". $this->category->id ."}";
    }
}