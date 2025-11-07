$(document).ready(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });

    // Logout

    $('#logoutLink').on('click', function(e){
        e.preventDefault();
        $.post('/auth/ajax/logout', {})
            .done(function(resp){
            if (resp?.redirect) {
                window.location.href = resp.redirect;
            } else {
                location.reload();
            }
            })
            .fail(function(xhr){
            alert(xhr.responseJSON?.message || 'Ошибка при выходе');
            });
    });

    // Wishlist

    function toggleHeart(el) {
        if (!el) return;
        const $el = $(el);
        const pid = $el.data('product-id');
        if (!pid) return;

        // agar login bo'lsa -> /wishlist/toggle ; aks holda -> /wishlist/guest/toggle
        const isAuth = window.APP_IS_AUTH === true; // blade orqali o'rnatamiz
        const url = isAuth ? '/wishlist/toggle' : '/wishlist/guest/toggle';

        // optimistic UI
        $el.toggleClass('active');

        $.post(url, { product_id: pid })
        .done(function(resp) {
            if (resp && resp.ok) {
            $el.toggleClass('active', !!resp.active);
            } else {
            $el.toggleClass('active'); // revert
            alert(resp?.message || 'Ошибка');
            }
        })
        .fail(function(xhr) {
            $el.toggleClass('active'); // revert
            if (xhr.status === 401) {
            // mehmonni home ga yuborish yoki modal ochish
            window.location.href = '/'; // agar xohlasangiz
            // if (typeof openLoginModal === 'function') openLoginModal();
            // else alert('Iltimos, tizimga kiring.');
            } else {
            alert(xhr.responseJSON?.message || 'Ошибка');
            }
        });
    }

    // Korzinka add

    function addToCart(productId, color, size, material, qty) {
        const isAuth = window.APP_IS_AUTH === true || window.APP_IS_AUTH === 'true';
        const url = isAuth ? '/cart/add' : '/cart/guest/add';
        
        return $.post(url, { product_id: productId, color, size, material, qty })
        .done(function(resp){
            if (resp?.ok && typeof resp.count !== 'undefined') {
                $('.cart-count').text(resp.count);
            }
        })
        .fail(function(xhr){
            alert(xhr.responseJSON?.message || 'Xatolik');
        });
    }

    // Misol: “Savatga qo‘shish” tugmasi
    $(document).on('click', '.btn-add-cart', function(e){
        e.preventDefault();
        
        const $card = $('#product_card');
        const pid = $(this).data('product-id');

        // Sizning UI’ingizga mos nomlar:
        const color    = $card.find('input[name="color"]').val() || null;
        const size     = $card.find('input[name="size"]').val() || null;
        const material = $card.find('input[name="material"]').val() || null;
        // const qty      = parseInt($card.find('input[name="qty"]').val() || '1', 10);
        const qty      = 1;

        console.log(pid, color, size, material, qty);

        addToCart(pid, color, size, material, qty);
    });
});