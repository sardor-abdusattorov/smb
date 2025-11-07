<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Http\Controllers\Auth\AjaxAuthController;
use App\Http\Controllers\Auth\PhoneAuthController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;


Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});



// AJAX Auth (frontend)
Route::prefix('auth/ajax')->group(function () {
    Route::post('/login',    [AjaxAuthController::class, 'login'])->name('auth.ajax.login');
    Route::post('/register', [AjaxAuthController::class, 'register'])->name('auth.ajax.register');
    Route::post('/logout',   [AjaxAuthController::class, 'logout'])->name('auth.ajax.logout')->middleware('auth:frontend');
});

// Telefon OTP
Route::prefix('auth/phone')->group(function () {
    Route::post('/request', [PhoneAuthController::class, 'requestCode'])->name('auth.phone.request')->middleware('guest:frontend');
    Route::post('/verify',  [PhoneAuthController::class, 'verifyCode'])->name('auth.phone.verify')->middleware('guest:frontend');
});

// Profile (frontend)
Route::middleware('auth:frontend')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Guest wishlist toggle (sessionda saqlash — auth talab qilinmaydi)
Route::post('/wishlist/guest/toggle', [WishlistController::class, 'guestToggle'])
    ->name('wishlist.guest.toggle');

// Guest (session)
Route::prefix('cart/guest')->group(function () {
    Route::post('/add',      [CartController::class, 'guestAdd'])->name('cart.guest.add');
    Route::post('/set',      [CartController::class, 'guestSet'])->name('cart.guest.set'); // quantity set
    Route::post('/remove',   [CartController::class, 'guestRemove'])->name('cart.guest.remove');
    Route::post('/clear',    [CartController::class, 'guestClear'])->name('cart.guest.clear');
});

// Auth (DB)
Route::prefix('cart')->middleware('auth:frontend')->group(function () {
    Route::post('/add',      [CartController::class, 'add'])->name('cart.add');
    Route::post('/set',      [CartController::class, 'set'])->name('cart.set');
    Route::post('/remove',   [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear',    [CartController::class, 'clear'])->name('cart.clear');
});

// Sahifa ko'rish (auth/guest ikkisi uchun ham)
Route::get('/cart', [\App\Http\Controllers\SiteController::class, 'cart'])->name('cart.page');

// Mini cart modalni HTML fragment sifatida qaytaradi
Route::get('/cart/mini', [\App\Http\Controllers\CartController::class, 'mini'])
    ->name('cart.mini');

Route::prefix('wishlist')->middleware('auth:frontend')->group(function () {
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::post('/add',    [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
    // (ixtiyoriy) Route::get('/count', [WishlistController::class, 'count'])->name('wishlist.count');
});


// routes/web.php – ENG YUQORIDA (wildcardlardan OLDIN)
Route::get('/login', fn () => redirect()->route('home'))->name('login');
Route::get('/register', fn () => redirect()->route('home'))->name('register'); // ixtiyoriy

Route::group(
    [
        'middleware' => ['throttle:50,1'],
    ],
    function () {
        Route::get('/', [SiteController::class, 'index'])->name('home');
        Route::get('/about', [SiteController::class, 'about'])->name('about');
        Route::get('/search', [SiteController::class, 'search'])->name('search');
        Route::get('/favourites', [SiteController::class, 'favourites'])->name('favourites');
        Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
        Route::get('/rule', [SiteController::class, 'rule'])->name('rule');
        Route::get('/catalog', [SiteController::class, 'catalog'])->name('catalog');

        // News routes
        Route::get('/news', [NewsController::class, 'index'])->name('news.index');
        Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

        Route::get('/{category:slug}', [CategoryController::class, 'show'])
            ->name('category.show');

        Route::get('/{category:slug}/{subcategory:slug}', [SubcategoryController::class, 'show'])
            ->name('subcategory.show');

        Route::get('/{category:slug}/{subcategory:slug}/{product:slug}', [ProductController::class, 'show'])
            ->name('product.show');

        Route::get('/product/{product:slug}', [ProductController::class, 'redirectToFull'])
            ->name('product.short');

    }
);




Route::fallback(function () {
    // JSON/API so'rov bo'lsa 404 json qaytaramiz, aks holda home'ga redirect
    if (request()->expectsJson()) {
        return response()->json(['message' => 'Not Found'], 404);
    }

    return redirect()->route('home'); // yoki: return redirect('/');
});

Route::get('/debug-wishlist', function () {
    return session('guest_wishlist', 'no session');
});