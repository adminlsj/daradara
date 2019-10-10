
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./owl.carousel');
require('./video');

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

$('[id=toggleSearchBar]').click(function(e) {
    var x = document.getElementById("searchBar");
    if (x.style.display === "none") {
        x.style.display = "block";
        document.getElementById("query").focus();
    } else {
        x.style.display = "none";
    }
});

$('[id=toggleVideoDescription]').click(function(e) {
    var description = document.getElementById("videoDescription");
    var icon = document.getElementById("toggleVideoDescriptionIcon");
    if (description.style.display === "none") {
        description.style.display = "block";
        icon.innerHTML = 'expand_less';
    } else {
        description.style.display = "none";
        icon.innerHTML = 'expand_more';
    }
});

$('#search-submit-btn').click(function(e) {
    $("#search-form").submit();
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
	      '<i class="material-icons" style="font-size:60px; color:white">keyboard_arrow_left</i>',
	      '<i class="material-icons" style="font-size:60px; color:white">chevron_right</i>'
	      ]
	});

    $.post(
        'https://graph.facebook.com',
        {
            id: '<?php echo $url; ?>',
            scrape: true
        },
        function(response){
            console.log(response);
        }
    );
});

window.fbAsyncInit = function(){
FB.init({
    appId: '1931467720459909', status: true, cookie: true, xfbml: true }); 
};
(function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if(d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; 
    js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
    ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));
function postToFeed(title, desc, url, image){
    var obj = {method: 'feed',link: url, picture: image,name: title,description: desc};
    function callback(response){}
    FB.ui(obj, callback);
}

$('.btnShare').click(function(){
    elem = $(this);
    postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));

    return false;
});

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos || currentScrollPos < 60) {
    document.getElementById("scroll-hide-nav").style.top = "0";
  } else {
    document.getElementById("scroll-hide-nav").style.top = "-60px";
  }
  prevScrollpos = currentScrollPos;
}

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
var urlParams = new URLSearchParams(window.location.search);
var query = urlParams.get('query');
var video = urlParams.get('v');
load_more(page); //initial content load

function ScrollHandler(e) {
    //throttle event:
    clearTimeout(_throttleTimer);
    _throttleTimer = setTimeout(function () {
        if ($(window).scrollTop() + $(window).height() + 1200 >= getDocHeight()) {
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
        url: '?v=' + video + '&page=' + page + '&query=' + query,
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
            $('.ajax-loading').html(" ");
            return;
        }
        $('.ajax-loading').hide(); //hide loading animation once data is received

        var $newAds = $('<div style="width: 100%; text-align: center; margin-bottom: 10px;"><ins class="adsbygoogle" style="display:inline-block;width:320px;height:100px;" data-ad-client="ca-pub-4485968980278243" data-ad-slot="5764379687"></ins></div>');
        newDivName = "d" + String(new Date().valueOf());
        var $newhtml = $("<div id='" + newDivName + "'>" + data + "</div>");
        $('#sidebar-results').append($newhtml);
        FB.XFBML.parse($newhtml[0]);

        $('#sidebar-results').append($newAds);
        (adsbygoogle = window.adsbygoogle || []).push({});
    })

    .fail(function(jqXHR, ajaxOptions, thrownError){
    });
}

const shareButton = document.querySelector('#shareBtn');
shareButton.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title: document.getElementById("shareBtn-title").innerHTML,
      url: document.getElementById("shareBtn-link").href
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    // fallback
  }
});

