@extends('layouts.main', ['wrapperClass' => 'product-card'])

@section('title', 'Страница продукта')

@section('content')
  <x-marquee />

  <x-header />

  <section class="product_catalog">
    <div class="breadcrumb">
      <a href="{{ route('catalog') }}">Каталог</a>
      <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
        <mask id="mask0_758_40483" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="12"
              height="12">
          <rect width="12" height="12" fill="#D9D9D9" />
        </mask>
        <g mask="url(#mask0_758_40483)">
          <path
            d="M4.00845 10.8256L3.29883 10.116L7.41608 5.99875L3.29883 1.8815L4.00845 1.17188L8.83533 5.99875L4.00845 10.8256Z"
            fill="#858585" />
        </g>
      </svg>

      <a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }} сумки</a>

      <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
        <mask id="mask0_758_40483" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="12"
              height="12">
          <rect width="12" height="12" fill="#D9D9D9" />
        </mask>
        <g mask="url(#mask0_758_40483)">
          <path
            d="M4.00845 10.8256L3.29883 10.116L7.41608 5.99875L3.29883 1.8815L4.00845 1.17188L8.83533 5.99875L4.00845 10.8256Z"
            fill="#858585" />
        </g>
      </svg>
      <a class="active">{{ $product->name }}</a>

    </div>
    <!--  -->
    <div class="container">
      <div class="product" id="product_card">

        <div class="product__images">
          <!-- Desktop version -->
          <div class="desktop-images">
            <div class="product-image">

              <img src="{{ $product->getFirstMediaUrl('preview_image') }}" alt="Green bag front view"
                   id="main-image">

              @php
                $isActive = false;

                if(auth('frontend')->check()) {
                    // Login bo'lgan foydalanuvchi uchun bazadan tekshir
                    $isActive = \App\Models\WishlistItem::where('frontend_user_id', auth('frontend')->id())
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

            </div>

            @foreach($product->getMedia('gallery') as $image)

            <div class="product-image">
              <img src="{{ $image->getUrl() }}" alt="Model with bag"
                   id="main-image">
            </div>

            @endforeach

          </div>

          <!-- Mobile swiper -->
          <div class="swiper mobile-swiper" style="display: none;">
            <div class="swiper-wrapper">

              <div class="swiper-slide">
                <img src="{{ $product->getFirstMediaUrl('preview_image') }}" alt="Model with bag"
                     id="main-image">
              </div>

              @foreach($product->getMedia('gallery') as $image)
                <div class="swiper-slide">
                  <img src="{{ $image->getUrl() }}" alt="Model with bag"
                      id="main-image">
                </div>
              @endforeach

            </div>
            <div class="swiper-pagination"></div>
          </div>

        </div>

        <div class="product__info" id="product-info">
          <h1 class="product-title">{{ $product->name }}</h1>

          @if($product->variants->isNotEmpty())
          
          <div class="color-options">
            <div class="color-options__list">

               @foreach($product->variants as $key => $variant)
                @if($variant->color_code)

                <input type="radio" id="color-{{ $variant->name }}" name="color" value="{{ $variant->color_code }}" {{ $key == 0 ? 'checked' : '' }}>
                <label for="color-yellow" class="color-yellow" style="background: {{ $variant->color_code }}"></label>

                @endif
              @endforeach
              
            </div>
          </div>

          @endif

          <div class="material-options">
            <div class="material-options__buttons">
              <input type="radio" id="material-suede" name="material" value="suede">
              <label for="material-suede">ЗАМША</label>

              <input type="radio" id="material-leather" name="material" value="leather" checked>
              <label for="material-leather">КОЖА</label>
            </div>
          </div>

          <div class="size-options">
            <div class="size-options__buttons">
              <input type="radio" id="size-s" name="size" value="S">
              <label for="size-s">S</label>

              <input type="radio" id="size-m" name="size" value="M" checked>
              <label for="size-m">M</label>

              <input type="radio" id="size-l" name="size" value="L">
              <label for="size-l">L</label>
            </div>
          </div>

          <div class="price">
            <div class="price__current">29 900 ₽ <del>29 000 ₽</del>
            </div>
            <div class="price__installment" id="installment-btn">4 платежа по 7960 ₽</div>
            <span class="mobile-text">
                                Оплата Частями
                            </span>
          </div>

          <div class="buttons">
            <button class="buttons__add-to-cart btn-add-cart" data-product-id="{{ $product->id }}">ДОБАВИТЬ В КОРЗИНУ</button>
            <div class="heart-icon  d-lg-none d-block {{ $isActive ? 'active' : '' }}" onclick="toggleHeart(this)" data-product-id="{{ $product->id }}">
                <svg viewBox="0 0 24 24">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5
                5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78
                1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
              </div>
          </div>

        </div>

      </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="installment-modal">
      <div class="modal__content">
        <button class="close" id="modal-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
            <rect width="24" height="24" fill="white" />
            <mask id="mask0_3220_12505" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                  width="24" height="24">
              <rect width="24" height="24" fill="#D9D9D9" />
            </mask>
            <g mask="url(#mask0_3220_12505)">
              <path
                d="M6.39916 18.3108L5.69141 17.6031L11.2914 12.0031L5.69141 6.40306L6.39916 5.69531L11.9992 11.2953L17.5992 5.69531L18.3069 6.40306L12.7069 12.0031L18.3069 17.6031L17.5992 18.3108L11.9992 12.7108L6.39916 18.3108Z"
                fill="#1C1B1F" />
            </g>
          </svg>
        </button>

        <h2>ПОКУПАЙ СЕЙЧАС, А ПЛАТИ ПОТОМ</h2>

        <div class="subtitle">
          В SMB доступна оплата покупки частями<br>
          с помощью сервисов «Долями» и «Подели»
        </div>

        <div class="payment-tabs">
          <button><svg width="57" height="8" viewBox="0 0 57 8" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
              <path d="M10.4392 0H9.10443V6.76887H10.4392V0Z" fill="#272727" />
              <path d="M7.57111 0.378764H6.23629V7.14749H7.57111V0.378764Z" fill="#272727" />
              <path d="M4.70296 0.801615H3.36814V7.57162H4.70296V0.801615Z" fill="#272727" />
              <path d="M1.83482 1.22917H0.5L0.500005 8H1.83482L1.83482 1.22917Z" fill="#272727" />
              <path
                d="M45.6935 3.60753L43.5442 1.21793H42.2878V6.7507H43.5996V3.22068L45.5618 5.3121H45.8043L47.7327 3.22068V6.7507H49.0446V1.21793H47.7881L45.6935 3.60753Z"
                fill="#272727" />
              <path
                d="M55.2945 1.21793L52.043 4.81403V1.21793H50.7311V6.7507H51.933L55.1846 3.1546V6.7507H56.4964V1.21793H55.2945Z"
                fill="#272727" />
              <path
                d="M35.2217 3.24244C35.2217 4.12334 35.7034 4.81725 36.4428 5.10819L35.0563 6.7507H36.662L37.9233 5.25649H39.2882V6.7507H40.6V1.21793H37.2602C36.0149 1.21793 35.2217 2.0698 35.2217 3.24244ZM39.289 2.43651V4.07256H37.5034C36.9077 4.07256 36.5882 3.74051 36.5882 3.25373C36.5882 2.76694 36.9189 2.43489 37.5034 2.43489L39.289 2.43651Z"
                fill="#272727" />
              <path
                d="M29.1255 2.32448C29.0453 4.2273 28.6438 5.45555 27.8578 5.45555H27.6611V6.78374L27.8707 6.79502C29.4467 6.88287 30.3178 5.49988 30.4607 2.47922H32.5337V6.7507H33.8431V1.21793H29.1697L29.1255 2.32448Z"
                fill="#272727" />
              <path
                d="M24.1872 1.14062C22.4129 1.14062 21.1364 2.36888 21.1364 3.98398C21.1364 5.65469 22.5253 6.83942 24.1872 6.83942C25.9182 6.83942 27.263 5.5886 27.263 3.98398C27.263 2.37935 25.9182 1.14062 24.1872 1.14062ZM24.1872 5.51123C23.1845 5.51123 22.5012 4.85842 22.5012 3.98398C22.5012 3.08777 23.1853 2.45269 24.1872 2.45269C25.1892 2.45269 25.8957 3.11679 25.8957 3.98398C25.8957 4.85117 25.1796 5.51123 24.1872 5.51123Z"
                fill="#272727" />
              <path
                d="M19.7451 1.22836H15.115L15.0709 2.33492C15.005 3.92906 14.5891 5.44504 13.8031 5.4668L13.4395 5.47808V8.00124L14.7626 7.99858V6.75146H19.3589V7.99858H20.6932V5.4668H19.7451V1.22836ZM18.4332 5.4668H15.6337C16.1073 4.7479 16.361 3.70743 16.4052 2.49046H18.4332V5.4668Z"
                fill="#272727" />
            </svg>
          </button>
          <button class="active"> <svg width="56" height="9" viewBox="0 0 56 9" fill="none"
                                       xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <rect x="0.5" width="55" height="9" fill="url(#pattern0_3220_12484)" />
              <defs>
                <pattern id="pattern0_3220_12484" patternContentUnits="objectBoundingBox" width="1"
                         height="1">
                  <use xlink:href="#image0_3220_12484" transform="scale(0.00179856 0.0109912)" />
                </pattern>
                <image id="image0_3220_12484" width="556" height="91" preserveAspectRatio="none"
                       xlink:href="data:image/png;base64,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" />
              </defs>
            </svg>
          </button>
        </div>

        <div class="modal_block">
          <div class="subtitle2">
            Заплатите сейчас только часть, а остальное будем<br>
            списывать каждые две недели
          </div>

          <div class="payment-schedule">
            <div class="payment-item active">
              <div class="percentage">25%</div>
              <div class="period">Платеж<br>сегодня</div>
            </div>
            <div class="payment-item">
              <div class="percentage">25%</div>
              <div class="period">Через<br>2 недели</div>
            </div>
            <div class="payment-item">
              <div class="percentage">25%</div>
              <div class="period">Через<br>4 недели</div>
            </div>
            <div class="payment-item">
              <div class="percentage">25%</div>
              <div class="period">Через<br>6 недель</div>
            </div>
          </div>

          <div class="payment-info">
            <ul>
              <li>Оплачивайте покупки частями — по 25% каждые две недели</li>
              <li>Заказ от 500 ₽ до 70 000 ₽</li>
              <li>Может быть сервисный сбор</li>
            </ul>
          </div>
        </div>

        <div class="service-link">
          Подробнее о сервисе можно узнать на <a href="#">dolyame.ru</a>
        </div>

        <button class="close-button" id="modal-close-btn">ЗАКРЫТЬ</button>
      </div>
    </div>
    <!-- =========================== -->
    <div class="container">
      <div class="product2">
        <div class="product2__image">
          <img src="/images/product_product_catalog_product2.png" alt="Product Image">
        </div>
        <div class="product__accardion">
          <div class="accordion" id="productAccordion">
            <!-- Description Accordion -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseDescription" aria-expanded="false"
                        aria-controls="collapseDescription">
                  Описание
                </button>
              </h2>
              <div id="collapseDescription" class="accordion-collapse collapse"
                   data-bs-parent="#productAccordion">
                <div class="accordion-body">
                  <p>Для удаления небольших загрязнений используй мягкую ткань. Не погружай сумку
                    в воду или другие жидкости. Для очистки приготовь раствор из воды, мыла
                    нашатырного спирта, затем протри сумку насухо</p>
                  <p>После намокания дай сумке высохнуть естественным путём при комнатной
                    температуре. Избегай использования искусственного тепла, сушки горячим
                    воздухом или под солнечными лучами</p>
                  <p>Не применяй растворители, химические вещества и другие агрессивные средства
                  </p>
                  <p>Предотвращай чрезмерные механические нагрузки, удары и трение о жёсткие или
                    острые предметы</p>
                  <p>Не храни сумку в пластиковых пакетах и избегай воздействия яркого солнца, т.к
                    это может привести к изменению цвета кожи или выцветанию</p>
                  <p>Перед первым использованием рекомендуем пропитать кожу специальными
                    средствами для ухода, чтобы повысить её устойчивость к грязи и влаге. При
                    загрязнениях используй специальные средства, салфетки для чистки и полировки
                    кожи, следуя инструкциям производителя</p>
                  <p>Перед применением любых средств для ухода и чистки проверь их на незаметном
                    участке изделия</p>
                </div>
              </div>
            </div>

            <!-- Material Accordion -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseMaterial" aria-expanded="false"
                        aria-controls="collapseMaterial">
                  Материал
                </button>
              </h2>
              <div id="collapseMaterial" class="accordion-collapse collapse"
                   data-bs-parent="#productAccordion">
                <div class="accordion-body">
                  <p>Для удаления небольших загрязнений используй мягкую ткань. Не погружай сумку
                    в воду или другие жидкости. Для очистки приготовь раствор из воды, мыла
                    нашатырного спирта, затем протри сумку насухо</p>
                  <p>После намокания дай сумке высохнуть естественным путём при комнатной
                    температуре. Избегай использования искусственного тепла, сушки горячим
                    воздухом или под солнечными лучами</p>
                  <p>Не применяй растворители, химические вещества и другие агрессивные средства
                  </p>
                  <p>Предотвращай чрезмерные механические нагрузки, удары и трение о жёсткие или
                    острые предметы</p>
                  <p>Не храни сумку в пластиковых пакетах и избегай воздействия яркого солнца, т.к
                    это может привести к изменению цвета кожи или выцветанию</p>
                  <p>Перед первым использованием рекомендуем пропитать кожу специальными
                    средствами для ухода, чтобы повысить её устойчивость к грязи и влаге. При
                    загрязнениях используй специальные средства, салфетки для чистки и полировки
                    кожи, следуя инструкциям производителя</p>
                  <p>Перед применением любых средств для ухода и чистки проверь их на незаметном
                    участке изделия</p>
                </div>
              </div>
            </div>

            <!-- Care Accordion -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseCare" aria-expanded="false"
                        aria-controls="collapseCare">
                  Уход
                </button>
              </h2>
              <div id="collapseCare" class="accordion-collapse collapse"
                   data-bs-parent="#productAccordion">
                <div class="accordion-body">
                  <p>Для удаления небольших загрязнений используй мягкую ткань. Не погружай сумку
                    в воду или другие жидкости. Для очистки приготовь раствор из воды, мыла
                    нашатырного спирта, затем протри сумку насухо</p>
                  <p>После намокания дай сумке высохнуть естественным путём при комнатной
                    температуре. Избегай использования искусственного тепла, сушки горячим
                    воздухом или под солнечными лучами</p>
                  <p>Не применяй растворители, химические вещества и другие агрессивные средства
                  </p>
                  <p>Предотвращай чрезмерные механические нагрузки, удары и трение о жёсткие или
                    острые предметы</p>
                  <p>Не храни сумку в пластиковых пакетах и избегай воздействия яркого солнца, т.к
                    это может привести к изменению цвета кожи или выцветанию</p>
                  <p>Перед первым использованием рекомендуем пропитать кожу специальными
                    средствами для ухода, чтобы повысить её устойчивость к грязи и влаге. При
                    загрязнениях используй специальные средства, салфетки для чистки и полировки
                    кожи, следуя инструкциям производителя</p>
                  <p>Перед применением любых средств для ухода и чистки проверь их на незаметном
                    участке изделия</p>
                </div>
              </div>
            </div>

            <!-- Payment & Delivery Accordion -->
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePayment" aria-expanded="false"
                        aria-controls="collapsePayment">
                  Оплата и доставка
                </button>
              </h2>
              <div id="collapsePayment" class="accordion-collapse collapse"
                   data-bs-parent="#productAccordion">
                <div class="accordion-body">
                  <p>Для удаления небольших загрязнений используй мягкую ткань. Не погружай сумку
                    в воду или другие жидкости. Для очистки приготовь раствор из воды, мыла
                    нашатырного спирта, затем протри сумку насухо</p>
                  <p>После намокания дай сумке высохнуть естественным путём при комнатной
                    температуре. Избегай использования искусственного тепла, сушки горячим
                    воздухом или под солнечными лучами</p>
                  <p>Не применяй растворители, химические вещества и другие агрессивные средства
                  </p>
                  <p>Предотвращай чрезмерные механические нагрузки, удары и трение о жёсткие или
                    острые предметы</p>
                  <p>Не храни сумку в пластиковых пакетах и избегай воздействия яркого солнца, т.к
                    это может привести к изменению цвета кожи или выцветанию</p>
                  <p>Перед первым использованием рекомендуем пропитать кожу специальными
                    средствами для ухода, чтобы повысить её устойчивость к грязи и влаге. При
                    загрязнениях используй специальные средства, салфетки для чистки и полировки
                    кожи, следуя инструкциям производителя</p>
                  <p>Перед применением любых средств для ухода и чистки проверь их на незаметном
                    участке изделия</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  -->
    <div class="container">
      <div class="product3">
        <div class="product3__image">
          <img src="/images/product_product_catalog_product3.png" alt="Product3 image">
        </div>
        <div class="product3__item">
          <div class="product3__dimensions">36 × 25 × 18</div>
          <div class="product3__title">Вмещает</div>
          <ul class="product3__list">
            <li class="product3__list-item">Пляжное полотенце</li>
            <li class="product3__list-item">Косметичка</li>
            <li class="product3__list-item">Термостакан 1л</li>
            <li class="product3__list-item">Макбук</li>
          </ul>
        </div>
      </div>
    </div>

  </section>

  <section class="product_animation">
    <div class="container">
      <div class="product-gallery">
        <div class="product-gallery__wrapper">
          <div class="product-gallery__slide">
            <img src="/images/product_scroll_animation.png" alt="Product Image 1"
                 class="product-gallery__image">
          </div>
          <div class="product-gallery__slide">
            <img src="/images/product_scroll_animation-img2.png" alt="Product Image 2"
                 class="product-gallery__image">
          </div>
          <div class="product-gallery__slide">
            <img src="/images/product_scroll_animation.png" alt="Product Image 3"
                 class="product-gallery__image">
          </div>
          <!-- Duplicate slides for seamless loop -->
          <div class="product-gallery__slide">
            <img src="/images/product_scroll_animation-img2.png" alt="Product Image 1"
                 class="product-gallery__image">
          </div>
          <div class="product-gallery__slide">
            <img src="/images/product_scroll_animation.png" alt="Product Image 2"
                 class="product-gallery__image">
          </div>
          <div class="product-gallery__slide">
            <img src="/images/product_scroll_animation-img2.png" alt="Product Image 3"
                 class="product-gallery__image">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="handbag-gallery">
    <div class="handbag-gallery__container container">
      <div class="handbag2-gallery__slider swiper">
        <h1 class="handBag_title">Носи с чем хочешь</h1>
        <div class="handbag-gallery__wrapper swiper-wrapper">
          <div class="handbag-gallery__slide swiper-slide">
            <a href="#" class="handbag-gallery__card">
              <div class="handbag-gallery__image product">
                <img src="/images/handbag1.png" alt="">
              </div>
              <a href="#" class="handbag-gallery__username">@nikname_inst</a>
            </a>
          </div>

          <div class="handbag-gallery__slide swiper-slide">
            <a href="#" class="handbag-gallery__card">
              <div class="handbag-gallery__image">
                <img src="/images/handbag2.png" alt="">
              </div>
              <a href="#" class="handbag-gallery__username">@nikname_inst</a>
            </a>
          </div>

          <div class="handbag-gallery__slide swiper-slide">
            <a href="#" class="handbag-gallery__card">
              <div class="handbag-gallery__image">
                <img src="/images/handbag3.png" alt="">
              </div>
              <a href="#" class="handbag-gallery__username">@nikname_inst</a>
            </a>
          </div>

          <div class="handbag-gallery__slide swiper-slide">
            <a href="#" class="handbag-gallery__card">
              <div class="handbag-gallery__image">
                <img src="/images/handbag4.png" alt="">
              </div>
              <a href="#" class="handbag-gallery__username">@nikname_inst</a>
            </a>
          </div>
        </div>
      </div>


    </div>
  </section>

  <section class="collection-section">
    <div class="container">
      <h2 class="section-title2">НАзвание модели</h2>

      <div class="products-grid">

        <!-- Product 1 -->

        {{-- @dd($new_products) --}}
        @if($new_products->isNotEmpty())
        @foreach($new_products as $product)

        <div class="product-card">
          <a href="{{ route('product.show', [
              'category'    => $product->category->slug,
              'subcategory' => $product->subcategory->slug,
              'product'     => $product->slug,
          ]) }}" class="product-image">

            <img src="{{ $product->getFirstMediaUrl('preview_image')}}" alt="{{ $product->name }}">
          </a>

          @php
              $isActive = false;

              if(auth('frontend')->check()) {
                  // Login bo'lgan foydalanuvchi uchun bazadan tekshir
                  $isActive = \App\Models\WishlistItem::where('frontend_user_id', auth('frontend')->id())
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

          <!-- isНОВОЕ icon -->
          @if ($product->is_new_collection == 1)
         
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
              <div class="old-product-price">{{ number_format($product->old_price, 0, ',', ' ') }} ₽</div>
              <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
            </div>

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
              
          </div>
        </div>

         @endforeach
        @endif

      </div>
    </div>
  </section>

  <x-footer/>

  <script>

    // const handbagSwiper = new Swiper('.handbag2-gallery__slider', {
    //   slidesPerView: 3.2,
    //   spaceBetween: 4,
    //   loop: true,
    //   autoplay: {
    //     delay: 0,
    //     disableOnInteraction: false,
    //     pauseOnMouseEnter: false,
    //     reverseDirection: false
    //   },
    //   speed: 4500,
    //   freeMode: false,
    //   slidesPerGroup: 1,
    //   effect: 'slide',
    //   breakpoints: {
    //     320: {
    //       slidesPerView: 1.3,
    //       spaceBetween: 4
    //     },
    //     480: {
    //       slidesPerView: 2.2,
    //       spaceBetween: 4
    //     },
    //     768: {
    //       slidesPerView: 3.2,
    //       spaceBetween: 4
    //     }
    //   },
    //   on: {
    //     init: function() {
    //       this.wrapperEl.style.transitionTimingFunction = 'linear';
    //     }
    //   }
    // });

    // setInterval(() => {
    //   if (handbagSwiper.autoplay && !handbagSwiper.autoplay.running) {
    //     handbagSwiper.autoplay.start();
    //   }
    // }, 1000);
  
  </script>
@endsection
