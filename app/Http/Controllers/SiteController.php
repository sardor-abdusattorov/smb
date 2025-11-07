<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ContentBlock;
use App\Models\HandbagGallery;
use App\Models\HeroGallery;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\WishlistItem;
use App\Http\Controllers\WishlistController; 

class SiteController extends Controller
{

    public function index()
    {
        $hero_slider = HeroGallery::where('status', 1)
            ->orderBy('sort', 'asc')
            ->get();

        $home_delivery_1 = ContentBlock::where('key', 'home_delivery_1')->first();
        $home_delivery_2 = ContentBlock::where('key', 'home_delivery_2')->first();
        $mini_moss       = ContentBlock::where('key', 'home_moni_moss')->first();

        $handbag_gallery = HandbagGallery::where('status', 1)
            ->orderBy('sort', 'asc')
            ->get();

        $products = Product::with(['category', 'subcategory', 'variants'])
            ->active()
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        $new_products = Product::with(['category', 'subcategory', 'variants'])
            ->newActive()
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        return view('pages.home', compact(
            'hero_slider',
            'home_delivery_1',
            'home_delivery_2',
            'mini_moss',
            'handbag_gallery',
            'new_products',
            'products'
        ));
    }


    public function about()
    {
        return view('pages.about');
    }
    
    public function search()
    {
        return view('pages.search');
    }

    public function favourites()
    {
        // Auth user uchun DB-dan productlarni olamiz
        if (Auth::guard('frontend')->check()) {
            $userId = Auth::guard('frontend')->id();

            $items = WishlistItem::with('product')
                    ->where('frontend_user_id', $userId)
                    ->latest()
                    ->get();

            if ($items->isEmpty()) {
                return redirect()->route('home');
            }

            // Extract only product models (skip nulls)
            $products = $items->map(fn($it) => $it->product)->filter();
        } else {
            // Guest: sessiondagi id-lar
            $guestIds = WishlistController::getGuestWishlistFromSession(); // array of product_id
            if (empty($guestIds)) {
                return redirect()->route('home');
            }

            $products = Product::with(['variants', 'category', 'subcategory'])
                        ->whereIn('id', $guestIds)
                        ->get()
                        ->keyBy('id');

            // preserve order
            $ordered = collect();
            foreach ($guestIds as $pid) {
                if (isset($products[$pid])) {
                    $ordered->push($products[$pid]);
                }
            }
            $products = $ordered;
        }

        // products — Eloquent Collection of Product models
        return view('pages.favourites', [
            'products' => $products,
        ]);
    }

    public function catalog()
    {

        $all_categories = Category::where('status', 1)
            ->orderBy('sort')
            ->get();

        $subcategories = SubCategory::where('status', 1)
            ->orderBy('sort')
            ->get();

        $products = Product::with(['category', 'subcategory', 'variants'])
            ->active()
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        $top_products = Product::with(['category', 'subcategory', 'variants'])
            ->active()
            ->orderBy('updated_at', 'asc')
            ->take(2)
            ->get();

        $new_products = Product::with(['category', 'subcategory', 'variants'])
            ->NewProducts()
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->get();

        $all_products = Product::with(['category', 'subcategory', 'variants'])
            ->active()
            ->orderBy('updated_at', 'desc')
            ->paginate(8);

        $catalog_delivery = ContentBlock::where('key', 'catalog_delivery')->first();
        $mini_moss       = ContentBlock::where('key', 'home_moni_moss')->first();

        return view('pages.catalog', [
            'all_categories'      => $all_categories,
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