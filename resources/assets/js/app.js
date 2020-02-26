
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
        document.getElementById("query").focus();
    } else {
        x.style.display = "none";
    }
});

$('#search-submit-btn').click(function(e) {
    $("#search-form").submit();
});

$('#subscribe-show-all').click(function(e) {
    $("#subscribes-watch-wrapper").css('height', 'auto');
    $(this).css('display', 'none');
});

$('#unmute-btn').click(function(e) {
  dp.volume(0.7, true, false);
  $('video').prop('muted', false);
  $('#unmute-btn').css('display','none');
  $('#dplayer').addClass('dplayer-hide-controller');
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
      $path = window.location.pathname;
      if ($path == '/' || $path == '/rank' || $path == '/newest' || $path == '/variety' || $path == '/drama' || $path == '/anime') {
        scrollHideNav[i].style.top = "-46px";
      } else {
        scrollHideNav[i].style.top = "-50px";
      }
    }
  }
  prevScrollpos = currentScrollPos;
}

setTimeout(function(){
    $('#error').hide()
}, 5000)

$(document).ready(function () {
    var hash = window.location.hash.substr(1);
    if (is_mobile) {
      $('html, body').animate({
          scrollTop: $('#' + hash).offset().top
      }, 'slow');
    } else {
      $('html, body').animate({
          scrollTop: $('#' + hash).offset().top - 50
      }, 'slow');
    }
});

$('form').submit(function(){
    $(this).find('button[type=submit]').prop('disabled', true);
});

$('div#subscribeModal').on("submit", "form#subscribe-form", function(e) {
    $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
    })
    e.preventDefault(e);

    $.ajax({
        type:"POST",
        url: $(this).attr("action"),
        data:$(this).serialize(),
        dataType: 'json',
        success: function(data){
            $('#subscribeModal').modal('hide');
            $("div#subscribe-panel").html(data.unsubscribe_btn);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $("#subscribe-panel").html(xhr.responseText);
        }
    })
});

$('div#subscribe-panel').on("submit", "form#unsubscribe-form", function(e) {
    $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
    })
    e.preventDefault(e);

    $.ajax({
        type:"POST",
        url: $(this).attr("action"),
        data:$(this).serialize(),
        dataType: 'json',
        success: function(data){
            $("button#subscribe-btn").prop('disabled', false);
            $("div#subscribe-panel").html(data.subscribe_btn);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $("#subscribe-panel").html(xhr.responseText);
        }
    })
});

$('div#loginModal').on("submit", "form#loginModalForm", function(e) {
    $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
    })
    e.preventDefault(e);

    $.ajax({
        type:"POST",
        url: $(this).attr("action"),
        data:$(this).serialize(),
        dataType: 'json',
        success: function(data){
            $('#loginModal').modal('hide');
            $('#nav-account-icon').attr('href', data.href);
            $('form#subscribe-form input[name="_token"]').attr('value', data.csrf_token);
            $('#email').attr('value', data.email);
            $('#subscribe-user-id').attr('value', data.subscribe_user_id);
            $('#subscribeModal').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#loginModal').html(xhr.responseText);
        }
    })
});

$('div#signUpModal').on("submit", "form#signUpModalForm", function(e) {
    $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
    })
    e.preventDefault(e);

    $.ajax({
        type:"POST",
        url: $(this).attr("action"),
        data:$(this).serialize(),
        dataType: 'json',
        success: function(data){
            $('#signUpModal').modal('hide');
            $('#nav-account-icon').attr('href', data.href);
            $('form#subscribe-form input[name="_token"]').attr('value', data.csrf_token);
            $('#email').attr('value', data.email);
            $('#subscribe-user-id').attr('value', data.subscribe_user_id);
            $('#subscribeModal').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#signUpModal').html(xhr.responseText);
        }
    })
});

$('[id=switch-login-modal]').click(function(e) {
    $('#signUpModal').modal('hide');
    $('#loginModal').modal('show');
});

$('[id=switch-signup-modal]').click(function(e) {
    $('#loginModal').modal('hide');
    $('#signUpModal').modal('show');
});

$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    var from_subscribe = urlParams.get('from_subscribe');
    if (from_subscribe == 1) {
        $('#subscribeModal').modal('show');
    }
});

require('./lazyLoad');
require('./videoShow');