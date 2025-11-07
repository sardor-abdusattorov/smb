@if($products->isNotEmpty())
  <section class="collection-section">
    <div class="container">
      <h2 class="section-title2">НОВОЕ</h2>

      <div class="products-grid">
        @foreach($products as $product)
          <div class="product-card">
            <a href="{{ route('product.show', [
                'category'    => $product->category->slug,
                'subcategory' => $product->subcategory->slug,
                'product'     => $product->slug,
            ]) }}" class="product-image">
              <img src="{{ $product->getFirstMediaUrl('preview_image') ?: '/images/no-image.png' }}"
                   alt="{{ $product->name }}">
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

              <div class="heart-icon {{ $isActive ? 'active' : '' }}" onclick="toggleHeart(this)"  data-product-id="{{ $product->id }}">
                <svg viewBox="0 0 24 24">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5
                5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78
                1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
              </div>

            <!-- isNew icon -->
            @if($product->is_new_collection)
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
              <div class="product-brand">
                {{ $product->subcategory?->name ?? $product->name }}
              </div>

              <div class="product-price_item">
                @if(!empty($product->display_old_price))
                  <div class="old-product-price">
                    {{ number_format($product->display_old_price, 0, ',', ' ') }} ₽
                  </div>
                @endif

                <div class="product-price">
                  {{ number_format($product->display_price, 0, ',', ' ') }} ₽
                </div>
              </div>

              @if($product->variants->isNotEmpty())
                <div class="color-options">
                  @foreach($product->variants->take(5) as $variant)
                    @if($variant->color_code)
                      <span class="color-option" style="background-color: {{ $variant->color_code }};"></span>
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
      </div>
    </div>
  </section>
@endif
