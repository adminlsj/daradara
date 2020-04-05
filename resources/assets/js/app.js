
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

$('.slider-scroll-right').click(function() {
    $(this).parent().children(':first-child').animate({
      scrollLeft: '+=' + ($(window).width() * 0.92 + 12)
    }, 'slow');

    $(this).prev().css('display', 'block');
})

$('.slider-scroll-left').click(function() {
    $(this).parent().children(':first-child').animate({
      scrollLeft: '-=' + ($(window).width() * 0.92 + 12)
    }, 'slow');
})

$(document).on("click", "#singleNewCreateBtn", function(e) {
    e.preventDefault(e);
    $(this).prop('disabled', true);

    $.ajax({
       type:'GET',
       url:'/createGetSource',
       data: {url: $('#link').val()},
       success: function(data){
          const dp = new DPlayer({
            container: document.getElementById('dplayer'),
            autoplay: false,
            theme: '#d84b6b',
            preload: 'auto',
            volume: 0,
            video: {
              url: data,
            },
          });
          dp.video.pause();

          $('video').on('loadedmetadata', function() {
              $('#duration').val(dp.video.duration.toFixed(0));
              $('#singleNewCreateForm').submit();
          });
       },
       error: function(xhr, ajaxOptions, thrownError){
         $("#meta").html('error');
       }
    });
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
      if ($path == '/rank' || $path == '/newest' || $path == '/drama' || $path == '/anime') {
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
    $('#' + hash).css("background-color", "#7A7A7A");
    if (is_mobile) {
      $('html, body').animate({
          scrollTop: $('#' + hash).offset().top
      }, 'slow');
    } else {
      $('html, body').animate({
          scrollTop: $('#' + hash).offset().top - 50
      }, 'slow');
    }
    $('#' + hash).css("transition", "background-color 3s ease-in");
    $('#' + hash).css("background-color", "#1F1F1F");
});

$('form').submit(function(){
    $(this).find('button[type=submit]').prop('disabled', true);
});

$('div#subscribe-panel').on("submit", "form#subscribe-form", function(e) {
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
            $("div#subscribe-panel").html(data.unsubscribe_btn);
            $("span#subscribes-count").html(parseInt($("span#subscribes-count").html()) + 1);
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
            $("div#subscribe-panel").html(data.subscribe_btn);
            $("span#subscribes-count").html(parseInt($("span#subscribes-count").html()) - 1);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $("#subscribe-panel").html(xhr.responseText);
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

function showSnackbar(text) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerHTML = text;
    snackbar.className = "show";
    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 4000);
}

require('./lazyLoad');
require('./videoShow');