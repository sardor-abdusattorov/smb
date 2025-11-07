@php
    use App\Models\WishlistItem;

    $hasWishlist = false;
    if (auth('web')->check()) {
        $hasWishlist = WishlistItem::where('frontend_user_id', auth('web')->id())->exists();
    }
@endphp
@extends('layouts.main', ['wrapperClass' => 'catalog'])

@section('title', 'Каталог')

@section('content')

  <x-marquee />

  <x-header />

       <section class="profile">
            <aside class="profile__sidebar">
                <div class="profile__user">
                    <div class="profile__avatar">SMB</div>
                    <div class="profile__info">
                        <p class="profile__hello">Привет! Рады встрече</p>
                        <p class="profile__bonus">Твои бонусы: <span>150</span></p>
                    </div>
                </div>
                <ul class="profile__menu">
                    <li><a href="#"  data-target="#profile__content1">Заказы</a></li>
                    <li>
                        <a href="{{ $hasWishlist ? route('favourites') : '#!' }}"
                            class="action-btn wishlist-btn d-none d-lg-block {{ $hasWishlist ? 'active' : '' }}"
                        @unless($hasWishlist) onclick="return false" @endunless>
                        </a>
                    </li>
                    <li><a href="#" data-target="#profile__content3">Бонусы</a></li>
                    <li><a href="#" data-target="#profile__content4">Подарочные карты</a></li>
                    <li><a href="#" class="active" data-target="#profile__content5">Контактная информация</a></li>
                    <li><a href="#" data-target="#profile__content6">Пароль и безопасность</a></li>
                    <li class="logout"><a href="#" id="logoutLink">Выйти</a></li>

                </ul>
            </aside>
            <div class="profile__content-wrapper">
                <div class="sidebar_open  align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <mask id="mask0_870_59121" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                            width="16" height="16">
                            <rect x="16" y="16" width="16" height="16" transform="rotate(-180 16 16)" fill="#D9D9D9" />
                        </mask>
                        <g mask="url(#mask0_870_59121)">
                            <path
                                d="M10.6554 1.56583L11.6016 2.512L6.1119 8.00167L11.6016 13.4913L10.6554 14.4375L4.21956 8.00167L10.6554 1.56583Z"
                                fill="#272727" />
                        </g>
                    </svg>
                    <span>назад</span>
                </div>

                <div class="profile__content orders_tab" id="profile__content1">
                    <div class="orders">
                        <div class="orders__tabs">
                            <button class="orders__tab active" data-tab="active">АКТИВНЫЕ ЗАКАЗЫ</button>
                            <button class="orders__tab" data-tab="history">ИСТОРИЯ ЗАКАЗОВ</button>
                        </div>

                        <div class="orders__content active" id="active">
                            <div class="orders__list justify-content-start" style="gap: 4px;">
                                <div class="order-card">
                                    <div class="order_card_top">

                                        <span class="order-card__status active">Готовится к отправке</span>

                                        <!-- Swiper -->
                                        <div class="swiper order-card__slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag4.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <p class="order-card__id">№ 123456</p>
                                    <p class="order-card__desc">BLANCA, MOSS</p>
                                    <p class="order-card__price opacity">85 800 ₽</p>
                                </div>
                                <div class="order-card">
                                    <div class="order_card_top">

                                        <span class="order-card__status active">Готовится к отправке</span>

                                        <!-- Swiper -->
                                        <div class="swiper order-card__slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag4.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>


                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <p class="order-card__id">№ 123456</p>
                                    <p class="order-card__desc">MOSS</p>
                                    <p class="order-card__price opacity">20 400 ₽</p>
                                </div>

                            </div>
                            <div class="order_banner">
                                <img src="/images/order_banner.png" alt="">
                                <div class="order_info">
                                    <p class="order_info_title">Бонусы</p>
                                    <p class="order_info_text">Твои бонусы: <span>150</span></p>
                                    <a href="#" class="button">Перейти в каталог</a>
                                </div>
                            </div>
                        </div>
                        <div class="orders__content " id="history">
                            <div class="orders__list">
                                <div class="order-card">
                                    <div class="order_card_top">

                                        <span class="order-card__status">Завершен</span>

                                        <!-- Swiper -->
                                        <div class="swiper order-card__slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag4.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <p class="order-card__id">№ 123456</p>
                                    <p class="order-card__desc">BLANCA, MOSS</p>
                                    <p class="order-card__price">85 800 ₽</p>
                                </div>
                                <div class="order-card">
                                    <div class="order_card_top">

                                        <span class="order-card__status">Завершен</span>

                                        <!-- Swiper -->
                                        <div class="swiper order-card__slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag4.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>


                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <p class="order-card__id">№ 123456</p>
                                    <p class="order-card__desc">MOSS</p>
                                    <p class="order-card__price">20 400 ₽</p>
                                </div>
                                <div class="order-card">
                                    <div class="order_card_top">

                                        <span class="order-card__status">Завершен</span>

                                        <!-- Swiper -->
                                        <div class="swiper order-card__slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag4.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>


                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>

                                    <p class="order-card__id">№ 123456</p>
                                    <p class="order-card__desc">MOSS</p>
                                    <p class="order-card__price">20 400 ₽</p>
                                </div>
                                <div class="order-card">
                                    <div class="order_card_top">

                                        <span class="order-card__status">Завершен</span>

                                        <!-- Swiper -->
                                        <div class="swiper order-card__slider">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag4.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/section_bg-bag3.png" alt="bag"
                                                        class="order-card__img" />
                                                </div>


                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>

                                    <p class="order-card__id">№ 123456</p>
                                    <p class="order-card__desc">MOSS</p>
                                    <p class="order-card__price">20 400 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="profile__content" id="profile__content3">
                    <h3 class="section_title d-flex align-items-center">
                        <span>бонусы</span>
                    </h3>
                    <div class="profile__content_bonus">
                        <div class="bonus">
                            <div class="bonus_info">
                                <div class="bonus_info_top">
                                    <div class="bonus_title">
                                        твои бонусы
                                    </div>
                                    <span>1 500</span>
                                </div>
                                <span class="bonus_logo">SMB</span>
                            </div>
                            <img src="/images/bonus_img.png" alt="">
                        </div>
                        <div class="bonus_desc">
                            <p>Никаких ограничений. Оплачивай бонусами заказ полностью <br> или его часть.
                                Нам по кайфу делать твой шопинг еще более комфортным</p>
                            <p>1 бонус = 1 ₽ </p>
                            <p class="uppercase">Срок действия бонусов — 6 месяцев с момента начисления</p>
                            <p class="uppercase">Лови выгоду, пока не сгорела</p>
                            <a href="#" class="btn_politic">Условия программы лояльности</a>
                        </div>
                        <div class="history">
                            <h2 class="section_title">ИСТОРИЯ АКТИВНОСТИ</h2>
                            <div class="history_list">
                                <div class="history_item plus">
                                    <div class="history_info">
                                        <span class="history_points">
                                            <span class="history_points_number">+ 400 Б </span>
                                        </span>
                                        <span class="history_desc">Покупка в интернет-магазине</span>
                                        <span class="history_date">Срок действия до 16.06.2026</span>
                                    </div>
                                    <span class="history_time">16.06.2025</span>
                                </div>

                                <div class="history_item plus">
                                    <div class="history_info">
                                        <span class="history_points">+ 400 Б</span>
                                        <span class="history_desc">Покупка в интернет-магазине</span>
                                        <span class="history_date">Срок действия до 16.06.2026</span>
                                    </div>
                                    <span class="history_time">16.06.2025</span>
                                </div>

                                <div class="history_item plus">
                                    <div class="history_info">
                                        <span class="history_points">+ 400 Б</span>
                                        <span class="history_desc">Покупка в интернет-магазине</span>
                                        <span class="history_date">Срок действия до 16.06.2026</span>
                                    </div>
                                    <span class="history_time">16.06.2025</span>
                                </div>

                                <div class="history_item plus">
                                    <div class="history_info">
                                        <span class="history_points">+ 100 Б</span>
                                        <span class="history_desc">Покупка в интернет-магазине</span>
                                        <span class="history_date">Срок действия до 16.06.2026</span>
                                    </div>
                                    <span class="history_time">16.06.2025</span>
                                </div>

                                <div class="history_item minus">
                                    <div class="history_info">
                                        <span class="history_points">- 150 Б</span>
                                        <span class="history_desc">Списание бонусов</span>
                                    </div>
                                    <span class="history_time">12.06.2025</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="profile__content" id="profile__content4">
                    <h3 class="section_title d-flex align-items-center">
                        <span>бонусы</span>
                    </h3>
                    <div class="gift_content">
                        <section class="gift_cards_section">
                            <!-- Tugma -->
                            <button class="gift_cards_add_btn">Добавить карту по номеру</button>
                            <div class="gift_cards_form">
                                <label class="gift_card_new">NEW
                                    <input type="file">
                                </label>
                                <div class="gift_card_inputs">
                                    <div>
                                        <label for="card_number" class="card_number input_title">Номер карты*</label>
                                        <input type="text" id="card_number" placeholder="Введите номер карты">
                                    </div>
                                    <div class="gift_card_form_actions flex between">
                                        <button class="btn_cancel">Отменить</button>
                                        <button class="btn_add">Добавить карту</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Kartalar ro'yxati -->
                            <div class="gift_cards_list">
                                <div class="gift_card_item d-flex ">
                                    <div class="gift_card_img">
                                        <img src="/images/gift1.png" alt="Gift Card">
                                    </div>
                                    <div class="gift_card_info d-flex justify-content-between flex-column">
                                        <div>
                                            <p>Номер карты: <span>12345678903</span></p>
                                            <p>Срок действия: <span>12.12.2025</span></p>
                                        </div>
                                        <p>Остаток на карте: <span>10 000₽</span></p>
                                    </div>
                                </div>

                                <div class="gift_card_item d-flex ">
                                    <div class="gift_card_img">
                                        <img src="/images/gift1.png" alt="Gift Card">
                                    </div>
                                    <div class="gift_card_info d-flex justify-content-between flex-column">
                                        <div>
                                            <p>Номер карты: <span>12345678905</span></p>
                                            <p>Срок действия: <span>12.12.2025</span></p>
                                        </div>
                                        <p>Остаток на карте: <span>2 000₽</span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pastki menyu -->
                            <div class="gift_cards_footer flex between">
                                <a href="#" class="modal_cartax">Все о картах</a>
                                <a href="#">Купить подарочную карту</a>
                            </div>
                        </section>
                    </div>

                </div>

                <div class="profile__content" id="profile__content5">
                    <h3 class="section_title d-flex align-items-center">
                        <span>Контактные данные</span>
                    </h3>
                    <form class="profile__form">
                        <label class="form__row">
                            <span class="input_title">Имя*</span>
                            <input type="text" value="Ольга">
                        </label>
                        <label class="form__row">
                            <span class="input_title">Фамилия*</span>
                            <input type="text" value="Иванова">
                        </label>
                        <label class="form__row">
                            <span class="input_title">Отчество*</span>
                            <input type="text" placeholder="Введите данные">
                        </label>
                        <label class="form__row">
                            <span class="input_title">Дата рождения*</span>
                            <input type="text" placeholder="Введите данные">
                        </label>
                        <label class="form__row">
                            <span class="input_title">Телефон*</span>
                            <input type="text" value="+7 (199)000-00-00">
                        </label>
                        <label class="form__row">
                            <span class="input_title">E-mail*</span>
                            <input type="email" value="user12345@gmail.com">
                        </label>

                        <h3 class="section_title">Мой адрес</h3>
                        <label class="form__row w50">
                            <span class="input_title">Город*</span>
                            <input type="text" value="Москва">
                        </label>
                        <label class="form__row w50">
                            <span class="input_title">Адрес доставки*</span>
                            <input type="text" value="ул. Максима Горького">
                        </label>
                        <label class="form__row w20">
                            <span class="input_title">Индекс*</span>
                            <input type="text" value="234 567">
                        </label>
                        <label class="form__row w20">
                            <span class="input_title">Номер квартиры*</span>
                            <input type="text" value="34">
                        </label>
                        <label class="form__row w20">
                            <span class="input_title">Номер подъезда*</span>
                            <input type="text" placeholder="Введите данные">
                        </label>
                        <label class="form__row w20">
                            <span class="input_title">Этаж*</span>
                            <input type="text" placeholder="Введите данные">
                        </label>

                        <label class="form__checkbox">
                            <span class="custom_checkbox">
                                <input type="checkbox" class="custom_checkbox_input" name="checkbox" />
                                <span class="custom_checkbox_box"></span>
                            </span>
                            <p>
                                Нажимая «Получить код», я принимаю условия Пользовательского соглашения <br>
                                и даю <a href="#">Согласие на обработку персональных данных</a> в соответствии с <a
                                    href="#">Политикой <br> конфиденциальности</a>
                            </p>
                        </label>

                        <button type="submit" class="btn">Сохранить данные</button>
                    </form>
                </div>

                <div class="profile__content pasword_content" id="profile__content6">
                    <h3 class="section_title d-flex align-items-center">
                        <span>Изменить пароль</span>
                    </h3>
                    <p class="pasword_desc">Пароль может содержать только латинские буквы, символы и цифры</p>
                    <form class="profile__form">

                        <label class="modal_input form__row w50">
                            <span class="modal_input-title">текущий пароль*</span>
                            <input type="password" id="passowrd" placeholder="Введите пароль" required />
                            <span class="eye ">
                                <img src="/images/eye.svg" alt="" class=" ">
                            </span>
                        </label>
                        <label class="modal_input form__row w50">
                            <span class="modal_input-title">новый пароль*</span>
                            <input type="password" id="passowrd" placeholder="Придумать новый пароль" required />
                            <span class="eye ">
                                <img src="/images/eye.svg" alt="" class=" ">
                            </span>
                        </label>
                        <label class="modal_input form__row w50">
                            <span class="modal_input-title">повторите пароль*</span>
                            <input type="password" id="passowrd" placeholder="Повторить пароль" required />
                            <span class="eye ">
                                <img src="/images/eye.svg" alt="" class=" ">
                            </span>
                        </label>
                        <div class="btn_container">
                            <button type="submit" class="btn">Сохранить данные</button>
                            <button class="replace_password">пароль изменен</button>
                        </div>

                    </form>
                </div>
            </div>
        </section>

   <x-footer />

@endsection