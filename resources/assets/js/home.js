var targetOffset = $("#main-nav-home").offset().top;
var $window = $(window).scroll(function(){
    if ( $window.scrollTop() > targetOffset ) {   
      $("#main-nav-home").css({"position":"fixed", 'background-color':'#141414'});
    } else {
      $("#main-nav-home").css({"position":"absolute", 'background-color':'transparent'});
    }
});