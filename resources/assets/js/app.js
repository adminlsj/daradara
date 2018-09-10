
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./fileinput.min');

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

$("#orderImgs").fileinput({ 'browseLabel' : '選擇圖片', 'removeLabel' : "刪除圖片" });

$(document).ready(function(){
	$('#slide-out-arrow').click(function() {
		var x = document.getElementById("slide-in-content");
	    if (x.style.display === "none") {
	        $('#slide-in-content').slideDown();
	        $(this).html('keyboard_arrow_up');
	        $('#slide-out-blank').slideDown();
	    } else {
	        $('#slide-in-content').slideUp();
	        $(this).html('keyboard_arrow_down');
	        $('#slide-out-blank').slideUp();
	    }
	});
});

$(document).ready(function(){
	$('.blog-carousel').owlCarousel({
		items: 1,
		loop: true,
		margin: 5,
		nav: false,
		dots: true,
		lazyLoad: true,
		autoplay: true,
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

