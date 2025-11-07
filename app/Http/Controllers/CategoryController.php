<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContentBlock;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $subcategories = $category->subcategories()
            ->where('status', 1)
            ->orderBy('sort')
            ->get();

        $products = Product::with(['category', 'subcategory', 'variants'])
            ->active()
            ->whereIn('subcategory_id', $category->subcategories->pluck('id'))
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        $top_products = Product::with(['category', 'subcategory', 'variants'])
            ->active()
            ->whereIn('subcategory_id', $category->subcategories->pluck('id'))
            ->orderBy('updated_at', 'asc')
            ->take(2)
            ->get();

        $new_products = Product::with(['category', 'subcategory', 'variants'])
            ->NewProducts()
            ->whereIn('subcategory_id', $category->subcategories->pluck('id'))
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        $all_products = Product::with(['category', 'subcategory', 'variants'])
            ->active()
            ->whereIn('subcategory_id', $category->subcategories->pluck('id'))
            ->orderBy('updated_at', 'desc')
            ->paginate(8);

        $catalog_delivery = ContentBlock::where('key', 'catalog_delivery')->first();
        $mini_moss       = ContentBlock::where('key', 'home_moni_moss')->first();

        return view('pages.category.show', [
            'category'      => $category,
            'subcategories' => $subcategories,
            'products'      => $products,
            'catalog_delivery' => $catalog_delivery,
            'new_products'  => $new_products,
            'all_products'  => $all_products,
            'mini_moss'      => $mini_moss,
            'top_products'      => $top_products,
        ]);
    }
}
