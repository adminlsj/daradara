
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./fileinput.min');
require('./owl.carousel');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

require('./quantityBtn');

require('./comment');
require('./selectJob');
require('./saveJob');

require('./twbsPagination');

$('#avatar-upload').on("change", function(e) {
    $("#avatar-form").submit();
});

document.getElementById('location-home').focus()

$(document).ready(function(){
	$('#slide-out-arrow').click(function() {
		var x = document.getElementById("slide-in-content");
	    if (x.style.display === "none") {
	        $('#slide-in-content').slideDown();
	        $(this).html('keyboard_arrow_up');
	        $('#slide-out-blank-left').slideDown();
	        $('#slide-out-blank-right').slideDown();
	    } else {
	        $('#slide-in-content').slideUp();
	        $(this).html('keyboard_arrow_down');
	        $('#slide-out-blank-left').slideUp();
	        $('#slide-out-blank-right').slideUp();
	    }
	});
});

$(document).ready(function(){
	$(".blog-carousel").owlCarousel({
		items: 1,
		autoplay:true,
		autoPlayTimeout: 5000,
		itemsDesktop : [1199,1],
	    itemsDesktopSmall : [979,1],
	    itemsTablet : [768,1],
	    itemsMobile: [479,1],
	    loop: true,
		dots: false,
	    nav: true,
	    navText: [
	      '<i class="material-icons" style="font-size:36px; color:#666666">keyboard_arrow_left</i>',
	      '<i class="material-icons" style="font-size:36px; color:#666666">chevron_right</i>'
	      ]
	});

	$(window).scroll(function () {
        // set distance user needs to scroll before we fadeIn navbar
		if ($(this).scrollTop() > 100) {
			$('.home-nav-scroll-show').fadeIn();
		} else {
			$('.home-nav-scroll-show').fadeOut();
		}
	});
});

