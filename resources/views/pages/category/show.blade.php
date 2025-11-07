@extends('layouts.main', ['wrapperClass' => 'catalog'])

@section('title', 'Каталог')

@section('content')

  <x-marquee />

  <x-header />

  @include('partials.filter_section', ['subcategories' => $subcategories])

  <section class="hero-slider">
    <div class="swiper heroSwiper">
      <div class="swiper-wrapper">
        <!-- Slide 1 - Brown Bag -->
        <div class="swiper-slide brown-slide" style="background: url(/images/header_hero-bg1.png);background-repeat: no-repeat;
            background-position: center;
            background-size: cover;">
          <div class="container">
            <div class="row align-items-center min-vh-100">
              <div class="col-12">
                <div class="slide-content">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 2 - Pink Bag -->
        <div class="swiper-slide pink-slide" style="background: url(/images/header_hero-bg2.jpg);background-repeat: no-repeat;
            background-position: center;
            background-size: cover;">
          <div class="container">
            <div class="row align-items-center min-vh-100">
              <div class="col-12">
                <div class="slide-content">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 3 - Lifestyle -->
        <div class="swiper-slide lifestyle-slide" style="background: url(/images/header_hero-bg1.png);background-repeat: no-repeat;
            background-position: center;
            background-size: cover;">
          <div class="container">
            <div class="row align-items-center min-vh-100">
              <div class="col-12">
                <div class="slide-content">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  @if(setting('blocks.catalog.collection'))

    @include('partials.catalog.collection', ['products' => $products])

  @endif

  @if(setting('blocks.catalog.delivery'))
    @include('partials.catalog.delivery', ['block' => $catalog_delivery])
  @endif

  @if(setting('blocks.catalog.collection_all'))

    @include('partials.catalog.collection_all', ['all_products' => $all_products])

  @endif

  <section class="collection-section catalog">
    <div class="container">

      <div class="products-grid">
        <!-- Product 2 -->
        <div class="product-card">
          <img src="/images/catalog_collection-section-img.png" alt="">
          <p>SMB - для тех, кто носит себя громко</p>
        </div>

        <!-- Product 3 -->
        @if ($top_products->isNotEmpty())
          @foreach ($top_products as $top_product)
            
          <div class="product-card">
            <a href="{{ route('product.show', [
              'category'    => $top_product->category->slug,
              'subcategory' => $top_product->subcategory->slug,
              'product'     => $top_product->slug,
          ]) }}" class="product-image">

              <img src="{{ $top_product->getFirstMediaUrl('preview_image')}}" alt="Moss Handbag">
            </a>
            <div class="heart-icon" onclick="toggleHeart(this)">
              <svg viewBox="0 0 24 24">
                <path
                  d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
              </svg>
            </div>
            <!-- isnew icon -->
            @if ($top_product->is_new_collection)
              
            
            <div class="isnew-icon">
              <svg width="39" height="102" viewBox="0 0 39 102" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                <rect x="0.5" y="0.5" width="38" height="101" stroke="#91BE17" />
                <text x="15" y="110" font-size="16" fill="#91BE17"
                      transform="rotate(-90 5,90)">НОВОЕ
                </text>
              </svg>

            </div>
            @endif
            <div class="product-info">
              <div class="product-brand">{{ $top_product->name }}</div>
              <div class="product-price_item">
                <div class="old-product-price">{{ number_format($top_product->old_price, 0, ',', ' ') }} ₽</div>
                <div class="product-price">{{ number_format($top_product->price, 0, ',', ' ') }} ₽</div>
              </div>
              @if($top_product->variants->isNotEmpty())
                <div class="color-options">
                  @foreach($top_product->variants->take(5) as $variant)
                    @if($variant->color_code)
                      <span class="color-option" style="background-color: {{ $variant->color_code }};"></span>
                    @endif
                  @endforeach

                    @if($top_product->variants->count() > 5)
                      <span class="color-option more">
                      +{{ $top_product->variants->count() - 5 }}
                    </span>
                    @endif

                </div>

              @endif
            </div>
          </div>

          @endforeach
        @endif

      </div>
    </div>
  </section>

  @if(setting('blocks.catalog.mini_moss'))

    @include('partials.mini_moss', ['mini_moss' => $mini_moss])

  @endif

  @if(setting('blocks.catalog.collection_all'))

    @include('partials.catalog.collection_all', ['all_products' => $all_products])

  @endif

  @if(setting('blocks.catalog.newsletter'))

    @include('partials.newsletter')

  @endif

  <x-footer />

@endsection
