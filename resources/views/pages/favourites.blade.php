@extends('layouts.main', ['wrapperClass' => 'catalog'])

@section('title', 'Каталог')

@section('content')

  <x-marquee />

  <x-header />

  @php
    $guestItems = \App\Http\Controllers\WishlistController::getGuestWishlistFromSession();
    $guestCount = count($guestItems);
    $wishCount = auth('web')->check()
        ? \App\Models\WishlistItem::where('frontend_user_id', auth('web')->id())->count()
        : $guestCount;
    $hasWishlist = $wishCount > 0;
  @endphp

  

<section class="smb-newsletter-section favaurite">
  <div class="smb-newsletter-container">
    <h1 class="smb-newsletter-title">вишлист <span>({{ $wishCount }})</span></h1>
    @auth('web')

    @else
    
      <p class="smb-newsletter-description">Войди или зарегистрируйся, чтобы сохранить свои находки.Без входа
        товары в списке желаний будут ждать 7 дней</p>
      <button class="smb-subscribe-btn border-black text-black profile-btn">Войти</button>
    
    @endauth
  </div>
</section>



<section class="collection-section" style="padding-top: 64px;">
  <div class="container">

    <div class="products-grid">
      <!-- Product 1 -->
        
      @if($products->isNotEmpty())
      @foreach($products as $product)

      <div class="product-card">
        <a href="{{ route('product.show', [
                'category'    => $product->category?->slug,
                'subcategory' => $product->subcategory?->slug,
                'product'     => $product->slug,
            ]) }}" class="product-image">

          <img src="{{ $product->getFirstMediaUrl('preview_image') }}" alt="Mini Rosa Handbag">
        </a>

       @php
            $isActive = false;

            if(auth('web')->check()) {
                // Login bo'lgan foydalanuvchi uchun bazadan tekshir
                $isActive = \App\Models\WishlistItem::where('frontend_user_id', auth('web')->id())
                            ->where('product_id', $product->id)
                            ->exists();
            } else {
              // Session strukturangiz 'items' ichida saqlangan
              $guestData = session('guest_wishlist', null);
              $guestItems = [];
              if ($guestData && is_array($guestData)) {
                  $guestItems = $guestData['items'] ?? [];
              }
              $isActive = in_array($product->id, $guestItems);
            }
          @endphp

        <div class="heart-icon {{ $isActive ? 'active' : '' }}" onclick="toggleHeart(this)" data-product-id="{{ $product->id }}">
          <svg viewBox="0 0 24 24">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5
          5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78
          1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
          </svg>
        </div>

        <!-- isnew icon -->
        @if($product->is_new_collection == 1)
        <div class="isnew-icon">
          <svg width="39" height="102" viewBox="0 0 39 102" fill="none"
               xmlns="http://www.w3.org/2000/svg">
            <rect x="0.5" y="0.5" width="38" height="101" stroke="#91BE17" />
            <text x="15" y="110" font-size="16" fill="#91BE17"
                  transform="rotate(-90 5,90)">НОВОЕ</text>
          </svg>
        </div>
        @endif

        <div class="product-info">
          <div class="product-brand">{{ $product->name }}</div>
          <div class="product-price_item">
            @if($product->old_price && $product->old_price > $product->price)
              <div class="old-product-price">
                {{ number_format($product->old_price, 0, ',', ' ') }} ₽
              </div>
            @endif
            <div class="product-price">
              {{ number_format($product->price, 0, ',', ' ') }} ₽
            </div>
          </div>

          @if($product->variants->isNotEmpty())
            <div class="color-options">
              @foreach($product->variants->take(5) as $variant)
                @if($variant->color_code)
                  <span class="color-option"
                        style="background-color: {{ $variant->color_code }}"></span>
                @endif
              @endforeach

              @if($product->variants->count() > 5)
                <span class="color-option more">
                  +{{ $product->variants->count() - 5 }}
                </span>
              @endif
            </div>
          @endif
        </div>
      </div>

      @endforeach
      @else
        <p>Ваш список желаний пуст.</p>
      @endif
      
    </div>

  </div>
</section>

<section class="deliver favaurite">
  <div class="block">
    <div class="box">
      <h1>Дели заказ на 4 части <br>
        Носи сейчас, плати потом</h1>
      <p>Теперь доступна покупка в сплит для всех заказов. Раздели платёж на 4 части с сервисами Яндекс
        сплит, Долями, Подели</p>
    </div>
  </div>
</section>


<x-footer />

@endsection
