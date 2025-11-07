<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function redirectToFull(Product $product)
    {
        $category = $product->category;
        $subcategory = $product->subcategory;

        if (!$category || !$subcategory) {
            abort(404);
        }

        return redirect()->route('product.show', [
            'category'    => $category->slug,
            'subcategory' => $subcategory->slug,
            'product'     => $product->slug,
        ], 301);
    }

    public function show($categorySlug, $subcategorySlug, Product $product)
    {
        if (
            !$product->subcategory ||
            $product->subcategory->slug !== $subcategorySlug ||
            !$product->category ||
            $product->category->slug !== $categorySlug
        ) {
            abort(404);
        }

        $new_products = Product::with(['category', 'subcategory', 'variants'])
            ->active()
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        return view('pages.product.show', compact('product','new_products'));
    }

}
