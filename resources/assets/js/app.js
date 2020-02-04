
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

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

$('[id=toggleSearchBar]').click(function(e) {
    var x = document.getElementById("searchBar");
    if (x.style.display === "none") {
        x.style.display = "block";
        document.getElementById("q").focus();
    } else {
        x.style.display = "none";
    }
});

$('#search-submit-btn').click(function(e) {
    $("#search-form").submit();
});

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos || currentScrollPos < 60) {
    scrollHideNav = document.querySelectorAll(".scroll-hide-nav");
    for (i = 0; i < scrollHideNav.length; i++) {
      scrollHideNav[i].style.top = "0";
    }
  } else {
    scrollHideNav = document.querySelectorAll(".scroll-hide-nav");
    for (i = 0; i < scrollHideNav.length; i++) {
      scrollHideNav[i].style.top = "-50px";
    }
  }
  prevScrollpos = currentScrollPos;
}

setTimeout(function(){
    $('#error').hide()
}, 5000)

$(document).ready(function () {
    var hash = window.location.hash.substr(1);
    $('html, body').animate({
        scrollTop: $('#' + hash).offset().top
    }, 'slow');
});

require('./lazyLoad');
require('./videoShow');