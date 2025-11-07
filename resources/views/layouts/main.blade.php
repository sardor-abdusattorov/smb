<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-head/>
<body>
    <!-- WRAPPER -->
    <div class="wrapper {{ $wrapperClass ?? '' }}">
      @yield('content')
    </div>

    <!-- modal -->
    <div class="profile-modal" id="cartax">
      <div class="modal_content">
        <span class="exit"><img src="/images/close.svg" alt=""></span>
        <div class="modal_title">Все о картах</div>
        <div class="modal_content_info">

          <div class="bonus_section">
            <h2 class="bonus_section__title">ИНФО ЗАГОЛОВОК</h2>
            <ul class="list_bullets">
              <li>Оплатить бонусами можно до 50% от стоимости покупки</li>
              <li>Бонусы от покупки можно списать спустя 19 дней после покупки на сайте</li>
              <li>1000 приветственных бонусов за регистрацию начисляются через 7 дней</li>
              <li>Списание бонусов недоступно для товаров категории UNDERWEAR и ART</li>
            </ul>
          </div>

          <div class="bonus_section">
            <h2 class="bonus_section__title">ИНФО ЗАГОЛОВОК</h2>
            <ul class="list_bullets">
              <li>6 месяцев с момента покупки. Далее бонусы сгорают. Приветственные 1000 бонусов действуют
              </li>
              <li>3 месяца с момента начисления. Далее бонусы сгорают</li>
              <li>При возврате товара бонусы, начисленные за покупку, списываются</li>
            </ul>
          </div>

          <div class="bonus_section">
            <h2 class="bonus_section__title">УРОВНИ НАКОПЛЕНИЯ КЭШБЕКА</h2>
            <p class="text_16">
              Сумма накапливается за всю историю покупок, начиная с момента регистрации в программе
              лояльности.
            </p>
            <p class="text_16">3 уровня:</p>
            <ul class="list_bullets">
              <li>«QUEEN» (от 15 000 руб до 49 999 руб) – 3% кэшбэк от суммы покупки</li>
              <li>«FASHIONABLE QUEEN» (от 50 000 руб до 99 999 руб) – 5% кэшбэк</li>
              <li>«EXTREMELY SEXY FASHIONABLE QUEEN» (от 100 000 руб) – 10% кэшбэк</li>
            </ul>
          </div>

        </div>
      </div>
    </div>

    <div class="profile-modal" id="politic">
      <div class="modal_content">
        <span class="exit"><img src="/images/close.svg" alt=""></span>
        <div class="modal_title">Как получить бонусы</div>
        <div class="modal_content_info">
          <div class="bonus_section">
            <h2 class="bonus_section__title">ПРИНЦИП РАБОТЫ ПРОГРАММЫ</h2>
            <p class="text_16">
              Бонусная программа представляет собой систему накопления баллов, которые начисляются за покупки.
              После совершения покупки бонусы зачисляются автоматически через 14 дней и автоматически
              становятся доступными на счету. Каждый накопленный балл эквивалентен сумме рубля и может быть
              использован для оплаты до 30% от стоимости товаров и услуг.
            </p>
          </div>

          <div class="bonus_section">
            <h3 class="bonus_section__subtitle">СТАРТОВЫЕ БОНУСЫ</h3>
            <p class="text_16">
              Регистрируясь в программе при покупке выше 1000 рублей, пользователь получает стартовые бонусы.
              Также бонусы начисляются при создании учетной записи или оформлении карты участника. Важно
              отметить, что условием начисления может быть подтверждение номера телефона.
            </p>
          </div>

          <div class="bonus_section">
            <h3 class="bonus_section__subtitle">НАЧИСЛЕНИЕ БОНУСОВ</h3>
            <p class="text_16">
              Первые покупки приносят 5% бонусов от потраченной суммы. Все прочие покупки начисляются в
              соответствии с уровнем пользователя.
            </p>
          </div>

          <div class="bonus_section">
            <h3 class="bonus_section__subtitle">СИСТЕМА УРОВНЕЙ</h3>
            <p class="text_16">
              Накопительная программа включает три уровня привилегий:
            </p>
            <ul class="list_bullets">
              <li>Базовый уровень (до 24 999 рублей) — 5% бонусов;</li>
              <li>Серебряный уровень (25 000 — 99 999 рублей) — 7% бонусов;</li>
              <li>Золотой уровень (от 100 000 рублей и выше) — 10% бонусов.</li>
            </ul>
          </div>

          <div class="bonus_section">
            <h3 class="bonus_section__subtitle">ПРАВИЛА ИСПОЛЬЗОВАНИЯ</h3>
            <p class="text_16">
              Применение бонусов возможно для оплаты до 30% от стоимости покупки, за исключением акционных
              товаров, персонализированных сертификатов и подарочных карт.
              Бонусы не подлежат обмену на наличные средства и не начисляются за доставку.
            </p>
          </div>

          <div class="bonus_section">
            <h3 class="bonus_section__subtitle">ПРОВЕРКА БАЛАНСА</h3>
            <p class="text_16">
              Отследить баланс бонусов можно через личный кабинет: "Просмотр операций начислений/списаний", а
              также в чеке после покупки.
            </p>
          </div>

          <div class="bonus_section">
            <h3 class="bonus_section__subtitle">ЧТО ТАКОЕ БОНУСНАЯ СИСТЕМА</h3>
            <p class="text_16">
              Бонусная система — это удобный способ накопления вознаграждений за покупки. Накопленные баллы
              действуют 14 дней с момента начисления, далее могут быть потрачены на следующие покупки.
            </p>
          </div>

          <div class="bonus_section">
            <h3 class="bonus_section__subtitle">ПРИВЕТСТВЕННЫЕ НАКОПИТЕЛЬНЫЕ БАЛЛЫ</h3>
            <p class="text_16">
              При регистрации на сайте или в момент завершения первой покупки вы можете получить
              приветственные бонусы, которые будут доступны в разделе "Мои бонусы".
            </p>
          </div>

          <div class="bonus_section">
            <h3 class="bonus_section__subtitle">БОНУСЫ ЗА ПЕРВУЮ ПОКУПКУ</h3>
            <p class="text_16">
              При первой покупке начисляется фиксированный процент бонусов — обычно 5% от суммы покупки. Этот
              процент может быть временно увеличен в акциях.
            </p>
          </div>

          <div class="bonus_section">
            <h3 class="bonus_section__subtitle">УРОВНИ БОНУСОВ</h3>
            <p class="text_16">
              Участник программы может переходить между уровнями в зависимости от общей суммы покупок за год.
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="profile-modal" id="login">
      <div class="modal_content">
        <div class="step step_phone ">
          <span class="exit"><img src="/images/close.svg" alt=""></span>
          <div class="modal_title">Войти или зарегистрироваться</div>
          <div class="modal_subtitle">Позвоним или пришлём SMS. Введи последние четыре цифры номера телефона или
            код
            из SMS-сообщения</div>

          <form class="modal_form">
            <label class="modal_input">
              <span class="modal_input-title">номер телефона*</span>
              <input type="tel" id="phone" placeholder="+7 (___) ___-__-__" />
            </label>
            <label class="form_bottom">
                        <span class="custom_checkbox">
                            <input type="checkbox" class="custom_checkbox_input" />
                        </span>
            </label>
            <label class="form_bottom">
                        <span class="custom_checkbox">
                            <input type="checkbox" class="custom_checkbox_input" />
                            <span class="custom_checkbox_box"></span>
                        </span>
              <p>Нажимая «Получить код», я принимаю условия Пользовательского соглашения и даю <a
                  href="#">Согласие на обработку персональных данных </a> в соответствии с <a
                  href="#">Политикой конфиденциальности</a></p>
            </label>
            <div class="form_buttons">
              <button class="button btn_phone_next" disabled>получить код</button>
              <a href="#" class="button modal_link">войти по электронной почте</a>
            </div>
            <span class="modal_bottom_text">
                        Впервые с нами? <a href="#" class="modal_register">Зарегистрироваться</a>
                    </span>
          </form>
        </div>

        <!-- Step 2: SMS -->
        <div class="step step_sms hide">
          <span class="exit"><img src="/images/close.svg" alt=""></span>
          <div class="modal_title">номер получателя +7 (199) 999-99-99</div>
          <div class="modal_subtitle">Введите последние четыре цифры
            номера телефона или код из SMS-сообщения.</div>
          <div class="sms_inputs">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
          </div>
          <div class="form_buttons">
            <button class="button btn_sms_wrong">Отправить код повтороно</button>
            <a href="#" class="button modal_link btn_back_phone">назад</a>
          </div>
        </div>

        <!-- Step 3: Email -->
        <div class="step step_email hide">
          <span class="exit"><img src="/images/close.svg" alt=""></span>
          <div class="modal_title">Войти в личный кабинет</div>
          
          <form class="modal_form" id="loginFormEmail" data-url="/auth/ajax/login">
            <div class="alert_errors"></div>
            <label class="modal_input">
              <span class="modal_input-title">Email*</span>
              <input type="email" id="email" name="email" placeholder="you@example.com" required />
            </label>
            <label class="modal_input">
              <span class="modal_input-title">пароль*</span>
              <input type="password" id="passowrd" name="password" placeholder="Введите пароль" required />
              <span class="eye ">
                            <img src="/images/eye.svg" alt="" class=" ">
                        </span>

            </label>
            <div class="modal_inputs">
              <label class="form_bottom">
                            <span class="custom_checkbox">
                                <input type="checkbox" class="custom_checkbox_input" name="remember_me" />
                                <span class="custom_checkbox_box"></span>
                            </span>
                <p>Запомнить пароль</p>
              </label>
              <a href="#" class="modal_link">Забыли пароль?</a>
            </div>
            <div class="form_buttons">
              <button class="button" type="submit" disabled>Войти в личный кабинет</button>
              <a href="#" class="button modal_link btn_back_email">войти по номеру телефона</a>
            </div>

          </form>
          <span class="modal_bottom_text">
                    Впервые с нами? <a href="#" class="modal_register">Зарегистрироваться</a>
                </span>
        </div>

        <!-- Step 4: Error -->
        <div class="step step_error hide">

          <div class="modal_title">Если хочешь идти, иди...</div>
          <div class="modal_subtitle">Но знай, что мы уже скучаем</div>
          <div class="form_buttons">
            <button class="button btn_back_error">Остаться</button>
            <a href="#" class="button modal_link">уйти</a>
          </div>
        </div>

      </div>
    </div>

    <div class="profile-modal" id="registerModal">
      <div class="modal_content">
        <span class="exit"><img src="/images/close.svg" alt=""></span>
        <div class="modal_title">Зарегистрироваться</div>
        <div class="modal_subtitle">
          Позвоним или пришлём SMS. Введи последние четыре цифры номера телефона или код из SMS-сообщения
        </div>

        <!-- Error box -->
        

        <form class="modal_form" id="registerForm" data-url="/auth/ajax/register">

          <div class="alert_errors"></div>

          <label class="modal_input">
            <span class="modal_input-title">Имя*</span>
            <input type="text" placeholder="Ввести имя" name="name" required />
          </label>

          <label class="modal_input">
            <span class="modal_input-title">Фамилия*</span>
            <input type="text" placeholder="Ввести фамилию" name="lastname" required />
          </label>

          <label class="modal_input">
            <span class="modal_input-title">Отчество</span>
            <!-- patronymic uchun alohida name -->
            <input type="text" placeholder="Ввести отчество" name="middlename" />
          </label>

          <label class="modal_input">
            <span class="modal_input-title">E-mail*</span>
            <input type="email" placeholder="Ввести e-mail" name="email" required />
          </label>

          <label class="modal_input">
            <span class="modal_input-title">Номер телефона*</span>
            <input type="tel" placeholder="+998901234567" name="phone" required />
          </label>

          <label class="modal_input">
            <span class="modal_input-title">Пароль*</span>
            <!-- type="password" va name="password" -->
            <input type="password" placeholder="Придумай пароль" name="password" required minlength="6" />
            <span class="eye"><img src="/images/eye.svg" alt=""></span>
          </label>

          <label class="modal_input">
            <span class="modal_input-title">Подтвердите пароль*</span>
            <!-- type="password" va name="password_confirmation" -->
            <input type="password" placeholder="Введи пароль еще раз" name="password_confirmation" required minlength="6" />
            <span class="eye"><img src="/images/eye.svg" alt=""></span>
          </label>

          <label class="form_bottom">
            <span class="custom_checkbox">
              <input type="checkbox" class="custom_checkbox_input" name="marketing_optin" />
              <span class="custom_checkbox_box"></span>
            </span>
            <p>Я согласен(-на) на получение рекламно-информационной рассылки</p>
          </label>

          <label class="form_bottom">
            <span class="custom_checkbox">
              <!-- Bu shartli chek: rozilik bo‘lmasa yuborilmaydi -->
              <input type="checkbox" class="custom_checkbox_input" name="terms" required />
              <span class="custom_checkbox_box"></span>
            </span>
            <p>Я согласен(-на) с
              <a href="https://864109.selcdn.ru/irnby.com/DOCUMENTS/%D0%9F%D0%BE%D0%BB%D0%B8%D1%82%D0%B8%D0%BA%D0%B0%20%D0%BA%D0%BE%D0%BD%D1%84%D0%B8%D0%B4%D0%B5%D0%BD%D1%86%D0%B8%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D1%81%D1%82%D0%B8%20IRNBY.pdf" target="_blank" rel="noopener">политикой конфиденциальности</a> и договором оферты
            </p>
          </label>

          <div class="form_buttons">
            <button type="submit" class="button regstr_btn " disabled>Зарегистрироваться</button>
          </div>

          <span class="modal_bottom_text">
            Вы уже с нами? <a href="#login" class="modal_login">Авторизоваться</a>
          </span>
        </form>
      </div>
    </div>

    <div class="smb-modal-overlay" id="smbModalOverlay">
      <div class="smb-modal">
        <button class="smb-modal-close" id="smbModalClose"><svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                                height="14" viewBox="0 0 14 14" fill="none">
            <path
              d="M1.39916 13.3108L0.691406 12.6031L6.29141 7.00306L0.691406 1.40306L1.39916 0.695312L6.99916 6.29531L12.5992 0.695312L13.3069 1.40306L7.70691 7.00306L13.3069 12.6031L12.5992 13.3108L6.99916 7.71081L1.39916 13.3108Z"
              fill="#1C1B1F" />
          </svg></button>
        <div class="smb-modal-content">
          <h2 class="smb-modal-title">СЕКРЕТНЫЕ СКИДКИ, ЕЖЕНЕДЕЛЬНЫЕ <br> НОВОСТИ, ПИСЬМА ОТ ОСНОВАТЕЛЯ БРЕНДА
          </h2>
          <form id="smbSubscribeForm">
            <div class="smb-form-group">
              <label for="smbEmail">E-MAIL*</label>
              <input type="email" id="smbEmail" name="email" placeholder="Введите e-mail" required>
            </div>
            <div class="smb-checkbox-group">
              <div class="smb-checkbox-item">
                <input type="checkbox" id="smbPrivacy" name="privacy" required>
                <label for="smbPrivacy" class="input_label">Я согласен(-на) с <a href="#">Политикой
                    конфиденциальности</a></label>
              </div>
              <div class="smb-checkbox-item">
                <input type="checkbox" id="smbNewsletter" name="newsletter">
                <label for="smbNewsletter" class="input_label">Я согласен(-на) на получение
                  информационной
                  <br> рассылки</label>
              </div>
            </div>
            <button type="submit" class="smb-submit-btn">ПОДПИСАТЬСЯ</button>
          </form>
        </div>
      </div>
    </div>

    <div class="smb-modal-overlay smb-success-modal" id="smbSuccessModal">
      <div class="smb-modal">
        <button class="smb-modal-close" id="smbSuccessModalClose"><svg xmlns="http://www.w3.org/2000/svg"
                                                                       width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path
              d="M1.39916 13.3108L0.691406 12.6031L6.29141 7.00306L0.691406 1.40306L1.39916 0.695312L6.99916 6.29531L12.5992 0.695312L13.3069 1.40306L7.70691 7.00306L13.3069 12.6031L12.5992 13.3108L6.99916 7.71081L1.39916 13.3108Z"
              fill="#1C1B1F" />
          </svg>
        </button>
        <button class="smb-ok-btn" id="smbOkBtn">ОК</button>
        <div class="smb-modal-content">
          <h2 class="smb-success-title">ПОДПИСКА ОФОРМЛЕНА</h2>
          <p class="smb-success-message">Ты с нами – и это классно</p>
        </div>
      </div>
    </div>

    <div class="cookie-popup show" id="cookiePopup">
      <div class="cookie-content">
        <div class="cookie-text">
          <p>На этом веб-сайте используются файлы cookie и аналогичные технологии <br> в соответствии с
            условиями
            <a href="#">Политики использования cookie</a>
          </p>
        </div>
        <div class="cookie-actions">
          <button class="btn-decline">ОТКЛОНИТЬ ВСЕ</button>
          <button class="btn-accept">ПРИНЯТЬ</button>

        </div>
      </div>
    </div>

    <div class="popup-overlay" id="popupOverlay"></div>

    @php
      $cartCount = 0;
      if (auth('web')->check()) {
          $cartCount = \App\Models\CartItem::where('frontend_user_id', auth('web')->id())->sum('quantity');
      } else {
          $c = session('guest_cart');
          $cartCount = $c ? array_sum($c['items'] ?? []) : 0;
      }
    @endphp

    <div class="buyer_modal">
      <!-- Cart Modal -->
      <div class="cart-modal-overlay" id="cartModal">
        <div class="cart-modal {{ $cartCount == 0 ? 'empty' : '' }}">
          <!-- Header -->
          @if ($cartCount !== 0)
          
            <div class="cart-header">
              <div class="cart-title">
                МОЯ КОРЗИНА <span class="cart-count">({{ $cartCount }})</span>
              </div>
              <button class="close-cart" onclick="closeCartModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                  <mask id="mask0_687_58555" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                        y="0" width="24" height="24">
                    <rect width="24" height="24" fill="#D9D9D9" />
                  </mask>
                  <g mask="url(#mask0_687_58555)">
                    <path
                      d="M6.39916 18.3108L5.69141 17.6031L11.2914 12.0031L5.69141 6.40306L6.39916 5.69531L11.9992 11.2953L17.5992 5.69531L18.3069 6.40306L12.7069 12.0031L18.3069 17.6031L17.5992 18.3108L11.9992 12.7108L6.39916 18.3108Z"
                      fill="#1C1B1F" />
                  </g>
                </svg>

              </button>
            </div>
 
            <!-- Content with items -->
            <div class="cart-content" id="cartContent">

              <!-- Cart Item 1 -->
              <div class="cart-item">

                <div class="item-favorite">
                  <svg viewBox="0 0 24 24" onclick="heart_icon(this)">
                    <path
                      d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                  </svg>
                </div>

                <div class="item-image">
                  <img src="/images/karzinka-modal_img.png" alt="Кожаная сумка">
                </div>
                <div class="item-details">
                  <div class="item-name">НАЗВАНИЕ ТОВАРА (x2)</div>
                  <div class="item-specs">
                    <div class="item-spec">Цвет: Коричневый</div>
                    <div class="item-spec">Материал: Кожа</div>
                    <div class="item-spec">Размер: 36x25x18 (М)</div>
                    <div class="item-price">
                      <div class="item-price-old">29 900 ₽</div>
                      <div class="item-price-current">20 400 ₽</div>
                    </div>
                  </div>
                  <div class="item-bottom">
                    <button class="item-remove">УДАЛИТЬ</button>

                  </div>
                </div>
              </div>

            </div>

            <!-- Footer -->
            <div class="cart-footer">
              <div class="cart-total">
                <div class="cart-total-label">ИТОГО</div>
                <div class="cart-total-price">40 800 ₽</div>
              </div>
              <div class="cart-actions">
                <button class="cart-btn cart-btn-secondary">ПРОДОЛЖИТЬ ПОКУПКИ</button>
                <button class="cart-btn cart-btn-primary">КУПИТЬ</button>
              </div>
            </div>

          @else

            <!-- Empty cart state (hidden by default) -->
            <div class="empty-cart show" id="emptyCart">
              <div class="empty-cart-title">КОРЗИНА ПУСТА</div>
              <div class="empty-cart-text">
                Пора добавить немного стиля.<br>
                Подберем классную сумку?
              </div>
              <a href="{{ route('catalog') }}" class="empty-cart-btn">В КАТАЛОГ</a>
            </div>

          @endif

        </div>
      </div>
    </div>

    <script src="{{ asset('assets/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/moment-timezone-with-data.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } });

         window.APP_IS_AUTH = {!! auth('frontend')->check() ? 'true' : 'false' !!};

        $(function(){
          const $registerForm = $('#registerForm');
          if (!$registerForm.length) return;

          const $registrbtn = $registerForm.find('button[type="submit"]');
          const $errorBox = $registerForm.find('.alert_errors');

          // Faqat zarur inputlar (middlename'ni hisobga olmaymiz)
          const $inputs = $registerForm.find('input[name="name"], input[name="lastname"], input[name="email"], input[name="phone"], input[name="password"], input[name="password_confirmation"]');
          const $marketing = $registerForm.find('input[name="marketing_optin"]');
          const $terms = $registerForm.find('input[name="terms"]');

          function validate() {
            let filled = true;
            $inputs.each(function(){
              if ($(this).val().trim() === '') {
                filled = false;
                return false;
              }
            });

            const checkboxesOK = $marketing.is(':checked') && $terms.is(':checked');
            const ok = filled && checkboxesOK;

            $registrbtn.prop('disabled', !ok);
          }

          // Hodisalar (input, change)
          $inputs.on('input change', validate);
          $marketing.on('change', validate);
          $terms.on('change', validate);

          // Sahifa yuklanganda tekshirish
          validate();

          // Forma yuborish
          $registerForm.off('submit').on('submit', function(e){
            e.preventDefault();
            $errorBox.hide().empty();
            $registrbtn.prop('disabled', true).text('Отправляем...');

            $.ajax({
              url: $registerForm.data('url'),
              method: 'POST',
              data: $registerForm.serialize(),
              success: function(resp){
                if (resp && resp.ok) {
                  window.location.href = resp.redirect || '/profile';
                } else {
                  $errorBox.text(resp?.message || 'Ошибка регистрации').show();
                }
              },
              error: function(xhr){
                let msg = xhr.responseJSON?.message || 'Ошибка регистрации';
                $errorBox.text(msg).show();
              },
              complete: function(){
                $registrbtn.text('Зарегистрироваться');
                validate(); // qayta tekshirish
              }
            });
          });
        });
        
        $(function(){
          const loginForm = $('#loginFormEmail');
          if (!loginForm.length) return;

          const $email = loginForm.find('input[name="email"]');
          const $password = loginForm.find('input[name="password"]');
          const $btn = loginForm.find('button[type="submit"]');
          const $errorBox = loginForm.find('.alert_errors');

          // Parol ko'rish/berkitish (ixtiyoriy)
          // $form.on('click', '.eye', function () {
          //   const $inp = $password;
          //   $inp.attr('type', $inp.attr('type') === 'password' ? 'text' : 'password');
          // });

          function enableBtn()  { $btn.prop('disabled', false).removeAttr('disabled'); }
          function disableBtn() { $btn.prop('disabled', true).attr('disabled', 'disabled'); }

          // Tugmani faollashtirish: email va parol to'lgan bo'lsa
          function validate() {
            const ok = $email.val().trim() !== '' && $password.val().trim() !== '';
            if (ok) enableBtn(); else disableBtn();
          }

          

          // Hamma hodisalarga ulaymiz (autofill, paste, va h.k.)
          $email.on('input change keyup paste', function(e){
            validate();
          });
          $password.on('input change keyup paste', function(e){
            validate();
          });

          validate(); // initial

           // Brauzer autofill kechikib kelishi uchun yana tekshiramiz
          setTimeout(validate, 150);
          setTimeout(validate, 600);


          // Xato chiqarish helper
          function showError(msg) {
            $errorBox.text(msg).show();
          }
          function hideError() {
            $errorBox.hide().empty();
          }

          // Bir marta bog'lash uchun .off().on()
          loginForm.off('submit').on('submit', function (e) {
            e.preventDefault();
            hideError();

            $btn.prop('disabled', true).text('Проверяем...');

            $.ajax({
              url: loginForm.data('url'),
              method: 'POST',
              data: loginForm.serialize(),
              success: function (resp) {
                if (resp && resp.ok) {
                  window.location.href = resp.redirect || '/profile';
                } else {
                  showError((resp && resp.message) ? resp.message : 'Ошибка входа');
                }
              },
              error: function (xhr) {
                // MUHIM: bu yerda "response" degan o'zgaruvchi yo'q. xhr'dan o'qiymiz.
                let msg = 'Ошибка входа';
                if (xhr.status === 401) {
                  msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Неверный email или пароль';
                } else if (xhr.status === 429) {
                  msg = 'Слишком много попыток. Попробуйте позже.';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                  msg = xhr.responseJSON.message;
                }
                showError(msg);
              },
              complete: function () {
                $btn.prop('disabled', false).text('Войти в личный кабинет');
              }
            });
          });
       });
    </script>
</body>
</html>

