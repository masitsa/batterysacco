// Initialize your app
var myApp = new Framework7();

// Export selectors engine
var $$ = Dom7;

// Add view
var mainView = myApp.addView('.view-main', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: false
});
       
  var mySwiper = myApp.swiper('.swiper-container2', {
    pagination:'.swiper-pagination',
    autoPlay:true
  });
  myApp.onPageInit('index', function (page) {
    // run createContentPage func after link was clicked
  $('.awesome-portfolio-content').mixItUp();  

    var mySwiper = myApp.swiper('.swiper-container2', {
    autoPlay:true
  });
  
});

(function ($) {
 "use strict";
    
$(function(){

 /*---------------------
 mixItUp
--------------------- */    

   $('.awesome-portfolio-content').mixItUp({
   animation: {
       effects: 'rotateZ',
       duration: 1000,
        }
    });

 /*---------------------
 swipebox
--------------------- */     
    $( '.swipebox' ).swipebox();
    
});
      
})(jQuery);    

  