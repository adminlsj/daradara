const shareButton = document.querySelector('#shareBtn');
shareButton.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title: document.getElementById("shareBtn-title").innerHTML,
      url: window.location.href
    }).then(() => {
      console.log('Thanks for sharing!');
    })
    .catch(console.error);
  } else {
    // fallback
  }
});

var sticky = $('#myHeader');
var stickyHeight = sticky.height();
var stickyOffset = sticky.offset().top;
var commentsTabcontent = $('#comment-tabcontent');
var videosTabcontent = $('#related-tabcontent');
$(window).scroll(function(){
    var scroll = $(window).scrollTop();
    var commentsDisplay = commentsTabcontent.css('display');
    var videosOffset = videosTabcontent.offset().top + videosTabcontent.height();

    if ((scroll + stickyHeight > videosOffset - 83) && commentsDisplay == 'none') {
        sticky.css('position', 'absolute');
        sticky.css('top', videosOffset - stickyHeight - 113);
        sticky.css('width', '100%');
    } else if ((scroll + 68 >= stickyOffset) && commentsDisplay == 'none') {
        sticky.css('position', 'fixed');
        sticky.css('top', '53px');
        sticky.css('width', '100%');
    } else {
        sticky.css('position', '');
        sticky.css('top', '');
        sticky.css('width', '');
    }
});

$('div#video-like-form-wrapper').on("submit", "form#video-like-form", function(e) {
    $('#video-like-btn').prop('disabled', true);
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
            $('div#video-like-form-wrapper').html(data.likeBtn);
            $('#video-like-btn').prop('disabled', false);
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#playlistModal').on("change", "input.playlist-checkbox", function(e) {
    $('input.playlist-checkbox').prop('disabled', true);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type:"POST",
        url: $("form#video-save-form").attr("action"),
        data: jQuery.param({ 
            input_id: $(this).attr('id'), 
            user_id : $("input#playlist-user-id").val(),
            video_id: $("input#playlist-video-id").val(),
            is_checked: $(this).prop('checked')
        }),
        dataType: 'json',
        success: function(data){
            $('div#video-save-form-wrapper').html(data.saveBtn);
            $('input.playlist-checkbox').prop('disabled', false);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#video-save-form-wrapper').html(xhr + ajaxOptions + thrownError);
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$("form#video-create-playlist-form").submit(function(e) {
    $('#video-create-playlist-btn').prop('disabled', true);
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
            $('#createPlaylistModal').modal('toggle');
            $('#playlistModal').modal('toggle');
            $('#playlist-save-checkbox').after(data.checkbox);
            $('div#video-save-form-wrapper').html(data.saveBtn);
            $('#playlist-title').val("");
            $('#playlist-description').val("");
            $('#video-create-playlist-btn').prop('disabled', false);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#video-save-form-wrapper').html(xhr + ajaxOptions + thrownError);
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$("#hide-playlist-btn").click(function() {
    var scroll = $("#playlist-scroll");
    var icon = $("#hide-playlist-btn i");
    if (scroll.css('display') == 'none') {
        scroll.css('display', 'block');
        icon.css('padding-top', '3px');
        icon.html('keyboard_arrow_down');
    } else {
        scroll.css('display', 'none');
        icon.css('padding-top', '2px');
        icon.html('keyboard_arrow_up');
    }
});

$('#others-text').focus(function() {
    $('input:radio[id=others]').prop('checked', true);
});

$('.toggle-playlist-modal').click(function(){
    $('#playlistModal').modal('toggle');
});

$('#create-playlist-btn').click(function(){
    setTimeout(function(){
        $('input#playlist-title').focus();
    });
});

$('input:radio[id=others]').click(function(){
    $('#others-text').focus();
});

$('#player-switch-lang').click(function(){
    var lang = $(this).data("lang");
    if (lang == 'zh-CHT') {
        setCookie('user_lang', 'zh-CHS', 10000);
    } else {
        setCookie('user_lang', 'zh-CHT', 10000);
    }
    window.location.reload();
});

player.on('qualitychange', (event) => {
    setCookie('quality', player.config.quality.selected, 10000);
});

/* Standard syntax */
document.addEventListener("fullscreenchange", function() {
  handleFullscreenChange()
});

/* Firefox */
document.addEventListener("mozfullscreenchange", function() {
  handleFullscreenChange()
});

/* Chrome, Safari and Opera */
document.addEventListener("webkitfullscreenchange", function() {
  handleFullscreenChange()
});

/* IE / Edge */
document.addEventListener("msfullscreenchange", function() {
  handleFullscreenChange()
});

/* function handleFullscreenChange() {
    $("#player-div-wrapper").removeClass('fluid-player-desktop-styles');
} */

function handleFullscreenChange() {
    var videoWrap = $(".dplayer-video-wrap");
    if (videoWrap.css("padding-bottom") == "0px") {
        videoWrap.css("padding-bottom", "56.25%");
    } else {
        videoWrap.css("padding-bottom", "0px");
    }
}

function showSnackbar(text) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerHTML = text;
    snackbar.className = "show";
    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 4000);
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}