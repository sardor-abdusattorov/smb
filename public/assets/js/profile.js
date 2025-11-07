

window.addEventListener("scroll", function () {
  const header = document.querySelector(".header");
  const mobileMenu = document.getElementById("mobileMenu");

  if (window.scrollY >= 10) {
    header.classList.add("header-top_active");
    mobileMenu.classList.add("header-top_active");
  } else {
    header.classList.remove("header-top_active");
    mobileMenu.classList.remove("header-top_active");
  }
});

// Initialize Swiper
let heroSwiper;

// DOM Content Loaded
document.addEventListener("DOMContentLoaded", function () {
  initializeSwiper();
  initCookiePopup();
});

const opening = document.querySelector(".opening");
const closing = document.querySelector(".closing");

opening.addEventListener("click", function () {
  opening.classList.remove("active");
  closing.classList.add("active");
});

closing.addEventListener("click", function () {
  closing.classList.remove("active");
  opening.classList.add("active");
});

// Mobile Menu Functions
function toggleMobileMenu() {
  const mobileMenu = document.getElementById("mobileMenu");
  const header = document.querySelector(".header");
  mobileMenu.classList.toggle("active");
  header.classList.toggle("active");

  // Prevent body scroll when menu is open
  document.body.style.overflow = mobileMenu.classList.contains("active")
    ? "hidden"
    : "";
}

// Toggle dropdown in mobile menu
function toggleDropdown(targetId) {
  const dropdown = document.getElementById(targetId);
  const button = document.querySelector(
    `[onclick="toggleDropdown('${targetId}')"]`
  );

  dropdown.classList.toggle("active");
  button.classList.toggle("active");
}
// Initialize Hero Swiper
function initializeSwiper() {
  heroSwiper = new Swiper(".heroSwiper", {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    speed: 800,
    effect: "slide",
  });
}

// -------------------- COOKIE -------------------- //
function initCookiePopup() {
  const cookiePopup = document.getElementById("cookiePopup");
  const acceptBtn = document.querySelector(".btn-accept");
  const declineBtn = document.querySelector(".btn-decline");

  // Agar qabul qilingan bo‘lsa – umuman chiqmasin
  if (localStorage.getItem("cookieAccepted") === "true") {
    if (cookiePopup) cookiePopup.remove();
    return;
  }

  // 2 soniyadan keyin popup chiqadi
  setTimeout(() => {
    if (cookiePopup) {
      cookiePopup.classList.add("show");
    }
  }, 2000);

  // Accept bosilganda
  if (acceptBtn) {
    acceptBtn.addEventListener("click", function () {
      localStorage.setItem("cookieAccepted", "true"); // saqlab qo‘yish
      closeCookie();
    });
  }

  // Decline bosilganda (shunchaki yopiladi)
  if (declineBtn) {
    declineBtn.addEventListener("click", function () {
      closeCookie();
    });
  }
}

function closeCookie() {
  const cookiePopup = document.getElementById("cookiePopup");
  if (cookiePopup) {
    cookiePopup.classList.remove("show");
  }
}
// ==================================================header end==============
// Kontentni ikki marta takrorlash uchun
// Kontentni ikki marta takrorlash uchun (seamless loop uchun)
const marqueeContent = document.getElementById("marquee-content");
const originalHTML = marqueeContent.innerHTML;
// Ikki marta takrorlash - birinchi set tugaganda ikkinchi set boshlanadi
marqueeContent.innerHTML = originalHTML + originalHTML;

// Agar kerak bo'lsa, heart toggle funksiyasi
// function toggleHeart(heartElement) {
//   heartElement.classList.toggle("active");
// }
// ================================== marquee-content end
document.addEventListener("DOMContentLoaded", function () {
  const handbagGallerySwiper = new Swiper(".handbag-gallery__slider", {
    slidesPerView: 3.5,
    spaceBetween: 15,
    loop: true,
    mousewheel: {
      forceToAxis: true,
    },
    breakpoints: {
      768: {
        slidesPerView: 3.5,
        spaceBetween: 15,
        loop: true,
      },
      320: {
        slidesPerView: 1.3,
        spaceBetween: 15,
        loop: true,
      },
    },
  });

  function updateSpacing() {
    const screenWidth = window.innerWidth;

    if (screenWidth < 768) {
      handbagGallerySwiper.params.spaceBetween = 8;
    } else {
      handbagGallerySwiper.params.spaceBetween = 4;
    }

    handbagGallerySwiper.update();
  }

  // birinchi yuklanganda chaqiriladi
  updateSpacing();

  // oyna o‘zgarsa ham chaqiriladi
  window.addEventListener("resize", updateSpacing);
});

const children = document.querySelectorAll(".handbag-gallery__card");

// 1-chi, 2-chi, 3-chi ga style-0, style-1, style-2
children.forEach((child, index) => {
  const styleIndex = index % 3; // 0,1,2,0,1,2...
  child.classList.add(`style-${styleIndex}`);
});

// =================================================
function initSMBNewsletter() {
  // Elementlarni tekshirish
  const subscribeBtn = document.getElementById("smbSubscribeBtn");
  const modalOverlay = document.getElementById("smbModalOverlay");
  const modalClose = document.getElementById("smbModalClose");
  const subscribeForm = document.getElementById("smbSubscribeForm");
  const successModal = document.getElementById("smbSuccessModal");
  const successModalClose = document.getElementById("smbSuccessModalClose");
  const okBtn = document.getElementById("smbOkBtn");

  // Agar elementlar mavjud bo'lmasa, funksiyani to'xtatish
  if (!subscribeBtn || !modalOverlay || !successModal) {
    return;
  }

  // Modal ochish
  subscribeBtn.addEventListener("click", function () {
    console.log("Subscribe button clicked"); // Debug uchun
    modalOverlay.classList.add("smb-modal-active");
  });

  // Modal yopish - X tugmasi
  if (modalClose) {
    modalClose.addEventListener("click", function () {
      modalOverlay.classList.remove("smb-modal-active");
    });
  }

  // Modal yopish - overlay click
  modalOverlay.addEventListener("click", function (e) {
    if (e.target === modalOverlay) {
      modalOverlay.classList.remove("smb-modal-active");
    }
  });

  // Form yuborish
  if (subscribeForm) {
    subscribeForm.addEventListener("submit", function (e) {
      e.preventDefault();

      // Privacy checkbox tekshirish
      const privacyCheckbox = document.getElementById("smbPrivacy");
      if (!privacyCheckbox.checked) {
        alert("Политика конфиденциальности билан рози бўлишингiz керак!");
        return;
      }

      modalOverlay.classList.remove("smb-modal-active");
      successModal.classList.add("smb-modal-active");
    });
  }

  // Success modal yopish - X tugmasi
  if (successModalClose) {
    successModalClose.addEventListener("click", function () {
      successModal.classList.remove("smb-modal-active");
    });
  }

  // Success modal yopish - OK tugmasi
  if (okBtn) {
    okBtn.addEventListener("click", function () {
      successModal.classList.remove("smb-modal-active");
    });
  }

  // Success modal yopish - overlay click
  successModal.addEventListener("click", function (e) {
    if (e.target === successModal) {
      successModal.classList.remove("smb-modal-active");
    }
  });
}

// DOM yuklangandan keyin ishga tushirish
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initSMBNewsletter);
} else {
  initSMBNewsletter();
}

// Agar sahifa dinamik ravishda yuklanayotgan bo'lsa
window.initSMBNewsletter = initSMBNewsletter;

// ===========================================footer=start====
function initSMBFooter() {
  const mobileHeaders = document.querySelectorAll(".smb-mobile-header");

  mobileHeaders.forEach((header) => {
    const section = header.closest(".smb-mobile-section");

    if (!section.classList.contains("no-dropdown")) {
      header.addEventListener("click", function () {
        const content = section.querySelector(".smb-mobile-content");
        const isActive = header.classList.contains("active");

        // Close all other sections
        mobileHeaders.forEach((otherHeader) => {
          const otherSection = otherHeader.closest(".smb-mobile-section");
          const otherContent = otherSection.querySelector(
            ".smb-mobile-content"
          );

          if (
            otherHeader !== header &&
            !otherSection.classList.contains("no-dropdown")
          ) {
            otherHeader.classList.remove("active");
            otherContent.classList.remove("active");
          }
        });

        // Toggle current section
        if (!isActive) {
          header.classList.add("active");
          content.classList.add("active");
        } else {
          header.classList.remove("active");
          content.classList.remove("active");
        }
      });
    }
  });
}

$(document).ready(function () {
  // contanct form
  // Initialize on DOM ready
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initSMBFooter);
  } else {
    initSMBFooter();
  }

  window.initSMBFooter = initSMBFooter;
  // bu kodlarni Men yozyapman Asadbek Qulboyev
  $(document).ready(function () {
    // Telefon mask (agar inputmask ulangan bo'lsa)
    if ($.fn.inputmask) {
      $("#phone").inputmask("+7 (999) 999-99-99");
    }

    // Telefon formani tekshirish
    function validatePhoneForm() {
      let phoneVal = $("#phone").val().trim();
      let phoneValid = /^\+7\s?\(\d{3}\)\s?\d{3}-\d{2}-\d{2}$/.test(phoneVal);
      let checkboxChecked = $(".custom_checkbox_input").is(":checked");

      if (phoneValid && checkboxChecked) {
        $(".btn_phone_next").prop("disabled", false);
      } else {
        $(".btn_phone_next").prop("disabled", true);
      }
    }

    $("#phone").on("input", validatePhoneForm);
    $(".custom_checkbox_input").on("change", validatePhoneForm);

    // Telefon → SMS
    // $(document).on("click", ".btn_phone_next", function (e) {
    //   e.preventDefault();
    //   if ($(this).is(":disabled")) return;
    //   $(".step_phone").fadeOut(200, function () {
    //     $(".step_sms").fadeIn(200);
    //   });
    // });

    // SMS → Назад
    $(document).on("click", ".btn_back_phone", function (e) {
      e.preventDefault();
      $(".step_sms").fadeOut(200, function () {
        $(".step_phone").fadeIn(200);
      });
    });

    // Telefon → Email
    $(document).on("click", ".modal_link", function (e) {
      e.preventDefault();
      $(".step_phone").fadeOut(200, function () {
        $(".step_email").fadeIn(200);
      });
    });

    // Email → Назад
    $(document).on("click", ".btn_back_email", function (e) {
      e.preventDefault();
      $(".step_email").fadeOut(200, function () {
        $(".step_phone").fadeIn(200);
      });
    });

    // SMS → Error
    $(document).on("click", ".btn_sms_wrong", function (e) {
      e.preventDefault();
      $(".step_sms").fadeOut(200, function () {
        $(".step_error").fadeIn(200);
      });
    });

    // Error → Назад
    $(document).on("click", ".btn_back_error", function (e) {
      e.preventDefault();
      $(".step_error").fadeOut(200, function () {
        $(".step_phone").fadeIn(200);
      });
    });

    // SMS input nav
    $(document).on("input", ".sms_inputs input", function () {
      this.value = this.value.replace(/[^0-9]/g, "");
      if (this.value.length === 1) {
        $(this).next("input").focus();
      }
    });

    $(document).on("keydown", ".sms_inputs input", function (e) {
      if (e.key === "Backspace" && this.value === "") {
        $(this).prev("input").focus();
      }
    });
    validatePhoneForm();
  });

  // Login form
  $(".eye").click(function () {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this).prev().attr("type", "password");
    } else {
      $(this).addClass("active");
      $(this).prev().attr("type", "text");
    }
  });
  $(".modal_bottom_text .modal_login").click(function () {
    $(".profile-modal#login").fadeIn();
    $(".profile-modal#registerModal").fadeOut();
  });
  $(".modal_bottom_text .modal_register").click(function () {
    $(".profile-modal#login").fadeOut();
    $(".profile-modal#registerModal").fadeIn();
  });

  $(".profile-btn").click(function () {
    $(".profile-modal#login").fadeIn();
  });

  $(".exit").on("click", function () {
    $(".profile-modal").fadeOut();
  });

  // bonus modal open btn
  $(".btn_politic").click(function () {
    $(".profile-modal#politic").fadeIn();
  });
  // inputmask
  $("input[type='tel']").inputmask("+7 (999) 999-99-99");
  //

  $(".profile__content").hide();
  $("#profile__content4").show();

  $(".profile__menu a").click(function (e) {
    // e.preventDefault();
    let target = $(this).data("target");
    console.log(target);
    $(".profile__menu a").removeClass("active");
    $(this).addClass("active");
    $(".profile__content").hide();
    // $("#" + target).show();
    $(".profile__content-wrapper").addClass("active");
    $(".profile__sidebar").addClass("active");
  });

  $(".sidebar_open  ").click(function () {
    $(".profile__content-wrapper").removeClass("active");
    $(".profile__sidebar").removeClass("active");
  });
  // gift

  // Forma ochish
  $(".gift_cards_add_btn").on("click", function () {
    $(".gift_cards_form").slideDown(0).css("display", "flex");
  });

  // Forma yopish
  $(".btn_cancel").on("click", function (e) {
    e.preventDefault();
    $(".gift_cards_form").slideUp();
  });
  $(".modal_cartax").click(function (e) {
    e.preventDefault();
    $(".profile-modal#cartax").fadeIn();
  });
  // orders tabs
  $(".orders__tab").on("click", function () {
    $(".orders__tab").removeClass("active");
    $(this).addClass("active");

    let tab = $(this).data("tab");
    $(".orders__content").removeClass("active");
    $("#" + tab).addClass("active");
  });
  // img slider

  $(".order-card__slider").each(function () {
    let $this = $(this);

    new Swiper($this[0], {
      slidesPerView: 1,
      navigation: {
        nextEl: $this.find(".swiper-button-next")[0],
        prevEl: $this.find(".swiper-button-prev")[0],
      },
    });
  });
});

// ========================================================buyer modal =========================================

function buyerModal() {
  $("#cartModal").addClass("show");
}

// Close cart modal
function closeCartModal() {
  $("#cartModal").removeClass("show");
}

// Close modal when clicking on overlay
$("#cartModal").on("click", function (e) {
  if (e.target === this) {
    closeCartModal();
  }
});

// Remove item functionality
$(".item-remove").on("click", function () {
  const cartItem = $(this).closest(".cart-item");
  cartItem.fadeOut(300, function () {
    $(this).remove();
    updateCartCount();
    updateTotal();

    // Check if cart is empty
    if ($(".cart-item").length === 0) {
      showEmptyCart();
    }
  });
});

// Update cart count
function updateCartCount() {
  const count = $(".cart-item").length;
}

// Update total price
function updateTotal() {
  let total = 0;
  $(".cart-item").each(function () {
    const priceText = $(this).find(".item-price-current").text();
    const price = parseInt(priceText.replace(/[^\d]/g, ""));
    total += price;
  });
  $(".cart-total-price").text(total.toLocaleString() + " ₽");
}

// Show empty cart state
function showEmptyCart() {
  $("#cartContent").hide();
  $(".cart-footer").hide();
  $("#emptyCart").show();
  $(".buyer_modal .cart-modal").css("height", "fit-content");
  $(".buyer_modal .cart-modal").css("width", "fit-content");
  $(".buyer_modal .cart-modal").css("overflow-y", "unset");
  $(".buyer_modal .cart-header").hide();
}

// Demo: Toggle between empty and filled cart
let isEmpty = false;
$("#emptyCart .empty-cart-btn").on("click", function () {
  if (isEmpty) {
    location.reload(); // Refresh to show items again
  } else {
    closeCartModal();
  }
});

// ESC key to close modal
$(document).keydown(function (e) {
  if (e.key === "Escape") {
    closeCartModal();
  }
});
//
function heart_icon(el) {
  el.classList.toggle("active");
}
