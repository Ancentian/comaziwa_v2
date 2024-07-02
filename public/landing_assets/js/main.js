//Use Strict Mode
(function($) {
  "use strict";

//Remove loading-wrapper class before window load
setTimeout(function(){
  $('.loading-wrapper').removeClass('loading-wrapper-hide');
  return false;
}, 10);


//======= Run on Window Load ============
$(window).load(function(){ 

  //Page Loader
  $('#loader-name').addClass('loader-up');
  $('#loader-job').addClass('loader-up');
  $('#loader-animation').addClass('loader-up');
  setTimeout(function(){
    $('#page-loader').addClass('loader-out');
    return false;
  }, 400);  
  $('#page-loader').delay(1000).fadeOut(10);


  //Owl Carousel
  // >> Team
  $("#about-team").owlCarousel({
   	navigation : false, // Show next and prev buttons
    slideSpeed : 300,
    paginationSpeed : 400,      
    responsiveRefreshRate : 200,
  	responsiveBaseWidth: window,
  	items : 4,
  	itemsMobile : [479,1],
  	//autoPlay: 6000,
  	stopOnHover: true,
  	pagination: true,
  	//singleItem: true,
  	navigationText: ["<span class='fa fa-chevron-left'></span>","<span class='fa fa-chevron-right'></span>"]     
  });

  // >> Testimonials
  $("#testimonial-carousel").owlCarousel({
    navigation : false, // Show next and prev buttons
    slideSpeed : 300,
    paginationSpeed : 400,      
    responsiveRefreshRate : 200,
    responsiveBaseWidth: window,
    pagination: true,
    singleItem: true,    
    navigationText: ["<span class='fa fa-chevron-left'></span>","<span class='fa fa-chevron-right'></span>"],     
  });

 // >> Blog
  $("#blog-itens-container").owlCarousel({
    navigation : false, // Show next and prev buttons
    slideSpeed : 300,
    paginationSpeed : 400,      
    responsiveRefreshRate : 200,
    responsiveBaseWidth: window,
    pagination: true,
    singleItem: false,    
    navigationText: ["<span class='fa fa-chevron-left'></span>","<span class='fa fa-chevron-right'></span>"],     
 	items : 3,
  }); 

  
  // >> Hero
  $("#main-carousel").owlCarousel({
    navigation : false, // Show next and prev buttons
    pagination: true,
    singleItem: true,
    autoPlay : false,
    stopOnHover : false,
    //navigationText: ["<span class='fa fa-chevron-left'></span>","<span class='fa fa-chevron-right'></span>"],     
  }); 

  // >> Clients
   $("#clients-carousel").owlCarousel({ 
      navigation : false, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      items : 5,
      itemsCustom : false,
      itemsDesktop : [1199,4],
      itemsDesktopSmall : [980,3],
      itemsTablet: [768,2],
      itemsMobile : [479,1],
      pagination: false,
      responsiveRefreshRate : 200,
      responsiveBaseWidth: window,
      //navigationText: ["<span class='fa fa-chevron-left'></span>","<span class='fa fa-chevron-right'></span>"],     
  });
 
  //WAYPOINTS
  $('#main-carousel').waypoint(function(direction) {
      if (direction === 'down') {
        $('#header').addClass( 'header-stick');  
        $('#back-to-top').removeClass('back-to-top-hide');     
      }
      else {
        $('#header').removeClass( 'header-stick');
         $('#back-to-top').addClass('back-to-top-hide');  
      }     
    },
    {
     offset: '-20px'
  });

   // Counters (Used with Waypoints.JS)
  $('#section-show-me-numbers').waypoint(function() {

       // >> Finished projects
      $('#counter-item-title1').countTo({
        from: 5000,
        to: 8000,
        speed: 1500,
        refreshInterval: 200,
        onComplete: function(value) {
            console.debug(this);
        }
      });

      // >> Happy Customers
      $('#counter-item-title2').countTo({
        from: 50,
        to: 803,
        speed: 1500,
        refreshInterval: 50,
        onComplete: function(value) {
            console.debug(this);
        }
      });

      // >> Working Hours
      $('#counter-item-title3').countTo({
        from: 40,
        to: 520,
        speed: 1500,
        refreshInterval: 50,
        onComplete: function(value) {
            console.debug(this);
        }
      });

      // >> Partnerships in the Word
      $('#counter-item-title4').countTo({
        from: 1,
        to: 4000,
        speed: 1500,
        refreshInterval: 200,
        onComplete: function(value) {
            console.debug(this);
        }
      });
    },
    {
      triggerOnce: true, 
      offset: '70%'
  });  

  //Viewport
  var windowHeight = $(window).height();

  function adjustViewport() {
    $('.viewport').css('min-height', windowHeight);
    return false;
  }
  adjustViewport();  
  
  //Runs on window Resize
  $(window).resize(function() {
    windowHeight = $(window).height();
    adjustViewport();
  });

});



//======= Run on Document Ready ============
$(document).ready(function(){

  //Submenus
  $('.hd-list-menu li ul').hide();
  $('.hd-list-menu li').on('mouseenter', function(e){
  	$(this).find('> ul').fadeIn(200);
    return false;
  });
  $('.hd-list-menu li').on('mouseleave', function(e){
  	$(this).find('> ul').fadeOut(200);
    return false;
  });

  //Anchor Smooth Scroll
   $('.hd-list-menu a[href*=#]:not([href=#])').on('click', function () {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html,body').animate({
            scrollTop: target.offset().top
          }, 1000);
          return false;
        }
      }
    });

  //=====>  Countdown (Edit this with your own date)  <====
  $("#countdown").countdown("2017/11/22", function(event) {
    var $this = $(this).html(event.strftime(''
       + '<div class="countdown-col-wrapper col-xs-6 col-sm-3"><div class="countdown-col"><span class="countdown-time"> %-D </span> <span class="countdown-type"> Days </span></div></div> '
       + '<div class="countdown-col-wrapper col-xs-6 col-sm-3"><div class="countdown-col"><span class="countdown-time"> %H </span> <span class="countdown-type">Hours </span></div></div>'
       + '<div class="countdown-col-wrapper col-xs-6 col-sm-3"><div class="countdown-col"><span class="countdown-time"> %M </span> <span class="countdown-type">Minutes </span></div></div>'
       + '<div class="countdown-col-wrapper col-xs-6 col-sm-3"><div class="countdown-col"><span class="countdown-time"> %S </span> <span class="countdown-type">Seconds </span></div></div>'));
  });

  //Tabs
  var tabs = '.tabs';
  var tabsButtons = $('.tabs .tabs-buttons a');

  tabsButtons.on('click', function(e)  {
      var currentAttrValue = $(this).attr('href');
      // Show/Hide Tabs
      $('.tabs ' + currentAttrValue).fadeIn(600).siblings().hide();
      // Change/remove current tab to active
      $(this).parent('li').addClass('active').siblings().removeClass('active');
      e.preventDefault();
      return false;
  });

  $('.tab').hide();
  $('#tab1').show();

  //FANCYBOX
  $(".box-iframe").fancybox({
    type: 'iframe',
    fitToView: true
  });

  //FANCYBOX - BLOG
  $(".blog-item a", "#section-blog").fancybox({
    type: 'ajax',
    fitToView: true
  });


  //Maps iframe Overlay
  var map = $('#map');
  map.on('click', function () {
      $('#map iframe').css("pointer-events", "auto");
      return false;
  });

  map.on('mouseleave', function () {
      $('#map iframe').css("pointer-events", "none");
      return false;
  });

  //Register Form Validator and Ajax Sender
  var pContactError = $("#contactError");
  var pContactSuccess = $("#contactSuccess");

  $("#register-form").validate({
    submitHandler: function(form) {
      $.ajax({
        type: "POST",
        url: "php/contact-form.php",
        data: {
          "name": $("#register-form #name").val(),
          "email": $("#register-form #email").val(),
          "subject": $("#register-form #subject").val(),
          "phone": $("#register-form #telephone").val()
        },
        dataType: "json",
        success: function (data) {
          if (data.response == "success") {
            pContactSuccess.fadeIn(300);
            pContactError.addClass("hidden");

            $("#register-form #name, #register-form #email, #register-form #subject, #register-form #message")
              .val("")
              .blur()
              .closest(".control-group")
              .removeClass("success")
              .removeClass("error");              
            
          } else {
            pContactError.fadeIn(300);
            pContactSuccess.addClass("hidden");
          }
        }

      });
    }
  });


  //Intro - Register Form Validator and Ajax Sender
  $("#intro-register-form").validate({
    submitHandler: function(form) {
      $.ajax({
        type: "POST",
        url: "php/contact-form.php",
        data: {
          "name": $("#intro-register-form #if-name").val(),
          "email": $("#intro-register-form #if-email").val(),
          "subject": $("#intro-register-form #if-subject").val(),
          "phone": $("#intro-register-form #if-phone").val()
        },
        dataType: "json",
        success: function (data) {
          if (data.response == "success") {
            pContactSuccess.fadeIn(300);
            pContactError.addClass("hidden");

            $("#register-form #name, #register-form #email, #register-form #subject, #register-form #message")
              .val("")
              .blur()
              .closest(".control-group")
              .removeClass("success")
              .removeClass("error");              
            
          } else {
            pContactError.fadeIn(300);
            pContactSuccess.addClass("hidden");
          }
        }

      });
    }
  });

  //Back to Top Btn
  $('.back-to-top').on('click', function () {
    $('html, body').animate({
      scrollTop: 0
    }, 700);
    return false;
  });

  //Modal for Forms
  function hideModal() {
    $('.modal-wrap').fadeOut(300);
    return false;
  }

  $('.modal-wrap').on('click', function () {
    hideModal();
  });   

  $('.modal-bg').on('click', function () {
    hideModal();
  }); 

  //Interactive Placeholder
  [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
    // in case the input is already filled..
    if( inputEl.value.trim() !== '' ) {
      classie.add( inputEl.parentNode, 'input--filled' );
    }

    // events:
    inputEl.addEventListener( 'focus', onInputFocus );
    inputEl.addEventListener( 'blur', onInputBlur );
  } );

  function onInputFocus( ev ) {
    classie.add( ev.target.parentNode, 'input--filled' );
  }

  function onInputBlur( ev ) {
    if( ev.target.value.trim() === '' ) {
      classie.remove( ev.target.parentNode, 'input--filled' );
    }
  }

});
//End - Use Strict mode
})(jQuery);