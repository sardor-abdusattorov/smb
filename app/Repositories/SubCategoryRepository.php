<?php

namespace App\Repositories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Collection;

class SubCategoryRepository
{
    public function getProducts(Subcategory $subcategory): Collection
    {
        return $subcategory->products()
            ->with(['category', 'subcategory', 'variants'])
            ->where('status', true)
            ->orderBy('sort')
            ->get();
    }

    public function getActiveSubcategories(): Collection
    {
        return SubCategory::query()
            ->where('status', SubCategory::STATUS_ACTIVE)
            ->orderBy('sort')
            ->get();
    }

    public function getActiveSubcategoriesWithProducts(): Collection
    {
        return SubCategory::query()
            ->where('status', SubCategory::STATUS_ACTIVE)
            ->with(['products' => function ($q) {
                $q->where('status', true)->orderBy('sort');
            }])
            ->orderBy('sort')
            ->get();
    }

}
