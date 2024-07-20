jQuery(function($) {
  $('body').on('keyup input paste', '.phone_number, .mask_us_phone', function() {
      $(this).mask('+1 (999) 999-9999')
  });
  $('.mask_us_phone').trigger('input');
});

const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");
const navMain = document.querySelector(".mob-nav");

hamburger.addEventListener("click", () => {
  hamburger.classList.toggle("active");
  navMenu.classList.toggle("active");
  navMain.classList.toggle("active");
});

document.querySelectorAll(".nav-link").forEach((link) =>
  link.addEventListener("click", () => {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
  })
);