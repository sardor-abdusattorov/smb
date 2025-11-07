<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Repositories\SubcategoryRepository;
use App\Models\ContentBlock;

class SubCategoryController extends Controller
{
    protected SubcategoryRepository $repo;

    public function __construct(SubcategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function show(Category $category, Subcategory $subcategory)
    {

        $products = $this->repo->getProducts($subcategory);

        $all_products = Product::with(['category', 'subcategory', 'variants'])
            ->active()
            ->where('subcategory_id', $subcategory->id)
            ->orderBy('updated_at', 'desc')
            ->paginate(8);

        $mini_moss       = ContentBlock::where('key', 'home_moni_moss')->first();
        $catalog_delivery = ContentBlock::where('key', 'catalog_delivery')->first();

        return view('pages.subcategory.show', [
            'category'    => $category,
            'subcategories'=> $subcategory,
            'products'   => $products,
            'all_products'   => $all_products,
            'mini_moss'   => $mini_moss,
            'catalog_delivery'   => $catalog_delivery,
        ]);
    }
}
