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
var commentsTabcontent = $('#Paris');
var videosTabcontent = $('#London');
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
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#video-save-form-wrapper').on("submit", "form#video-save-form", function(e) {
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
            $('div#video-save-form-wrapper').html(data.unsaveBtn);
            showSnackbar('影片已儲存於「我的清單」');
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#video-save-form-wrapper').on("submit", "form#video-unsave-form", function(e) {
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
            $('div#video-save-form-wrapper').html(data.saveBtn);
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#comment-create-form-wrapper').on("submit", "form#comment-create-form", function(e) {
    $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
    })
    e.preventDefault(e);
    document.activeElement.blur();

    $.ajax({
        type:"POST",
        url: $(this).attr("action"),
        data:$(this).serialize(),
        dataType: 'json',
        success: function(data){
            $('#comment-text').val('');
            $('div#comment-start').prepend(data.single_video_comment);
            $('#comment-count').html(data.comment_count);
            if (is_mobile) {
              $('html, body').animate({
                  scrollTop: $('#comment-create-form-wrapper').offset().top - 15
              }, 'slow');
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('.comment-reply-reply-form-wrapper').on("submit", ".comment-reply-create-form", function(e) {
    $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
    })
    e.preventDefault(e);
    document.activeElement.blur();

    $.ajax({
        type:"POST",
        url: $(this).attr("action"),
        data:$(this).serialize(),
        dataType: 'json',
        success: function(data){
            $(".comment-reply-reply-form-wrapper").css('display', 'none');
            $('div#reply-start-' + data.comment_id).prepend(data.single_video_comment);
        },
        error: function(xhr, ajaxOptions, thrownError){
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

$('div#comment-like-form-wrapper').on("submit", "form#comment-like-form", function(e) {
    $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
    })
    e.preventDefault(e);

    $.ajax({
        type:"POST",
        url: $(this).attr("action"),
        data:$(this).serialize(),
        dataType: 'json',
        success: (json) => {
            $(this).find('button').html(json.comment_like_btn);
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#comment-like-form-wrapper').on("submit", "form#comment-unlike-form", function(e) {
    $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
    })
    e.preventDefault(e);

    $.ajax({
        type:"POST",
        url: $(this).attr("action"),
        data:$(this).serialize(),
        dataType: 'json',
        success: (json) => {
            $(this).find('button').html(json.comment_unlike_btn);
            $('#comment-like-btn-' + json.comment_id).html(json.comment_like_btn);
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#comment-like-form-wrapper').on("submit", "form#reply-unlike-form", function(e) {
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
            $('#reply-unlike-btn-' + data.reply_id).html(data.reply_unlike_btn);
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('.comment-reply-btn').click(function() {
    $(".comment-reply-reply-form-wrapper").css('display', 'none');
    var comment_id = $(this).data("comment-id");
    var comment_wrapper = $('#comment-reply-form-wrapper-' + comment_id);
    var comment_text = comment_wrapper.find('#reply-comment-text');
    var comment_user = false;
    if (comment_user = $(this).data("comment-user")) {
        comment_text.val('@' + comment_user + ' ');
    } else {
        comment_text.val('');
    }
    comment_wrapper.css('display', 'block');
    comment_text.focus();
})

$('#others-text').focus(function() {
    $('input:radio[id=others]').prop('checked', true);
});

$('input:radio[id=others]').click(function(){
    $('#others-text').focus();
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