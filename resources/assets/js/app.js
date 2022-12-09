
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

/* var progress;
$('.preview-trigger').hover(function(){
  var bar = $(this).find('#myBar');
  var width = 1;
  progress = setInterval(function(){
    if (width >= 100) {
      clearInterval(progress);
    } else {
      width++;
      bar.width(width + '%');
    }
  }, 25);

  var url = $(this).data('preview');
  var poster = $(this).data('poster');
  $(this).find('.preview-wrapper').append('<video style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:black" class="preview" autoplay muted loop poster="' + poster + '"><source src="' + url + '" type="video/mp4"></video>');
  $('.preview').play();

},function(){
  $('.preview').remove();
  clearInterval(progress);
  $(this).find('#myBar').width(0);
});

$('.preview-trigger').on({ 'touchstart' : function(){
  if (!$(this).find('.preview').length) {
    var bar = $(this).find('#myBar');
    var width = 1;
    var progress = setInterval(function(){
      if (width >= 100) {
        clearInterval(progress);
        bar.width('0%');
      } else {
        width++;
        bar.width(width + '%');
      }
    }, 20);

    var previous = $('.preview-trigger').find('.preview');
    previous.fadeOut(300, function() { $(this).remove() });;

    var url = $(this).data('preview');
    var poster = $(this).data('poster');
    var video = $('<video style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:transparent" class="preview" muted loop playsinline src="' + url + '"></video>')
    .bind("loadeddata", function(){
        $(this).css('background-color', 'black');
    }).appendTo($(this).find('.preview-wrapper'))[0].play();
  }
}}); */

$('#broad').change(function(){
  if (this.checked) {
    $('#hentai-tags-text').text('搜索包含任何一個以下選擇的標籤的影片：');
  } else {
    $('#hentai-tags-text').text('搜索包含所有以下選擇的標籤的影片：');
  }
});

$('.load-more-related-btn').click(function() {
    $(this).css('display', 'none');
    var hidden = $(".temp-hidden-related-video");
    hidden.removeClass('hidden-xs');
    hidden.removeClass('hidden-sm');
    $('#more-related-ad').css('margin-top', '0px');
    $('#exoclick-banner-adjust').css('margin-top', '0px');
    $('#double-banners-adjust').css('margin-top', '-15px');
})

$('#show-more-playlists-btn').click(function() {
    $(this).css('display', 'none');
    $(".temp-hidden-playlists").removeClass('hidden');
})

$('#close-mobile-ad-btn').click(function() {
  $('#mobile-ad').css('display', 'none');
})

$('.navigate-next-btn').click(function() {
  var row = $(this).prev();
  var rowWidth = row.width();
  var pos = row.scrollLeft() + rowWidth;
  row.animate({scrollLeft: pos + 1}, 600);
  $(this).prev().prev().css('display', 'block');
})

$('.navigate-before-btn').click(function() {
  var row = $(this).next();
  var rowWidth = row.width();
  var pos = row.scrollLeft() - rowWidth;
  row.animate({scrollLeft: pos}, 600);
})

$(".upload-image-btn").on("change", function() {
  var fileName = $('#image').val().split("\\").pop();
  $('#file-text').val(fileName);
});

$('.genre-option').click(function() {
  var genre = $(this).text();
  $("#genre").val(genre);
  $('form#hentai-form').submit();
})

$('.duration-option').click(function() {
  var duration = $(this).find('span').text();
  $("#duration").val(duration);
  $('form#hentai-form').submit();
})

$('.hentai-sort-options-wrapper').click(function() {
  var sort = $(this).find("div").text();
  $("#sort").val(sort);
  $('form#hentai-form').submit();
})

$('.search-type-button').click(function() {
  var type = $(this).find('.search-type-input').text();
  if (type == '搜索作者') { 
    type = 'artist';
  } else {
    type = 'video';
  }
  $("#type").val(type);
  $("#sort").val('');
  $('form#hentai-form').submit();
})

$('#search-btn').click(function() {
  $('form#hentai-form').submit();
})

$('.play-btn').click(function() {
  dp.play()
})

$('#playModal').on('hidden.bs.modal', function () {
  dp.pause()
});

/* $('nav#hentai-main-nav').on("submit", "form#search-form", function(e) {
  e.preventDefault(e);
  var query = $('#nav-query').val();
  $('#hentai-form #query').val(query);
  $('form#hentai-form').submit();
});

$('div#search-top-nav-mobile').on("submit", "form#search-form", function(e) {
  e.preventDefault(e);
  var query = $('#nav-query').val();
  $('#hentai-form #query').val(query);
  $('form#hentai-form').submit();
}); */

$('div#main-nav-home').on("submit", "form#search-form", function(e) {
  e.preventDefault(e);
  var query = $('#nav-query').val();
  $('#hentai-form #query').val(query);
  $('form#hentai-form').submit();
});

$('#nav-search-btn').click(function() {
  var query = $('#nav-query').val();
  $('#hentai-form #query').val(query);
  $('form#hentai-form').submit();
})

/* $('div#main-nav').on("submit", "form#main-search-form", function(e) {
  e.preventDefault(e);
  var query = $('#nav-query').val();
  $('#hentai-form #query').val(query);
  $('form#hentai-form').submit();
}); */

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

$('.search-submit-btn').click(function(e) {
    $(this).parent().submit();
});

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  if (window.pageYOffset != 0) {
    $('#main-nav').css('background-color', '#141414');
  } else {
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

$('[id=switch-login-modal]').click(function(e) {
    $('#signUpModal').modal('hide');
    $('#loginModal').modal('show');
});

$('[id=switch-signup-modal]').click(function(e) {
    $('#loginModal').modal('hide');
    $('#signUpModal').modal('show');
});

$('#genre-modal-trigger').click(function(e) {
    var genre_left = $(this).offset().left;
    $('#genre-modal .modal-dialog').css('left', genre_left - 1);
});

$('#sort-modal-trigger').click(function(e) {
    var sort_left = $(this).offset().left;
    $('#sort-modal .modal-dialog').css('left', sort_left);
});

$('#date-modal-trigger').click(function(e) {
    var date_left = $(this).offset().left;
    $('#date-modal .modal-dialog').css('left', date_left);
});

$('#duration-modal-trigger').click(function(e) {
    var duration_left = $(this).offset().left;
    $('#duration-modal .modal-dialog').css('left', duration_left);
});

$('.comic-random-nav-item').click(function(e) {
  $.ajax({
    type:'GET',
    url:'/getRandomComic',
    success: function(data){
      window.location.href = '/comic/' + data.id;
    }
  });
});

$(document).ready(function() {
  $('#defaultOpen').click();
  $('.defaultOpen').click();
  var videos_scroll = document.querySelectorAll('.videos-scroll');
  for (var i = 0; i < videos_scroll.length; ++i) {
    var item = videos_scroll[i];  
    var topPos = item.offsetTop;
    item.parentNode.scrollTop = topPos - 185 + item.offsetHeight / 2;
  }
});

$('.show-more-caption').click(function(){
    if ($(this).text() == '顯示完整資訊') {
        $(this).prev().attr('style', 'color: #bdbdbd; font-weight: 400; margin-top: 10px; line-height: 20px;');
        $(this).text('只顯示部分資訊');

    } else if ($(this).text() == '只顯示部分資訊') {
        $(this).prev().attr('style', 'color: #bdbdbd; font-weight: 400; margin-top: 10px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;');
        $(this).text('顯示完整資訊');
    }
});

$('.playitem-delete-btn').on('click', function () {
    var form = $(this).closest("form");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type:"POST",
        url: form.attr("action"),
        data: jQuery.param({ 
            playlist_id: form.find('input[name="playlist-show-id"]').val(),
            video_id: form.find('input[name="playlist-show-video-id"]').val(),
            count: $('#playitems-count').data('count')
        }),
        dataType: 'json',
        success: function(data){
            $('div#playlist-show-video-wrapper-' + data.video_id).remove();
            $('#playitems-count').text(data.count + ' 部影片');
            $('#playitems-count').data('count', data.count);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#playlist-show-video-wrapper-' + data.video_id).html(xhr + ajaxOptions + thrownError);
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('.playlist-show-edit-btn').click(function(){
    var text = $('#playlist-show-edit-btn-text');
    var icon = $('#playlist-show-edit-btn-icon');

    if (text.text() == '編輯影片') {
        text.text('完成編輯');
        icon.text('done');
        $(this).css('background-color', 'crimson');
        $(this).css('border-color', 'crimson');
        $(this).css('color', 'white');
        $('.playitem-delete-form').css('display', 'block');
        $('.playlist-show-links').bind('click', false);

    } else if (text.text() == '完成編輯') {
        text.text('編輯影片');
        icon.text('edit_note');
        $(this).css('background-color', 'white');
        $(this).css('border-color', 'white');
        $(this).css('color', '#222222');
        $('.playitem-delete-form').css('display', 'none');
        $('.playlist-show-links').unbind('click', false);
    }
});

$("form#playlist-show-add-form").submit(function(e) {
    $('.playlist-show-add-btn').prop('disabled', true);
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
            $('.playlist-show-add-btn').replaceWith(data.add_btn);
            $('.playlist-show-add-btn').prop('disabled', false);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('.playlist-show-add-btn').html(xhr + ajaxOptions + thrownError);
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('.preview-images-modal').on('shown.bs.modal', function (event) {
    var modal = '#' + $(this).attr('id');
    var modal_mody = $(modal + ' .modal-body');
    modal_mody.scrollTop(0);

    var image = $(event.relatedTarget).data('image');
    var imageOffset = $(image).position();

    $(modal + ' .modal-body').scrollTop(imageOffset.top - modal_mody.height() / 2 + $(image).height() / 2);
});

$('.trailer-modal-trigger').click(function() {
    var id = $(this).data('target');
    var video = $(id).find('video');
    video.get(0).play();
})

$('.preview-trailer-modal').on('hidden.bs.modal', function (event) {
    var video = $(this).find('video');
    video.get(0).pause();
})

function showSnackbar(text) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerHTML = text;
    snackbar.className = "show";
    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 4000);
}

require('./comment');
require('./comic');
require('./lazyLoad');
require('./videoShow');