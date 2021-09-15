$(function() {

	$('.slider').owlCarousel({
                loop: true,
                margin: 0,
                nav:true,
                autoplay:true, 
                autoplayTimeout:3000, 
                autoplayHoverPause:true,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 1
                  },
                  500: {
                    items: 3
                  },
                  1000: {
                    items: 5
                  }
                }
    })

  // replace custom forms
  /*jcf.lib.domReady(function(){
    jcf.customForms.replaceAll();
  });*/

  $(".phone-mask").mask("+7 (999) 999-99-99");

  $('.faq-item .hh').on('click', function(){
    $(this).parent().toggleClass('opened');
  })

  $(".toggle_mnu").click(function() {
    $(".sandwich").toggleClass("active");
    $(this).toggleClass("active");
    $('.nav-bx').toggle();
  });

  
  $(".town-modal .btn-no").click(function(event) {
    event.preventDefault();
    $('.town-modal').fadeOut();
  });
  $('.town-modal .btn-no').on('click', function(event){
    event.preventDefault()
    $('.overlay, .popup-town-wrap').fadeIn();
  })
  $('.btn-comert').on('click', function(event){
    event.preventDefault()
    $('.overlay, .popup-comert-form').fadeIn();
  })
  $('.overlay, .close').on('click', function(event){
    $('.overlay, .popup, .popup-town-wrap').fadeOut();
  })

  let ww = $(window).width();
  if(ww < 768 ){
    $(window).on('scroll', function(){
      let scr = $(window).scrollTop();
      if(scr > 1000){
        $('.fixed-btn-bx').show();
      }else{
        $('.fixed-btn-bx').hide();
      }
    })
  }

  let op = 0;
  $('.open-text').on('click', function(event){
    event.preventDefault();
    $('.hidden-text').toggleClass('opened');
    if(op%2==0){
      $(this).text('Скрыть');
    }else{
      $(this).text('Расскрыть');
    }
    op++;
  })

  //параллакс по движению мыши
  let bg1 = document.querySelector('.top-box .bg');
  if(typeof bg1 != "undefined" && bg1){
    window.addEventListener('mousemove', function(e) {
      let x = e.clientX / window.innerWidth;
      let y = e.clientY / window.innerHeight;
      bg1.style.transform = 'translate(-' + x * 15 + 'px, -' + y * 15 + 'px)';
    });
  }
 

  $('.town-opener').on('click', function(event){
    $('.town-modal').fadeIn();
    $(this).toggleClass('opened');
    $('body,html').animate({
      scrollTop: 0
    }, 400);
  })
  $(".town-modal .btn-yes").click(function(event) {
    event.preventDefault();
    $('.town-modal').fadeOut();
    $('.town-opener').removeClass('opened');
  });

	
});
