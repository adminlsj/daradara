
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

$('#broad').change(function(){
  if (this.checked) {
    $('#hentai-tags-text').text('搜索包含任何一個以下選擇的標籤的影片：');
  } else {
    $('#hentai-tags-text').text('搜索包含所有以下選擇的標籤的影片：');
  }
});

$(".upload-image-btn").on("change", function() {
  var fileName = $('#image').val().split("\\").pop();
  $('#file-text').val(fileName);
});

$('.hentai-sort-options-wrapper').click(function() {
  var sort = $(this).find("div").text();
  $("#sort").val(sort);
  $('form#hentai-form').submit();
})

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
    if (link.startsWith('1098_') || link.startsWith('1006_') || link.startsWith('1097_') || link.startsWith('https://gss3.baidu.com')) {
      $("#outsource").prop("checked", true);
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

$(document).on("click", "#test-play-singleton-btn", function(e) {
    var link = $('#link').val();
    if (link.startsWith('1098_') || link.startsWith('1006_') || link.startsWith('1097_')) {
      $("#outsource").prop("checked", false);
      $.ajax({
          type:'GET',
          url:'/getSourceQQ?id=' + link,
          datatype: "html",
      })

      .done(function(data){
        $('#link').val(data);
        if ($('#sd').text() == '') {
          $('#sd').append(data);
        } else {
          $('#sd').append(' ' + data);
        }
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

$('[id=database-search-btn]').click(function(e) {
  var column = $('#column').find(":selected").text();
  var expression = $('#expression').find(":selected").text();
  var query = $('#dbquery').val();

  var urlParams = new URLSearchParams(window.location.search);
  urlParams.set('column', column);
  urlParams.set('expression', expression);
  urlParams.set('dbquery', query);
  window.location.href = window.location.href.split('?')[0] + '?' + urlParams;
});

$('[class=database-column]').click(function(e) {
  var sort = $(this).data('sort');

  var urlParams = new URLSearchParams(window.location.search);
  var order = 'desc';
  if (urlParams.get('order') == 'desc') {
    order = 'asc';
  }

  urlParams.set('sort', sort);
  urlParams.set('order', order);
  window.location.href = window.location.href.split('?')[0] + '?' + urlParams;
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

$('[id=home-menu-btn]').click(function(e) {
    var x = document.getElementById("home-sidebar-menu");
    if (x.style.display === "none") {
        x.style.display = "block";
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

  if (window.pageYOffset != 0) {
    $('#hentai-main-nav').css('background-color', 'black');
    $('#hentai-main-nav input').css('background-color', '#202020');
    $('#hentai-main-nav input').css('border-color', '#202020');

    $('#main-nav').css('background-color', '#141414');

  } else {
    $('#hentai-main-nav').css('background-color', '#303030');
    $('#hentai-main-nav input').css('background-color', '#404040');
    $('#hentai-main-nav input').css('border-color', '#404040');

    $('#main-nav').css('background-color', 'transparent');
  }
}

setTimeout(function(){
    $('#error').hide()
}, 5000)

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

require('./loadTag');
require('./lazyLoad');
require('./videoShow');