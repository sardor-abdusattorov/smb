
document.addEventListener("DOMContentLoaded", function () {
  const accordionButtons = document.querySelectorAll(".accordion-button");

  accordionButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const collapseDiv = button
        .closest(".accordion-item")
        .querySelector(".accordion-collapse");

      if (!collapseDiv.classList.contains("show")) {
        collapseDiv.addEventListener(
          "shown.bs.collapse",
          function () {
            setTimeout(() => {
              const scrollTop = window.pageYOffset;
              const rect = button.getBoundingClientRect();

              // Kichik scroll bo'lsa juda yumshoq
              const targetY = scrollTop + rect.top - 130;
              const scrollDistance = Math.abs(targetY - scrollTop);

              if (scrollDistance < 200) {
                // Kichik masofalar uchun sekinroq
                setTimeout(() => {
                  window.scrollTo({
                    top: Math.max(0, targetY),
                    behavior: "smooth",
                  });
                }, 100);
              } else {
                // Katta masofalar uchun oddiy
                window.scrollTo({
                  top: Math.max(0, targetY),
                  behavior: "smooth",
                });
              }
            }, 200);
          },
          { once: true }
        );
      }
    });
  });
});

// ==================== GLOBAL VARIABLES ====================
let heroSwiper;
let handbagGallerySwiper;
let selectedFilters = {
  sort: null,
  colors: [],
  materials: [],
  models: [],
  sizes: [],
};

// ==================== UTILITY FUNCTIONS ====================
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// ==================== HEADER & SCROLL FUNCTIONS ====================
function initScrollBehavior() {
  const header = document.querySelector(".header");
  const mobileMenu = document.getElementById("mobileMenu");
  const catalog = document.querySelector(".catalog .main-content");
  const filter_overlay = document.querySelector(".filter-overlay");
  const filter_modal = document.querySelector(".filter-modal");

  if (!header) return;

  const handleScroll = debounce(() => {
    const isScrolled = window.scrollY >= 20;
    const action = isScrolled ? "add" : "remove";

    header.classList[action]("header-top_active");
    if (catalog) {
      catalog.classList[action]("header-top_active");
    }

    if (filter_overlay) {
      filter_overlay.classList[action]("header-top_active");
    }
    if (filter_modal) {
      filter_modal.classList[action]("header-top_active");
    }

    if (mobileMenu) {
      mobileMenu.classList[action]("mobile-toping_active");
    }
  }, 10);

  window.addEventListener("scroll", handleScroll, { passive: true });
}

// ==================== MOBILE MENU FUNCTIONS ====================
function toggleMobileMenu() {
  const mobileMenu = document.getElementById("mobileMenu");
  const header = document.querySelector(".header");
  const overlay = document.getElementById("mobileMenuOverlay");

  if (!mobileMenu || !header) return;

  const isActive = mobileMenu.classList.toggle("active");
  mobileMenu.classList.toggle("mobile-top_active", isActive);
  header.classList.toggle("active", isActive);

  if (overlay) {
    overlay.classList.toggle("active", isActive);
  }

  document.body.style.overflow = isActive ? "hidden" : "";
}

function toggleDropdown(targetId) {
  const dropdown = document.getElementById(targetId);
  const button = document.querySelector(
    `[onclick="toggleDropdown('${targetId}')"]`
  );

  if (!dropdown || !button) return;

  dropdown.classList.toggle("active");
  button.classList.toggle("active");
}

function initMobileMenuButtons() {
  const opening = document.querySelector(".opening");
  const closing = document.querySelector(".closing");

  if (!opening || !closing) return;

  opening.addEventListener("click", () => {
    opening.classList.remove("active");
    closing.classList.add("active");
  });

  closing.addEventListener("click", () => {
    closing.classList.remove("active");
    opening.classList.add("active");
  });
}

// ==================== SWIPER FUNCTIONS ====================
function initializeHeroSwiper() {
  const heroSwiperContainer = document.querySelector(".heroSwiper");
  if (!heroSwiperContainer) return;

  const autoplayEnabled = heroSwiperContainer.dataset.autoplay === "true";
  const autoplayDelay = parseInt(heroSwiperContainer.dataset.delay, 10) || 5000;

  heroSwiper = new Swiper(heroSwiperContainer, {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    autoplay: autoplayEnabled ? { delay: autoplayDelay, disableOnInteraction: false } : false,
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
//
document.addEventListener("DOMContentLoaded", function () {
  // Handbag Gallery Swiper
  const handbagGallerySwiper = new Swiper(".handbag-gallery__slider", {
    slidesPerView: 3.5,
    spaceBetween: 4,
    loop: true,
    grabCursor: true,

    breakpoints: {
      320: {
        slidesPerView: 1.3,
        spaceBetween: 8,
        loop: true,
      },
      768: {
        slidesPerView: 3.5,
        spaceBetween: 4,
        loop: true,
      },
    },
    mousewheel: {
      forceToAxis: true,
    },
  });
});

// ==================== COOKIE POPUP FUNCTIONS ====================
function initCookiePopup() {
  const cookiePopup = document.getElementById("cookiePopup");
  const acceptBtn = document.querySelector(".btn-accept");
  const declineBtn = document.querySelector(".btn-decline");

  if (!cookiePopup) return;

  // Check if already accepted
  if (localStorage.getItem("cookieAccepted") === "true") {
    cookiePopup.remove();
    return;
  }

  // Show popup after 2 seconds
  setTimeout(() => {
    cookiePopup.classList.add("show");
  }, 2000);

  // Accept button
  if (acceptBtn) {
    acceptBtn.addEventListener("click", () => {
      localStorage.setItem("cookieAccepted", "true");
      closeCookie();
    });
  }

  // Decline button
  if (declineBtn) {
    declineBtn.addEventListener("click", closeCookie);
  }
}

function closeCookie() {
  const cookiePopup = document.getElementById("cookiePopup");
  if (cookiePopup) {
    cookiePopup.classList.remove("show");
  }
}

// ==================== MARQUEE FUNCTIONS ====================
function initMarquee() {
  const marqueeContent = document.getElementById("marquee-content");
  if (!marqueeContent) return;

  const originalHTML = marqueeContent.innerHTML;
  marqueeContent.innerHTML = originalHTML + originalHTML;
}

// function toggleHeart(heartElement) {
//   if (heartElement) {
//     heartElement.classList.toggle("active");
//   }
// }

// ==================== NEWSLETTER MODAL FUNCTIONS ====================
function initSMBNewsletter() {
  const subscribeBtn = document.getElementById("smbSubscribeBtn");
  const modalOverlay = document.getElementById("smbModalOverlay");
  const modalClose = document.getElementById("smbModalClose");
  const subscribeForm = document.getElementById("smbSubscribeForm");
  const successModal = document.getElementById("smbSuccessModal");
  const successModalClose = document.getElementById("smbSuccessModalClose");
  const okBtn = document.getElementById("smbOkBtn");

  if (!subscribeBtn || !modalOverlay || !successModal) return;

  // Open modal
  subscribeBtn.addEventListener("click", () => {
    modalOverlay.classList.add("smb-modal-active");
  });

  // Close modal - X button
  if (modalClose) {
    modalClose.addEventListener("click", () => {
      modalOverlay.classList.remove("smb-modal-active");
    });
  }

  // Close modal - overlay click
  modalOverlay.addEventListener("click", (e) => {
    if (e.target === modalOverlay) {
      modalOverlay.classList.remove("smb-modal-active");
    }
  });

  // Form submission
  if (subscribeForm) {
    subscribeForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const privacyCheckbox = document.getElementById("smbPrivacy");
      if (privacyCheckbox && !privacyCheckbox.checked) {
        alert("Политика конфиденциальности билан рози бўлишингиз керак!");
        return;
      }

      modalOverlay.classList.remove("smb-modal-active");
      successModal.classList.add("smb-modal-active");
    });
  }

  // Success modal close handlers
  const closeSuccessModal = () => {
    successModal.classList.remove("smb-modal-active");
  };

  if (successModalClose) {
    successModalClose.addEventListener("click", closeSuccessModal);
  }

  if (okBtn) {
    okBtn.addEventListener("click", closeSuccessModal);
  }

  successModal.addEventListener("click", (e) => {
    if (e.target === successModal) {
      closeSuccessModal();
    }
  });
}

// ==================== FOOTER ACCORDION FUNCTIONS ====================
function initSMBFooter() {
  const mobileHeaders = document.querySelectorAll(".smb-mobile-header");

  mobileHeaders.forEach((header) => {
    const section = header.closest(".smb-mobile-section");

    if (!section || section.classList.contains("no-dropdown")) return;

    header.addEventListener("click", () => {
      const content = section.querySelector(".smb-mobile-content");
      const isActive = header.classList.contains("active");

      // Close all other sections
      mobileHeaders.forEach((otherHeader) => {
        const otherSection = otherHeader.closest(".smb-mobile-section");
        if (
          otherHeader !== header &&
          otherSection &&
          !otherSection.classList.contains("no-dropdown")
        ) {
          const otherContent = otherSection.querySelector(
            ".smb-mobile-content"
          );
          otherHeader.classList.remove("active");
          if (otherContent) {
            otherContent.classList.remove("active");
          }
        }
      });

      // Toggle current section
      if (!isActive && content) {
        header.classList.add("active");
        content.classList.add("active");
      } else {
        header.classList.remove("active");
        if (content) {
          content.classList.remove("active");
        }
      }
    });
  });
}

// ==================== FILTER FUNCTIONS ====================

function toggleFilterModal() {
  const filterOverlay = document.getElementById("filterOverlay");
  const filterModal = document.getElementById("filterModal");

  if (!filterOverlay || !filterModal) return;

  const isActive = filterOverlay.classList.toggle("active");
  filterModal.classList.toggle("active", isActive);

  if (isActive) {
    // Touch eventlarni cheklash
    document.addEventListener("touchmove", preventScroll, { passive: false });
    document.addEventListener("wheel", preventScroll, { passive: false });

    // Scroll pozitsiyasini saqlash
    const scrollY = window.scrollY;
    document.body.style.top = `-${scrollY}px`;
    document.body.style.width = "100%";
    document.body.dataset.scrollY = scrollY;
  } else {
    // Cheklovlarni olib tashlash
    document.removeEventListener("touchmove", preventScroll);
    document.removeEventListener("wheel", preventScroll);

    // Asl holatga qaytarish
    const scrollY = document.body.dataset.scrollY;
    document.body.style.position = "";
    document.body.style.top = "";
    document.body.style.width = "";
    window.scrollTo(0, parseInt(scrollY || "0"));
    delete document.body.dataset.scrollY;
  }
}
document.addEventListener("DOMContentLoaded", function () {
  const filterOverlay = document.getElementById("filterOverlay");
  const filterModal = document.getElementById("filterModal");

  if (filterOverlay) {
    filterOverlay.addEventListener("click", toggleFilterModal);
  }

  if (filterModal) {
    filterModal.addEventListener("click", function (e) {
      e.stopPropagation(); // Modal ichiga bosilsa, overlay eventiga o'tmasin
    });
  }
});
function preventScroll(e) {
  e.preventDefault();
}
function selectSort(element) {
  if (!element) return;

  // Remove active class from all sort options
  document.querySelectorAll(".sort-option .sort-radio").forEach((radio) => {
    radio.classList.remove("active");
  });

  // Add active class to selected option
  const radio = element.querySelector(".sort-radio");
  const label = element.querySelector(".sort-label");

  if (radio) radio.classList.add("active");
  if (label) selectedFilters.sort = label.textContent;

  updateApplyButton();
}

function toggleColor(element) {
  if (!element) return;

  element.classList.toggle("active");

  const colorClass = Array.from(element.classList).find(
    (cls) => cls !== "color-option" && cls !== "active"
  );

  if (element.classList.contains("active")) {
    if (colorClass && !selectedFilters.colors.includes(colorClass)) {
      selectedFilters.colors.push(colorClass);
    }
  } else {
    selectedFilters.colors = selectedFilters.colors.filter(
      (color) => color !== colorClass
    );
  }

  updateApplyButton();
}

function toggleCheckbox(element) {
  if (!element) return;

  const checkbox = element.querySelector(".checkbox-input");
  const labelElement = element.querySelector(".checkbox-label");
  const parent = element.closest(".filter-group");
  const groupTitleElement = parent?.querySelector(".filter-group-title");

  if (!checkbox || !labelElement || !groupTitleElement) return;

  checkbox.classList.toggle("active");

  const label = labelElement.textContent;
  const groupTitle = groupTitleElement.textContent;

  let targetArray;
  switch (groupTitle) {
    case "МАТЕРИАЛ":
      targetArray = selectedFilters.materials;
      break;
    case "МОДЕЛЬ":
      targetArray = selectedFilters.models;
      break;
    case "РАЗМЕР":
      targetArray = selectedFilters.sizes;
      break;
    default:
      return;
  }

  if (checkbox.classList.contains("active")) {
    if (!targetArray.includes(label)) {
      targetArray.push(label);
    }
  } else {
    const index = targetArray.indexOf(label);
    if (index > -1) {
      targetArray.splice(index, 1);
    }
  }

  updateApplyButton();
}

function updateApplyButton() {
  const applyBtn = document.getElementById("filterApplyBtn");
  if (!applyBtn) return;

  const totalSelected =
    (selectedFilters.sort ? 1 : 0) +
    selectedFilters.colors.length +
    selectedFilters.materials.length +
    selectedFilters.models.length +
    selectedFilters.sizes.length;

  if (totalSelected > 0) {
    applyBtn.disabled = false;
    applyBtn.textContent = `ПОКАЗАТЬ (${totalSelected})`;
  } else {
    applyBtn.disabled = true;
    applyBtn.textContent = "ПОКАЗАТЬ (1)";
  }
}

function applyFilters() {
  console.log("Applied filters:", selectedFilters);
  toggleFilterModal();
  // Here you would typically send the filters to your backend or update the product display
}
// ==================== EVENT LISTENERS ====================
function initEventListeners() {
  // Filter overlay close
  const filterOverlay = document.getElementById("filterOverlay");
  if (filterOverlay) {
    filterOverlay.addEventListener("click", (e) => {
      if (e.target === filterOverlay) {
        toggleFilterModal();
      }
    });
  }

  // Mobile menu overlay close
  const mobileMenuOverlay = document.getElementById("mobileMenuOverlay");
  if (mobileMenuOverlay) {
    mobileMenuOverlay.addEventListener("click", toggleMobileMenu);
  }
}

// ==================== INITIALIZATION ====================
function initializeApp() {
  initScrollBehavior();
  initMobileMenuButtons();
  initializeHeroSwiper();
  initCookiePopup();
  initMarquee();
  initSMBNewsletter();
  initSMBFooter();
  initEventListeners();
}

// ==================== DOM READY ====================
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initializeApp);
} else {
  initializeApp();
}

// ==================== GLOBAL FUNCTION EXPORTS ====================
window.toggleMobileMenu = toggleMobileMenu;
window.toggleDropdown = toggleDropdown;
window.toggleFilterModal = toggleFilterModal;
window.selectSort = selectSort;
window.toggleColor = toggleColor;
window.toggleCheckbox = toggleCheckbox;
window.applyFilters = applyFilters;
window.toggleHeart = toggleHeart;
window.initSMBNewsletter = initSMBNewsletter;
window.initSMBFooter = initSMBFooter;

// ======================product page js========================
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".color-options").forEach(function (container) {
    var colors = container.querySelectorAll(".color-option");
    var total = colors.length;

    if (total > 6) {
      // 6-chi elementdan boshlab barchasini olib tashlaymiz
      for (let i = 5; i < colors.length; i++) {
        colors[i].remove();
      }

      // +N qo'shamiz
      var moreCount = total - 5;
      var moreSpan = document.createElement("span");
      moreSpan.className = "color-option more";
      moreSpan.textContent = "+" + moreCount;
      container.appendChild(moreSpan);
    }
  });
});

$(document).ready(function () {
  const colorImages = {
    yellow: "/images/catalog_collection-section-yellow-bag.png",
    pink: "/images/product-page_prink-bag.png",
    brown: "/images/catalog_collection-section-brown-bag.png",
    beige: "/images/product-page_white-bag.jpg",
    navy: "/images/product-page_blue-bag.jpg",
  };

  if ($('input[name="color"]').length && $("#main-image").length) {
    $('input[name="color"]').change(function () {
      const selectedColor = $(this).val();
      const newImageSrc = colorImages[selectedColor];

      $("#main-image").addClass("fade-out");

      const tempImg = new Image();
      tempImg.src = newImageSrc;

      tempImg.onload = function () {
        $("#main-image").attr("src", newImageSrc).removeClass("fade-out");
      };

      tempImg.onerror = function () {
        console.error("Rasm yuklanmadi:", newImageSrc);
        $("#main-image").removeClass("fade-out");
      };
    });
  }

  // =================== 2. Sticky sidebar ===================
  let $sidebar = $("#product-info");
  let $container = $(".product");
  let sidebarHeight, sidebarTop, containerBottom;

  function updateSidebarMetrics() {
    sidebarHeight = $sidebar.outerHeight();
    sidebarTop = $sidebar.offset().top;
    containerBottom = $container.offset().top + $container.outerHeight();
  }

  if ($sidebar.length && $container.length) {
    updateSidebarMetrics();

    $(window).scroll(function () {
      let scrollTop = $(window).scrollTop();
      let imageHeight = $(".product-image").first().outerHeight() + 20;
      let scrollThreshold = imageHeight * 3;

      if (window.innerWidth > 768) {
        if (
          scrollTop > sidebarTop - 20 &&
          scrollTop < containerBottom - sidebarHeight - 40
        ) {
          if (scrollTop > scrollThreshold) {
            $sidebar.addClass("fixed").removeClass("bottom-fixed");
          }
        } else if (scrollTop >= containerBottom - sidebarHeight - 40) {
          $sidebar.removeClass("fixed").addClass("bottom-fixed");
        } else {
          $sidebar.removeClass("fixed").removeClass("bottom-fixed");
        }
      }
    });

    $(window).resize(function () {
      if (window.innerWidth <= 768) {
        $sidebar.removeClass("fixed bottom-fixed");
      }
      updateSidebarMetrics();
    });
  }

  // =================== 3. Modal functionality ===================
  if ($("#installment-btn").length && $("#installment-modal").length) {
    $("#installment-btn").click(function () {
      $("#installment-modal").addClass("active");
    });

    $("#modal-close, #modal-close-btn").click(function () {
      $("#installment-modal").removeClass("active");
    });

    $("#installment-modal").click(function (e) {
      if (e.target === this) {
        $(this).removeClass("active");
      }
    });
  }

  // =================== 4. Mobile/Desktop responsive ===================
  function handleResponsive() {
    if ($(".mobile-swiper").length && $(".desktop-images").length) {
      if (window.innerWidth <= 768) {
        $(".desktop-images").hide();
        $(".mobile-swiper").show();

        if (!window.mobileSwiper) {
          window.mobileSwiper = new Swiper(".mobile-swiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
              el: ".swiper-pagination",
              clickable: true,
            },
            loop: true,
          });
        }
      } else {
        $(".desktop-images").show();
        $(".mobile-swiper").hide();

        if (window.mobileSwiper) {
          window.mobileSwiper.destroy();
          window.mobileSwiper = null;
        }
      }
    }
  }

  handleResponsive();
  $(window).resize(handleResponsive);
});

if (document.querySelector("#product-info")) {
  // jQuery mavjudligini tekshirish va himoya qilish
  (function () {
    // jQuery yuklanganligini tekshirish
    if (typeof jQuery === "undefined") {
      console.warn("jQuery yuklanmagan. Script ishga tushmaydi.");
      return;
    }

    // jQuery bilan ishlash
    $(document).ready(function () {
      // =================== 1. Color images mapping ===================
      const colorImages = {
        yellow: "/images/catalog_collection-section-yellow-bag.png",
        pink: "/images/product-page_prink-bag.png",
        brown: "/images/catalog_collection-section-brown-bag.png",
        beige: "/images/product-page_white-bag.jpg",
        navy: "/images/product-page_blue-bag.jpg",
      };

      // Color change functionality
      if ($('input[name="color"]').length && $("#main-image").length) {
        $('input[name="color"]').change(function () {
          const selectedColor = $(this).val();
          const newImageSrc = colorImages[selectedColor];
          $('[id="main-image"]').each(function () {
            $(this).attr("src", newImageSrc);
          });
        });
      }

      // =================== 2. Sticky sidebar ===================
      let $sidebar = $("#product-info");
      let $container = $(".product");
      let sidebarHeight, sidebarTop, containerBottom;

      function updateSidebarMetrics() {
        if ($sidebar.length) {
          sidebarHeight = $sidebar.outerHeight();
          sidebarTop = $sidebar.offset().top;
        }
        if ($container.length) {
          containerBottom = $container.offset().top + $container.outerHeight();
        }
      }

      if ($sidebar.length && $container.length) {
        updateSidebarMetrics();

        $(window).scroll(function () {
          let scrollTop = $(window).scrollTop();
          let $productImage = $(".product-image").first();
          let imageHeight = $productImage.length
            ? $productImage.outerHeight() + 20
            : 0;
          let scrollThreshold = imageHeight * 3;

          if (window.innerWidth > 768 && sidebarHeight) {
            if (
              scrollTop > sidebarTop - 20 &&
              scrollTop < containerBottom - sidebarHeight - 40
            ) {
              if (scrollTop > scrollThreshold) {
                $sidebar.addClass("fixed").removeClass("bottom-fixed");
              }
            } else if (scrollTop >= containerBottom - sidebarHeight - 40) {
              $sidebar.removeClass("fixed").addClass("bottom-fixed");
            } else {
              $sidebar.removeClass("fixed").removeClass("bottom-fixed");
            }
          }
        });

        $(window).resize(function () {
          if (window.innerWidth <= 768) {
            $sidebar.removeClass("fixed bottom-fixed");
          }
          updateSidebarMetrics();
        });
      }

      // =================== 3. Modal functionality ===================
      if ($("#installment-btn").length && $("#installment-modal").length) {
        $("#installment-btn").click(function () {
          $("#installment-modal").addClass("active");
        });

        $("#modal-close, #modal-close-btn").click(function () {
          $("#installment-modal").removeClass("active");
        });

        $("#installment-modal").click(function (e) {
          if (e.target === this) {
            $(this).removeClass("active");
          }
        });
      }

      // =================== 4. Mobile/Desktop responsive ===================
      function handleResponsive() {
        if ($(".mobile-swiper").length && $(".desktop-images").length) {
          if (window.innerWidth <= 768) {
            $(".desktop-images").hide();
            $(".mobile-swiper").show();

            // Swiper yuklanganligini tekshirish
            if (typeof Swiper !== "undefined" && !window.mobileSwiper) {
              window.mobileSwiper = new Swiper(".mobile-swiper", {
                slidesPerView: 1,
                spaceBetween: 20,
                pagination: {
                  el: ".swiper-pagination",
                  clickable: true,
                },
                loop: true,
              });
            }
          } else {
            $(".desktop-images").show();
            $(".mobile-swiper").hide();

            if (window.mobileSwiper) {
              window.mobileSwiper.destroy();
              window.mobileSwiper = null;
            }
          }
        }
      }

      handleResponsive();
      $(window).resize(handleResponsive);
    });
  })();
}

// ======================product page js========================

// ================================ contact page

// ==========================search page========================
// Oddiy search animation funksiyasi
function initSearch() {
  const $searchBox = $("#searchBox");
  const $closeBtn = $("#closeBtn");
  const $searchInput = $(".search-input");
  const $clearBtn = $("#clearBtn");

  // Search ni ochish
  function showSearch() {
    $searchBox.addClass("active");
    setTimeout(() => {
      $searchInput.focus();
    }, 100);
  }

  // Search ni yopish
  function hideSearch() {
    $searchBox.removeClass("active");
    $searchInput.val("");
    $clearBtn.removeClass("show");
  }

  // Input matnini tozalash
  function clearInput() {
    $searchInput.val("").focus();
    $clearBtn.removeClass("show");
  }

  // Input o'zgarganda tozalash tugmasini ko'rsatish/yashirish
  $searchInput.on("input", function () {
    const value = $(this).val().trim();
    if (value.length > 0) {
      $clearBtn.addClass("show");
    } else {
      $clearBtn.removeClass("show");
    }
  });

  // Istalgan buttonga search qo'shish
  $(".search-trigger").on("click", function () {
    showSearch();
  });

  // X tugmasi (yopish)
  $closeBtn.on("click", function () {
    hideSearch();
  });

  // Tozalash tugmasi
  $clearBtn.on("click", function (e) {
    e.preventDefault();
    clearInput();
  });

  // Enter tugmasi
  $searchInput.on("keypress", function (e) {
    if (e.keyCode === 13) {
      const value = $(this).val().trim();
      if (value) {
        alert("Qidiruv: " + value);
        hideSearch();
      }
    }
  });

  // ESC tugmasi
  $(document).on("keydown", function (e) {
    if (e.keyCode === 27 && $searchBox.hasClass("active")) {
      hideSearch();
    }
  });
}

// Ishga tushirish
$(document).ready(function () {
  initSearch();
});

// Global funksiyalar
window.openSearch = function () {
  $("#searchBox").toggleClass("active");
  setTimeout(() => {
    $(".search-input").focus();
  }, 100);
};

window.showSearch = function () {
  $("#searchBox").addClass("active");
  setTimeout(() => {
    $(".search-input").focus();
  }, 100);
};

window.hideSearch = function () {
  $("#searchBox").removeClass("active");
  $(".search-input").val("");
  $("#clearBtn").removeClass("show");
};

window.search = function () {
  $("#searchBox").addClass("active");
  setTimeout(() => {
    $(".search-input").focus();
  }, 100);
};

// ==========================search page end ========================

const swiper = new Swiper(".article_slider", {
  slidesPerView: 2.1,
  spaceBetween: 4,
  loop: true,
  grabCursor: true,
  autoplay: {
    delay: 3000,
  },
  breakpoints: {
    0: {
      slidesPerView: 1.3,
    },
    480: {
      slidesPerView: 2.1,
      spaceBetween: 4,
    },
  },
});

//  =============================== denomination page js ========================
$(document).ready(function () {
  let currentStep = "amount";
  let selectedAmount = 5000;
  let formData = {
    amount: 5000,
    recipientName: "",
    recipientPhone: "",
    message: "",
    senderName: "",
    senderSurname: "",
    senderPhone: "",
    senderEmail: "",
  };

  // Tab navigation - Always allow navigation to any tab
  $(".tab").click(function () {
    const tab = $(this).data("tab");
    switchToStep(tab);
  });

  function getStepFromTab(tab) {
    const mapping = {
      nominal: "amount",
      to: "recipient",
      from: "sender",
      when: "time",
    };
    return mapping[tab] || tab;
  }

  function getTabFromStep(step) {
    const mapping = {
      amount: "nominal",
      recipient: "to",
      sender: "from",
      time: "when",
      payment: "when",
    };
    return mapping[step] || step;
  }

  function switchToStep(step) {
    const actualStep =
      typeof step === "string" &&
      ["nominal", "to", "from", "when"].includes(step)
        ? getStepFromTab(step)
        : step;

    $(".step").removeClass("active");
    $(".tab").removeClass("active");

    $(`#step-${actualStep}`).addClass("active");
    $(`.tab[data-tab="${getTabFromStep(actualStep)}"]`).addClass("active");

    // Hide all tabs when payment step becomes active
    if (actualStep === "payment") {
      $(".tab").css("display", "none");
    } else {
      $(".tab").css("display", ""); // Show tabs for other steps
    }

    currentStep = actualStep;
  }

  // Amount selection
  $(".amount-btn").click(function () {
    $(".amount-btn").removeClass("selected");
    $(this).addClass("selected");
    selectedAmount = parseInt($(this).data("amount"));
    formData.amount = selectedAmount;
    updateTotal();
    $("#custom-amount").val("");
    validateAmountStep();
  });

  $("#custom-amount").on("input", function () {
    const value = parseInt($(this).val());
    if (value && value > 0) {
      $(".amount-btn").removeClass("selected");
      selectedAmount = value;
      formData.amount = value;
      updateTotal();
    }
    validateAmountStep();
  });

  function updateTotal() {
    $(".amount").text(selectedAmount.toLocaleString() + " ₽");
  }

  function validateAmountStep() {
    const hasAmount = selectedAmount > 0;
    $("#continue-amount").prop("disabled", !hasAmount);
  }

  // Continue buttons - Fixed sequence
  $("#continue-amount").click(function () {
    if (!$(this).prop("disabled")) {
      switchToStep("sender"); // Go to sender step
    }
  });

  // Recipient form validation
  // function validateRecipientStep() {
  //   const name = $("#recipient-name").val().trim();
  //   const phone = $("#recipient-phone").val().trim();
  //   const isValid = name.length > 0 && phone.length > 0;
  //   $("#continue-recipient").prop("disabled", !isValid);
  // }

  // $("#recipient-name, #recipient-phone").on("input", function () {
  //   formData.recipientName = $("#recipient-name").val().trim();
  //   formData.recipientPhone = $("#recipient-phone").val().trim();
  //   validateRecipientStep();
  // });

  // $("#message").on("input", function () {
  //   const length = $(this).val().length;
  //   $(".char-count").text(length + "/300");
  //   formData.message = $(this).val();
  // });

  // $("#continue-recipient").click(function (e) {
  //   e.preventDefault(); // Prevent form submission
  //   if (!$(this).prop("disabled")) {
  //     switchToStep("time"); // Go to time step
  //   }
  // });

  // $("#back-recipient").click(function () {
  //   switchToStep("sender"); // Back to sender step
  // });

  // Sender form validation
  function validateSenderStep() {
    const name = $("#sender-name").val().trim();
    const surname = $("#sender-surname").val().trim();
    const phone = $("#sender-phone").val().trim();
    const email = $("#sender-email").val().trim();
    const terms = $("#terms").is(":checked");

    const isValid =
      name.length > 0 &&
      surname.length > 0 &&
      phone.length > 0 &&
      email.length > 0 &&
      terms;
    $("#continue-sender").prop("disabled", !isValid);
  }

  $("#sender-name, #sender-surname, #sender-phone, #sender-email, #terms").on(
    "input change",
    function () {
      formData.senderName = $("#sender-name").val().trim();
      formData.senderSurname = $("#sender-surname").val().trim();
      formData.senderPhone = $("#sender-phone").val().trim();
      formData.senderEmail = $("#sender-email").val().trim();
      validateSenderStep();
    }
  );

  $("#continue-sender").click(function () {
    if (!$(this).prop("disabled")) {
      switchToStep("recipient"); // Go to recipient step
    }
  });

  $("#back-sender").click(function () {
    switchToStep("amount"); // Back to amount step
  });

  // Time step navigation
  $("#back-time").click(function () {
    switchToStep("recipient"); // Back to recipient step
  });

  $("#go-time").click(function () {
    switchToStep("payment");
  });

  // Payment step
  $("#back-payment").click(function () {
    switchToStep("time");
  });

  // Handle back buttons with .back class in step-time and step-payment
  $("#step-time .back").click(function () {
    switchToStep("recipient"); // Back to recipient step
  });

  $("#step-payment .back").click(function () {
    switchToStep("time");
  });

  $("#go-payment").click(function (e) {
    e.preventDefault();
    console.log("Opening payment modal...");
    $("#payment-modal").addClass("show").css("display", "flex");
    $("body").css("overflow", "hidden"); // Prevent background scroll
  });

  // Payment modal interactions
  $(document).on("click", ".payment-options .option", function () {
    $(".payment-options .option").removeClass("selected");
    $(this).addClass("selected");
    $(this).find('input[type="radio"]').prop("checked", true);
    $("#select-payment").prop("disabled", false);
  });

  // Close payment modal - multiple selectors for better compatibility
  $(document).on(
    "click",
    '#close-payment-modal, .close-payment-modal, [data-close="payment-modal"]',
    function (e) {
      e.preventDefault();
      e.stopPropagation();
      console.log("Closing payment modal...");
      $("#payment-modal").removeClass("show").hide();
      $("body").css("overflow", "auto");
    }
  );

  $("#select-payment").click(function () {
    const selectedPayment = $(".payment-options .option.selected").data(
      "payment"
    );
    console.log("Selected payment:", selectedPayment);

    $("#payment-modal").removeClass("show");
    $("body").css("overflow", "auto");

    // Show loading state
    $(this).text("ОБРАБОТКА...").prop("disabled", true);

    // Simulate payment processing
    setTimeout(function () {
      $("#success-modal").addClass("show").css("display", "flex");
      $("body").css("overflow", "hidden");
    }, 1500);
  });

  // Success modal
  $("#close-success-modal, #ok-success").click(function () {
    $("#success-modal").removeClass("show");
    $("body").css("overflow", "auto");

    // Optional: Reset form or redirect
    if (confirm("Хотите создать еще одну подарочную карту?")) {
      location.reload();
    } else {
      // Redirect to homepage or close modal
      $("#success-modal").removeClass("show");
    }
  });

  // Close modals on overlay click
  $(".modal-overlay").click(function (e) {
    if (e.target === this) {
      $(this).removeClass("show");
      $("body").css("overflow", "auto");
    }
  });

  // Prevent modal close when clicking inside modal
  $(".gift-modal").click(function (e) {
    e.stopPropagation();
  });

  // ESC key to close modals
  $(document).keydown(function (e) {
    if (e.key === "Escape") {
      $(".modal-overlay.show").removeClass("show");
      $("body").css("overflow", "auto");
    }
  });

  // Phone input formatting with improved validation
  $('input[type="tel"]').on("input", function () {
    let value = $(this).val().replace(/\D/g, "");
    let originalLength = value.length;

    // Add country code if missing
    if (value.length > 0) {
      if (value[0] !== "7" && value[0] !== "8") {
        value = "7" + value;
      }
      if (value[0] === "8") {
        value = "7" + value.slice(1);
      }
      value = value.slice(0, 11);

      // Format the number
      let formatted = "+7";
      if (value.length > 1) {
        formatted += "(" + value.slice(1, 4);
        if (value.length >= 4) {
          formatted += ")" + value.slice(4, 7);
          if (value.length >= 7) {
            formatted += "-" + value.slice(7, 9);
            if (value.length >= 9) {
              formatted += "-" + value.slice(9, 11);
            }
          }
        }
      }
      $(this).val(formatted);
    }

    // Trigger validation for respective forms
    if ($(this).attr("id") === "recipient-phone") {
      validateRecipientStep();
    } else if ($(this).attr("id") === "sender-phone") {
      validateSenderStep();
    }
  });

  // Email validation
  $("#sender-email").on("input", function () {
    const email = $(this).val();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = emailRegex.test(email);

    if (email.length > 0 && !isValid) {
      $(this).addClass("error");
    } else {
      $(this).removeClass("error");
    }

    validateSenderStep();
  });

  // Character count and validation for message
  $("#message").on("input", function () {
    const length = $(this).val().length;
    $(".char-count").text(length + "/300");

    if (length > 300) {
      $(this).val($(this).val().substring(0, 300));
      $(".char-count").text("300/300");
    }

    formData.message = $(this).val();
  });

  // Form data collection
  function collectFormData() {
    return {
      amount: selectedAmount,
      recipientName: $("#recipient-name").val().trim(),
      recipientPhone: $("#recipient-phone").val().trim(),
      message: $("#message").val().trim(),
      senderName: $("#sender-name").val().trim(),
      senderSurname: $("#sender-surname").val().trim(),
      senderPhone: $("#sender-phone").val().trim(),
      senderEmail: $("#sender-email").val().trim(),
      paymentMethod: $(".payment-options .option.selected").data("payment"),
      timestamp: new Date().toISOString(),
    };
  }

  // Initialize form
  // function initializeForm() {
  //   validateAmountStep();
  //   validateRecipientStep();
  //   validateSenderStep();

  //   // Set initial focus
  //   $("#recipient-name").focus();

  //   console.log("Gift card form initialized");
  // }

  // Call initialize
  // initializeForm();
});
// =============================================================================================

//

document.addEventListener("DOMContentLoaded", function () {
  // =====================
  // 1) UTC va Local vaqt
  // =====================
  if (typeof moment !== "undefined") {
    const dateTimeUtc = moment("2017-06-05T19:41:03Z").utc();

    const timeUtcEl = document.querySelector(".js-TimeUtc");
    if (timeUtcEl) {
      timeUtcEl.innerText = dateTimeUtc.format("DD.MM.YYYY HH:mm");
    }

    const select = document.querySelector(".js-Selector");
    if (select) {
      const options = moment.tz.names().map((tz) => {
        const timezone = moment.tz(tz).format("Z");
        return `<option value="${tz}">(GMT${timezone}) ${tz}</option>`;
      });

      select.innerHTML = options.join("");

      select.addEventListener("change", (e) => {
        const selectedTz = e.target.value;
        const localTime = dateTimeUtc.clone().tz(selectedTz);

        const timeLocalEl = document.querySelector(".js-TimeLocal");
        if (timeLocalEl) {
          timeLocalEl.innerText = localTime.format("DD.MM.YYYY HH:mm");
        }
      });

      select.value = "Europe/Madrid";
      select.dispatchEvent(new Event("change"));
    }

    document.querySelector(".js-TimeUtc")?.closest("li")?.remove();
    document.querySelector(".js-TimeLocal")?.closest("li")?.remove();
  }

  // =====================
  // 2) Form validation
  // =====================
  function safeTrim(selector) {
    const el = document.querySelector(selector);
    return el && el.value ? el.value.trim() : "";
  }

  function validateRecipientStep() {
    const recipient = safeTrim("#recipient"); // input id="recipient"
    if (!recipient) {
      console.warn("Recipient is empty or missing");
      return false;
    }
    console.log("Recipient:", recipient);
    return true;
  }

  function initializeForm() {
    if (document.querySelector("#recipient")) {
      validateRecipientStep();
    }
  }

  initializeForm();
});

// ==========================================================btns toogle active
$(document).ready(function () {
  $(".time_btns .btn").click(function () {
    // Barcha buttonlardan active ni olib tashlaymiz
    $(".time_btns .btn").removeClass("active");

    // Bosilgan tugmaga active qo‘shamiz
    $(this).addClass("active");

    // Index ni olamiz: 0 yoki 1
    var index = $(this).index();

    // Barcha contendlardan active ni olib tashlaymiz
    $("#time_contend1, #time_contend2").removeClass("active");

    // Shu indexga mos contendga active qo‘shamiz
    if (index === 0) {
      $("#time_contend1").addClass("active");
    } else {
      $("#time_contend2").addClass("active");
    }
  });
});

// ====================================denomation end=======================
$(document).ready(function () {
  $(".constructor-models__toggler").on("click", function (e) {
    e.preventDefault();
    $(".constructor-models .models_block").toggleClass("open");
    $(".constructor-models__toggler").toggleClass("active");
  });
});

$(document).ready(function () {
  $(".monoxrom").click(function () {
    $(".material_types").hide(); // display: none
  });
  $(".monoxrom").click(function () {
    $(".reset_filter").hide(); // agar kerak bo‘lsa yana ko‘rsatadi
  });

  $(".coloring").click(function () {
    $(".material_types").show(); // agar kerak bo‘lsa yana ko‘rsatadi
    $(".material_types").addClass("active");
    $(".reset_filter").addClass("active");
    $(".reset_filter").show(); // agar kerak bo‘lsa yana ko‘rsatadi
  });
});
//
$(document).ready(function () {
  // Global functions for modal
  window.construktor_modal = function () {
    const modal = $("#konstruktor-modal");
    modal.removeClass("hide").show().addClass("show");
  };

  window.close_konstruktor_modal = function () {
    const modal = $("#konstruktor-modal");
    if (modal.hasClass("show")) {
      modal.removeClass("show").addClass("hide");

      setTimeout(function () {
        modal.removeClass("hide").hide();
      }, 300);
    }
  };

  // Close modal when clicking on overlay
  $(document).on("click", ".konstruktor-modal__overlay", function (e) {
    if (e.target === this) {
      close_konstruktor_modal();
    }
  });

  // Close modal with Escape key
  $(document).on("keydown", function (e) {
    if (e.key === "Escape" && $("#konstruktor-modal").hasClass("show")) {
      close_konstruktor_modal();
    }
  });

  // Remove animation classes after animation completes
  $("#konstruktor-modal").on("animationend", function (e) {
    if (e.target === this && $(this).hasClass("hide")) {
      $(this).removeClass("hide");
    }
  });
});

// ==========================================================karzina modal ========================
// Open cart modal
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

// ========================================================================= сheckout end
$(document).ready(function () {
  // Инициализация формы
  updateCheckoutButton();

  // Обработка изменения города
  $("#city").on("change", function () {
    if ($(this).val()) {
      $(".city-fields").show();
      updateDeliveryPrice();
    } else {
      $(".city-fields").hide();
    }
    updateCheckoutButton();
  });

  // Обработка переключения типа доставки
  $(".delivery-btn").on("click", function () {
    $(".delivery-btn").removeClass("active");
    $(this).addClass("active");

    const type = $(this).data("type");
    $(".delivery-fields").removeClass("show");
    $(`.${type}-fields`).addClass("show");

    // Сбрасываем выбранную службу доставки
    $('input[name="deliveryService"]').prop("checked", false);
    $(".delivery-service").removeClass("selected");

    updateDeliveryPrice();
    updateCheckoutButton();
  });

  // Обработка выбора службы доставки
  $(".delivery-service").on("click", function () {
    $(".delivery-service").removeClass("selected");
    $(this).addClass("selected");
    $(this).find('input[type="radio"]').prop("checked", true);
    updateDeliveryPrice();
    updateCheckoutButton();
  });

  // Обработка табов пунктов выдачи
  $(".pickup-tab").on("click", function () {
    $(".pickup-tab").removeClass("active");
    $(this).addClass("active");

    const tab = $(this).data("tab");
    $(".pickup-content").removeClass("active");
    $(`.${tab}-content`).addClass("active");
  });

  // Обработка выбора пункта выдачи
  $("#pickupLocation").on("change", function () {
    if ($(this).val()) {
      const selectedText = $(this).find("option:selected").text();
      $("#selectedPickup").show();
      $("#selectedPickup .pickup-address").text(selectedText);
    } else {
      $("#selectedPickup").hide();
    }
    updateCheckoutButton();
  });

  // Обработка выбора на карте
  $(".map-pin").on("click", function () {
    $("#selectedPickup").show();
    $("#selectedPickup .pickup-address").text(
      "MSK654, МОСКВА, УЛ. ФЕДОСЬИНО ПУСТА"
    );
    updateCheckoutButton();
  });

  // Обработка способов оплаты
  $(".payment-option").on("click", function () {
    $(".payment-option").removeClass("selected");
    $(this).addClass("selected");
    $(this).find('input[type="radio"]').prop("checked", true);
    updateCheckoutButton();
  });

  // Обработка переключателей
  $(".toggle").on("click", function () {
    $(this).toggleClass("active");
    const fieldsId = $(this).attr("id").replace("Toggle", "Fields");
    $(`#${fieldsId}`).toggleClass("show");
    updateTotalPrice();
  });

  // Обработка ввода в поля
  $(".form-input, .form-select").on("input change", function () {
    updateCheckoutButton();
  });

  // Обработка чекбоксов
  $(".checkbox").on("change", function () {
    updateCheckoutButton();
  });

  // Обработка слайдера товаров
  // $('.product-image').on('click', function () {
  //     $('.product-image').removeClass('active');
  //     $(this).addClass('active');
  // });

  // Обработка комментариев
  $("#comment").on("input", function () {
    const length = $(this).val().length;
    $(this).siblings("div").text(`${length}/300`);
  });

  // Обработка промокода
  $("#promoInput").on("keypress", function (e) {
    if (e.which === 13) {
      applyPromo();
    }
  });
});

function updateTotalPrice() {
  let total = 1124; // Базовая стоимость товаров

  // Промокод
  if ($("#promoSection").is(":visible")) {
    total += 150;
  }

  // Скидка
  total -= 224;

  // Подарочные карты
  if ($("#giftCardToggle").hasClass("active")) {
    const giftAmount = parseInt($("#giftCardAmount").val()) || 0;
    total -= giftAmount;
  }

  // Бонусы
  if ($("#bonusToggle").hasClass("active")) {
    const bonusAmount = parseInt($("#bonusAmount").val()) || 0;
    total -= bonusAmount;
  }

  $("#totalPrice").text(`${Math.max(0, total)} ₽`);
}

function updateCheckoutButton() {
  // const isFormValid = validateForm();
  const btn = $("#checkoutBtn");

  // if (isFormValid) {
  //   btn.addClass("active").prop("disabled", false);
  // } else {
  //   btn.removeClass("active").prop("disabled", true);
  // }
}

// function validateForm() {
//   // Проверяем обязательные поля
//   const firstName = $("#firstName").val().trim();
//   const lastName = $("#lastName").val().trim();
//   const phone = $("#phone").val().trim();
//   const email = $("#email").val().trim();
//   const city = $("#city").val();
//   const marketing = $("#marketing").is(":checked");
//   const privacy = $("#privacy").is(":checked");
//   const paymentSelected = $('input[name="payment"]:checked').length > 0;

//   if (
//     !firstName ||
//     !lastName ||
//     !phone ||
//     !email ||
//     !city ||
//     !marketing ||
//     !privacy ||
//     !paymentSelected
//   ) {
//     return false;
//   }

//   // Проверяем поля доставки
//   if ($(".city-fields").is(":visible")) {
//     const deliveryType = $(".delivery-btn.active").data("type");
//     const serviceSelected =
//       $('input[name="deliveryService"]:checked').length > 0;

//     if (!serviceSelected) {
//       return false;
//     }

//     if (deliveryType === "courier") {
//       const zipCode = $("#zipCode").val().trim();
//       const address = $("#address").val().trim();
//       if (!zipCode || !address) {
//         return false;
//       }
//     } else if (deliveryType === "pickup") {
//       const pickup =
//         $("#pickupLocation").val() || $("#selectedPickup").is(":visible");
//       if (!pickup) {
//         return false;
//       }
//     }
//   }

//   return true;
// }

function removePromo() {
  $("#promoSection").hide();
  updateTotalPrice();
}

function showPromoPopup() {
  $("#promoPopup").show();
}

function closePromoPopup() {
  $("#promoPopup").hide();
  $("#promoInput").val("");
}

function applyPromo() {
  const promoCode = $("#promoInput").val().trim();
  if (promoCode) {
    $("#promoSection").show();
    $("#promoSection .promo-code").text(promoCode);
    closePromoPopup();
    updateTotalPrice();
  }
}

// Обработчик кнопки оплаты
$("#checkoutBtn").on("click", function () {
  if ($(this).hasClass("active")) {
    // Здесь будет логика отправки формы
    alert("Форма отправлена!");
  }
});

// Закрытие попапа при клике на overlay
$(".popup-overlay").on("click", function (e) {
  if (e.target === this) {
    closePromoPopup();
  }
});

// Добавляем интерактивность для карты
$(".map-container").on("click", function (e) {
  const rect = this.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;

  $(".map-pin").css({
    left: x + "px",
    top: y + "px",
  });
});

// ============================== checkout map x btn
$(".x_item .x").on("click", function () {
  $(".map_man-block").hide();
});

// ================================== chekout slider
$(document).ready(function () {
  // isnew_input va checkoutBtn mavjudligini tekshirish
  if ($(".isnew_input").length > 0 && $("#checkoutBtn").length > 0) {
    $(".isnew_input").on("input", function () {
      const value = $(this).val().trim();
      if (value.length > 0) {
        $("#checkoutBtn").addClass("active");
      } else {
        $("#checkoutBtn").removeClass("active");
      }
    });
  }
});

// Product images slider
const slider = document.querySelector(".product-images");

// Slider mavjudligini tekshirish
if (slider) {
  let isDown = false;
  let startX;
  let scrollLeft;

  slider.addEventListener("mousedown", (e) => {
    isDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
  });

  slider.addEventListener("mouseleave", () => {
    isDown = false;
  });

  slider.addEventListener("mouseup", () => {
    isDown = false;
  });

  slider.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 1.5; // 1.5 = scroll tezligi
    slider.scrollLeft = scrollLeft - walk;
  });
}

// Agar jQuery mavjud emasligini ham tekshirmoqchi bo'lsangiz:
if (typeof $ !== "undefined") {
  $(document).ready(function () {
    // isnew_input va checkoutBtn mavjudligini tekshirish
    if ($(".isnew_input").length > 0 && $("#checkoutBtn").length > 0) {
      $(".isnew_input").on("input", function () {
        const value = $(this).val().trim();
        if (value.length > 0) {
          $("#checkoutBtn").addClass("active");
        } else {
          $("#checkoutBtn").removeClass("active");
        }
      });
    }
  });
}

// ==========================================product page =====

$(document).ready(function () {
  $("#zipCode").on("input", function () {
    let value = $(this).val().replace(/\s+/g, ""); // Remove all spaces
    let formatted = value.match(/.{1,3}/g); // Split into chunks of 3
    if (formatted) {
      $(this).val(formatted.join(" ")); // Join chunks with space
    }
  });
});

// =========================================================================
//

$(document).ready(function () {
  window.initSMBFooter = initSMBFooter;

  // bu kodlarni Men yozyapman Asadbek Qulboyev
  $(document).ready(function () {
    // Telefon mask (agar inputmask ulangan bo'lsa)
    if ($.fn.inputmask) {
      $(".profile-modal #phone").inputmask("+7 (999) 999-99-99");
    }

    // Telefon formani tekshirish
    function validatePhoneForm() {
      let phoneVal = $(".profile-modal #phone").val().trim();
      let phoneValid = /^\+7\s?\(\d{3}\)\s?\d{3}-\d{2}-\d{2}$/.test(phoneVal);
      let checkboxChecked = $(".profile-modal .custom_checkbox_input").is(
        ":checked"
      );

      if (phoneValid && checkboxChecked) {
        $(".profile-modal .btn_phone_next").prop("disabled", false);
      } else {
        $(".profile-modal .btn_phone_next").prop("disabled", true);
      }
    }

    $(".profile-modal #phone").on("input", validatePhoneForm);
    $(".profile-modal .custom_checkbox_input").on("change", validatePhoneForm);

    // Telefon → SMS
    $(document).on("click", ".profile-modal .btn_phone_next", function (e) {
      e.preventDefault();
      if ($(this).is(":disabled")) return;
      $(".profile-modal .step_phone").fadeOut(200, function () {
        $(".profile-modal .step_sms").fadeIn(200);
      });
    });

    // SMS → Nazad
    $(document).on("click", ".profile-modal .btn_back_phone", function (e) {
      e.preventDefault();
      $(".profile-modal .step_sms").fadeOut(200, function () {
        $(".profile-modal .step_phone").fadeIn(200);
      });
    });

    // Telefon → Email
    $(document).on("click", ".profile-modal .modal_link", function (e) {
      e.preventDefault();
      $(".profile-modal .step_phone").fadeOut(200, function () {
        $(".profile-modal .step_email").fadeIn(200);
      });
    });

    // Email → Nazad
    $(document).on("click", ".profile-modal .btn_back_email", function (e) {
      e.preventDefault();
      $(".profile-modal .step_email").fadeOut(200, function () {
        $(".profile-modal .step_phone").fadeIn(200);
      });
    });

    // SMS → Error
    $(document).on("click", ".profile-modal .btn_sms_wrong", function (e) {
      e.preventDefault();
      $(".profile-modal .step_sms").fadeOut(200, function () {
        $(".profile-modal .step_error").fadeIn(200);
      });
    });

    // Error → Nazad
    $(document).on("click", ".profile-modal .btn_back_error", function (e) {
      e.preventDefault();
      $(".profile-modal .step_error").fadeOut(200, function () {
        $(".profile-modal .step_phone").fadeIn(200);
      });
    });

    // SMS input navigation
    $(document).on("input", ".profile-modal .sms_inputs input", function () {
      this.value = this.value.replace(/[^0-9]/g, "");
      if (this.value.length === 1) {
        $(this).next("input").focus();
      }
    });

    $(document).on("keydown", ".profile-modal .sms_inputs input", function (e) {
      if (e.key === "Backspace" && this.value === "") {
        $(this).prev("input").focus();
      }
    });
    validatePhoneForm();
  });

  // Login form - eye functionality
  $(".profile-modal .eye").click(function () {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this).prev().attr("type", "password");
    } else {
      $(this).addClass("active");
      $(this).prev().attr("type", "text");
    }
  });

  // Profile form - eye functionality
  $(".profile .eye").click(function () {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this).prev().attr("type", "password");
    } else {
      $(this).addClass("active");
      $(this).prev().attr("type", "text");
    }
  });

  // Modal login/register switching
  $(".profile-modal .modal_bottom_text .modal_login").click(function () {
    $(".profile-modal#login").fadeIn();
    $(".profile-modal#registerModal").fadeOut();
  });

  $(".profile-modal .modal_bottom_text .modal_register").click(function () {
    $(".profile-modal#login").fadeOut();
    $(".profile-modal#registerModal").fadeIn();
  });

  // Profile button click
  $(".profile-btn").click(function () {
    $(".profile-modal#login").fadeIn();
  });

  // Modal close
  $(".profile-modal .exit").on("click", function () {
    $(".profile-modal").fadeOut();
  });

  // Bonus modal open button
  $(".profile .btn_politic").click(function () {
    $(".profile-modal#politic").fadeIn();
  });

  // Inputmask for profile forms
  $(".profile input[type='tel']").inputmask("+7 (999) 999-99-99");

  // Profile content navigation
  $(".profile .profile__content").hide();
  $(".profile .profile__content:first").show();

  //   $(".profile .profile__menu a").click(function () {
  //     $(this).attr("data-target");
  //     $(".profile .profile__menu a").removeClass("active");
  //     $(this).addClass("active");
  //     $(".profile .profile__content").hide();
  //     $(".profile " + $(this).attr("href")).show();
  //     $(".profile .profile__content-wrapper").addClass("active");
  //     $(".profile .profile__sidebar").addClass("active");
  //   });
  $(".profile .profile__menu a").click(function (e) {
    e.preventDefault();

    let target = $(this).attr("data-target");
    $(".profile__menu a").removeClass("active");
    $(this).addClass("active");
    $(".profile__content").hide();
    $(target).show();
    $(".profile__content-wrapper").addClass("active");
    $(".profile__sidebar").addClass("active");
  });

  $(".profile .sidebar_open").click(function () {
    $(".profile .profile__content-wrapper").removeClass("active");
    $(".profile .profile__sidebar").removeClass("active");
  });

  // Gift cards functionality
  $(".profile .gift_cards_add_btn").on("click", function () {
    $(".profile .gift_cards_form").slideDown(0).css("display", "flex");
  });

  $(".profile .btn_cancel").on("click", function (e) {
    e.preventDefault();
    $(".profile .gift_cards_form").slideUp();
  });

  $(".profile .modal_cartax").click(function (e) {
    e.preventDefault();
    $(".profile-modal#cartax").fadeIn();
  });

  // Orders tabs
  $(".profile .orders__tab").on("click", function () {
    $(".profile .orders__tab").removeClass("active");
    $(this).addClass("active");

    let tab = $(this).data("tab");
    $(".profile .orders__content").removeClass("active");
    $(".profile #" + tab).addClass("active");
  });

  // Image slider initialization
  $(".profile .order-card__slider").each(function () {
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

// ===============================================
