@extends('layouts.main', ['wrapperClass' => 'catalog'])

@section('title', 'Каталог')

@section('content')

  <x-marquee />

  <x-header />

{{--  @include('partials.filter_section', ['subcategories' => $subcategories])--}}

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

  @if(setting('blocks.catalog.collection'))

    @include('partials.catalog.collection', ['products' => $products])

  @endif

  {{-- <section class="collection-section catalog">
    <div class="container">

      <div class="products-grid">
        <!-- Product 2 -->
        <div class="product-card">
          <img src="/images/catalog_collection-section-img.png" alt="">
          <p>SMB - для тех, кто носит себя громко</p>
        </div>

        <!-- Product 3 -->
        <div class="product-card">
          <a href="product.html" class="product-image">

            <img src="/images/catalog_collection-section-brown-bag.png" alt="Moss Handbag">
          </a>
          <div class="heart-icon" onclick="toggleHeart(this)">
            <svg viewBox="0 0 24 24">
              <path
                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
            </svg>
          </div>
          <!-- isnew icon -->
          <div class="isnew-icon">
            <svg width="39" height="102" viewBox="0 0 39 102" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <rect x="0.5" y="0.5" width="38" height="101" stroke="#91BE17" />
              <text x="15" y="110" font-size="16" fill="#91BE17"
                    transform="rotate(-90 5,90)">НОВОЕ
              </text>
            </svg>

          </div>
          <div class="product-info">
            <div class="product-brand">MINI ROSA</div>
            <div class="product-price_item">
              <div class="old-product-price">29 000 ₽</div>
              <div class="product-price">21 000 ₽</div>
            </div>
            <div class="color-options">
              <span class="color-option" style="background-color: #5E4F37;"></span>
              <span class="color-option" style="background-color: #A86738;"></span>
              <span class="color-option" style="background-color: #000000;"></span>
              <span class="color-option" style="background-color: #DEDEDE;"></span>
              <span class="color-option" style="background-color: #FF5733;"></span>
              <span class="color-option" style="background-color: #33FF57;"></span>
              <span class="color-option" style="background-color: #3357FF;"></span>
              <span class="color-option" style="background-color: #F3FF33;"></span>
              <span class="color-option" style="background-color: #FF33F3;"></span>
              <span class="color-option" style="background-color: #33FFF3;"></span>
              <span class="color-option" style="background-color: #FF9933;"></span>
              <span class="color-option" style="background-color: #9933FF;"></span>
              <span class="color-option" style="background-color: #33FF99;"></span>
              <span class="color-option" style="background-color: #FF3399;"></span>
              <span class="color-option" style="background-color: #99FF33;"></span>
            </div>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product-card">
          <a href="product.html" class="product-image">

            <img src="/images/catalog_collection-section-yellow-bag.png"
                 alt="Mini Rosa Blue Handbag">
          </a>
          <div class="heart-icon" onclick="toggleHeart(this)">
            <svg viewBox="0 0 24 24">
              <path
                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
            </svg>
          </div>
          <!-- isnew icon -->
          <div class="isnew-icon">
            <svg width="39" height="102" viewBox="0 0 39 102" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <rect x="0.5" y="0.5" width="38" height="101" stroke="#91BE17" />
              <text x="15" y="110" font-size="16" fill="#91BE17"
                    transform="rotate(-90 5,90)">НОВОЕ
              </text>
            </svg>

          </div>
          <div class="product-info">
            <div class="product-brand">MINI ROSA</div>
            <div class="product-price_item">
              <div class="old-product-price">29 000 ₽</div>
              <div class="product-price">21 000 ₽</div>
            </div>
            <div class="color-options">
              <span class="color-option" style="background-color: #5E4F37;"></span>
              <span class="color-option" style="background-color: #A86738;"></span>
              <span class="color-option" style="background-color: #000000;"></span>
              <span class="color-option" style="background-color: #DEDEDE;"></span>
              <span class="color-option" style="background-color: #FF5733;"></span>
              <span class="color-option" style="background-color: #33FF57;"></span>
              <span class="color-option" style="background-color: #3357FF;"></span>
              <span class="color-option" style="background-color: #F3FF33;"></span>
              <span class="color-option" style="background-color: #FF33F3;"></span>
              <span class="color-option" style="background-color: #33FFF3;"></span>
              <span class="color-option" style="background-color: #FF9933;"></span>
              <span class="color-option" style="background-color: #9933FF;"></span>
              <span class="color-option" style="background-color: #33FF99;"></span>
              <span class="color-option" style="background-color: #FF3399;"></span>
              <span class="color-option" style="background-color: #99FF33;"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}

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
