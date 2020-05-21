
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./home');

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

$(".upload-image-btn").on("change", function() {
  var fileName = $('#image').val().split("\\").pop();
  $('#file-text').val(fileName);
});

$('.slider-wrapper .slider-scroll-right').click(function() {
    var $windowWidth = $(window).width();
    var $scrollWidth;
    if ($windowWidth > 991) {
      $scrollWidth = $windowWidth - 220 - 50 - 10;
    } else if ($windowWidth > 768) {
      $scrollWidth = $windowWidth - 30 + 7;
    } else {
      $scrollWidth = $windowWidth - 30 + 5;
    }

    $(this).parent().children(':first-child').animate({
      scrollLeft: '+=' + $scrollWidth
    }, 'slow');

    $(this).prev().css('display', 'block');
})

$('.slider-wrapper .slider-scroll-left').click(function() {
    var $windowWidth = $(window).width();
    var $scrollWidth;
    if ($windowWidth > 991) {
      $scrollWidth = $windowWidth - 220 - 50 - 10;
    } else if ($windowWidth > 768) {
      $scrollWidth = $windowWidth - 30 + 7;
    } else {
      $scrollWidth = $windowWidth - 30 + 5;
    }
    
    $(this).parent().children(':first-child').animate({
      scrollLeft: '-=' + $scrollWidth
    }, 'slow');
})

$('.watch-slider .slider-scroll-right').click(function() {
    var $windowWidth = $(window).width();
    var $scrollWidth;
    if ($windowWidth > 991) {
      $scrollWidth = $windowWidth - 220 - 50 - 12;
    } else if ($windowWidth > 768) {
      $scrollWidth = $windowWidth - 30 + 7;
    } else {
      $scrollWidth = $windowWidth - 30 + 9;
    }

    $(this).parent().children(':first-child').animate({
      scrollLeft: '+=' + $scrollWidth
    }, 'slow');

    $(this).prev().css('display', 'block');
})

$('.watch-slider .slider-scroll-left').click(function() {
    var $windowWidth = $(window).width();
    var $scrollWidth;
    if ($windowWidth > 991) {
      $scrollWidth = $windowWidth - 220 - 50 - 10;
    } else if ($windowWidth > 768) {
      $scrollWidth = $windowWidth - 30 + 7;
    } else {
      $scrollWidth = $windowWidth - 30 + 5;
    }
    
    $(this).parent().children(':first-child').animate({
      scrollLeft: '-=' + $scrollWidth
    }, 'slow');
})

$(document).on("click", "#test-play-btn", function(e) {
    var link = $('#link').val();
    if (link.startsWith('1098_') || link.startsWith('1006_')) {
      $("#outsource").prop("checked", false);
      $.ajax({
          type:'GET',
          url:'/getSourceQQ?id=' + link,
          datatype: "html",
      })

      .done(function(data){
        $('#link').val(data);
        $('#test-player').html('<iframe src="' + data + '" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>');
        $('#test-player').css('display', 'block');
      })

      .fail(function(jqXHR, ajaxOptions, thrownError){
      });

    } else {
      if (link.indexOf("src='") >= 0) {
        link = link.split("src='")[1];
        link = link.substring(
            0, 
            link.indexOf("'")
        );
      } else if (link.indexOf('src="') >= 0) {
        link = link.split('src="')[1];
        link = link.substring(
            0, 
            link.indexOf('"')
        );
      }
      $('#link').val(link);
      $('#test-player').html('<iframe src="' + link + '" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>');
      $('#test-player').css('display', 'block');
    }
});

$(document).on("click", ".load-tag-videos", function(e) {
    var previous = $('.subscribes-tab .active');
    var current = $(this);
    previous.removeClass("active");
    current.addClass('active');

    if (current.text().indexOf("全部") >= 0) {
      $('#home-preload-videos').css('display', 'block');
    } else {
      $('#home-preload-videos').css('display', 'none');
    }

    $('#sidebar-results').css('opacity', '0.3');
    $('.ajax-loading').html('<img style="width: 40px; height: auto; margin: 0; position: absolute; top: 150px; left: 50%; transform: translate(-50%, -50%);" src="https://i.imgur.com/TcZjkZa.gif"/>');
    $('.ajax-loading-default').html('<img style="width: 40px; height: auto; padding-top: 20px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/>');

    var _throttleTimer = null;
    var _throttleDelay = 100;
    var $window = $(window);
    var $document = $(document);
    $window.off('scroll', ScrollHandler).on('scroll', ScrollHandler);
    $(document).on("click", ".load-tag-videos", function(e) {
        $window.off('scroll', ScrollHandler);
    });

    var page = 1; //track user scroll as page number, right now page number is 1
    load_more(page); //initial content load

    function ScrollHandler(e) {
      //throttle event:
      clearTimeout(_throttleTimer);
      _throttleTimer = setTimeout(function () {
          if ($(window).scrollTop() + $(window).height() + 1500 >= getDocHeight()) {
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
            type:'GET',
            url:'/loadTagList?tag=' + current.text().replace('#', '') + '&path=' + window.location.pathname + '&page=' + page,
            datatype: "html",
        })

        .done(function(data){
            if (data.length == 0){
              $('.ajax-loading').html(" ");
              $('.ajax-loading-default').html(" ");
              return;
            }

            newDivName = "d" + String(new Date().valueOf());
            var $newhtml = $("<div id='" + newDivName + "'>" + data + "</div>");
            if (page == 1) {
              $('#sidebar-results').html($newhtml);
              $('#sidebar-results').css('opacity', '1');
              $('.ajax-loading').html(" ");
            } else {
              $('#sidebar-results').append($newhtml);
            }

            var container = document.querySelector("#" + newDivName);
            var lazyImages = [].slice.call(container.querySelectorAll("img.lazy"));
            if ("IntersectionObserver" in window) {
                let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                  entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                      let lazyImage = entry.target;
                      lazyImage.src = lazyImage.dataset.src;
                      lazyImage.srcset = lazyImage.dataset.srcset;
                      lazyImage.classList.remove("lazy");
                      lazyImageObserver.unobserve(lazyImage);
                    }
                  });
                }, {
                  rootMargin: "0px 0px 256px 0px"
                });
                
                lazyImages.forEach(function(lazyImage) {
                  lazyImageObserver.observe(lazyImage);
                });
            }
        })

        .fail(function(jqXHR, ajaxOptions, thrownError){
        });
    }
});

$(document).ready(function () {
  $('#default-tag').click();
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

$('.search-submit-btn').click(function(e) {
    $(this).parent().submit();
});

$('#subscribe-show-all').click(function(e) {
    $("#subscribes-watch-wrapper").css('height', 'auto');
    $("#subscribes-watch-wrapper").css('white-space', 'normal');
    $(this).css('display', 'none');
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

$('.toggle-subscribe-tags').click(function(e) {
    var wrapper = $(".subscribe-tags-wrapper");
    var icon = $(".toggle-subscribe-tags-icon");
    if (icon.html() == 'expand_less') {
        wrapper.css('height', '39px');
        icon.html('expand_more');
    } else {
        wrapper.css('height', 'auto');
        icon.html('expand_less');
    }
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