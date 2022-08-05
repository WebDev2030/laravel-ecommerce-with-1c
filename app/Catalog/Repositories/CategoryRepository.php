<?php

namespace App\Catalog\Repositories;

use App\Catalog\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model = Category::class;

    public function store()
    {
        // TODO: Implement store() method.
    }
}
