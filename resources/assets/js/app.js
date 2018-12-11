
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
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

require('./comment');

$('#avatar-upload').on("change", function(e) {
    $("#avatar-form").submit();
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
	      '<i class="material-icons" style="font-size:50px; color:white">keyboard_arrow_left</i>',
	      '<i class="material-icons" style="font-size:50px; color:white">chevron_right</i>'
	      ]
	});

	$(".blog-sm-carousel").owlCarousel({
		items: 1,
		autoplay:true,
		autoPlayTimeout: 5000,
		itemsDesktop : [1199,1],
	    itemsDesktopSmall : [979,1],
	    itemsTablet : [768,1],
	    itemsMobile: [479,1],
	    loop: true,
		dots: true,
	    nav: false
	});
});

var _throttleTimer = null;
var _throttleDelay = 100;
var $window = $(window);
var $document = $(document);
$document.ready(function () {
    $window
        .off('scroll', ScrollHandler)
        .on('scroll', ScrollHandler);
});

var page = 1; //track user scroll as page number, right now page number is 1
load_more(page); //initial content load

function ScrollHandler(e) {
    //throttle event:
    clearTimeout(_throttleTimer);
    _throttleTimer = setTimeout(function () {
        if ($(window).scrollTop() + $(window).height() + 600 >= getDocHeight()) {
	        page++; //page number increment
			load_more(page); //load content   
	   }
    }, _throttleDelay);
}

function getDocHeight() {
    var D = document;
    return Math.max(
        D.body.scrollHeight, D.documentElement.scrollHeight,
        D.body.offsetHeight, D.documentElement.offsetHeight,
        D.body.clientHeight, D.documentElement.clientHeight
    );
}

function load_more(page){
    $.ajax({
        url: '?page=' + page,
        type: "get",
        datatype: "html",
        beforeSend: function()
        {
            $('.ajax-loading').show();
        }
    })

    .done(function(data){
        if (data.length == 0){
	        console.log(data.length);
            //notify user if nothing to load
            $('.ajax-loading').html("No more records!");
            return;
        }
        $('.ajax-loading').hide(); //hide loading animation once data is received
        $("#sidebar-results").append(data); //append data into #results element          
    })

    .fail(function(jqXHR, ajaxOptions, thrownError){
    });
}

