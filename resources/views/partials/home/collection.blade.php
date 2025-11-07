@if($new_products->isNotEmpty())

  <section class="collection-section">
    <div class="container">
      <h2 class="section-title">НОВАЯ КОЛЛЕКЦИЯ</h2>

      <div class="products-grid">
        @forelse($new_products as $product)
          <div class="product-card">
            <a href="{{ route('product.show', [
              'category'    => $product->category->slug,
              'subcategory' => $product->subcategory->slug,
              'product'     => $product->slug,
          ]) }}" class="product-image">
              <img
                src="{{ $product->getFirstMediaUrl('preview_image')}}"
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
              <div class="heart-icon {{ $isActive ? 'active' : '' }}" onclick="toggleHeart(this)" data-product-id="{{ $product->id }}">
                <svg viewBox="0 0 24 24">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5
                5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78
                1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
              </div>

            <div class="product-info">
              <div class="product-brand">{{ $product->name }}</div>

              <div class="product-price">
                {{ number_format($product->display_price, 0, ',', ' ') }} ₽
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
        @empty

        @endforelse
      </div>
    </div>
  </section>

@endif
