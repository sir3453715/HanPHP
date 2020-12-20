(function ($) {

  var controllerGlobal = new ScrollMagic.Controller();
  var newToggle = new ScrollMagic.Scene({
    duration: '100%'
  })
  .addTo(controllerGlobal)
  .triggerElement(".main")
  .triggerHook(.5);
  // .reverse(false);
  // .addIndicators();
  newToggle.on("end", function (e) {
  $(".header").toggleClass("is-top")
  });

  $('.hamburger').click(function(event) {
  	$(this).toggleClass('is-active');
  	$('.header').toggleClass('is-active');
    $('body').toggleClass('is-active');
    // $('.nav').toggleClass('is-active');
  });

  $('a.gotop').click(function(event) {
      event.preventDefault();
      $('html, body').animate({scrollTop:0}, 500);
  });

  $(document).ready(function() {
    // $('body:not(.page-index)').find('.header').addClass('is-top');
    if ($('.aside').length > 0) {
      $('.aside').clone().appendTo('body').attr('style', ' ').removeClass('pgHero__aside').addClass('globleAside');
      $('a.smooth[href^="#"]').click(function(event) {
          var id = $(this).attr("href");
          var offset = 0;
          // if ($('.hamburger').hasClass('is-active')) {
          var aH = $('.globleAside').outerHeight(true),
              bH = $('.header').outerHeight(true)
          if ($(this).hasClass('link1')) {
            offset = bH - 10;
          } else {
            offset = aH + bH - 10;
          }
          var target = $(id).offset().top - offset;
          // if ($('.hamburger').hasClass('is-active')) {
          //  $('.hamburger').trigger('click');
          // }
          $('html, body').animate({scrollTop:target}, 500);
          event.preventDefault();
      });
    }
  });

  (function(){
    var config = {
      viewFactor : 0.15,
      duration   : 800,
      distance   : "0px",
      scale      : 0.8,
    }
    window.sr = new ScrollReveal(config)
  })()

  var block = {
    origin   : "top",
    distance : "24px",
    duration : 1200,
    scale    : 1.05,
  }

  sr.reveal(".block, .idxHero, .pgHero", block)
  sr.reveal(".idxHero__txt, .pgHero__aside", block, 2300)

}(jQuery));
