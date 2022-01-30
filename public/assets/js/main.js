$(document).ready(function() {
  
    // Ouvre ou ferme le menu mobile
    $('.menu-button').click(function() {
      $('body').toggleClass('push-active');
      $('nav').toggleClass('nav--open');
      $('.wrap').toggleClass('wrap-push');
    });
  
  });