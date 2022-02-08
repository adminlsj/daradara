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

$(".tablinks").click(function() {
    var id = $(this).data("tabcontent");
    $('.tablinks').removeClass("active");
    $(this).addClass("active");
    $('.tabcontent').css('display', 'none');
    $('#' + id).css('display', 'block');
    if (id == 'comment-tabcontent') {
        $.ajax({
            type:'GET',
            url:'/loadComment',
            data: { id: $(this).data("videoid") },
            success: function(data){
                $('button#comment-tablink').data('tabcontent', 'comment-tabcontent-loaded');
                $('div#comment-tabcontent').attr('id', 'comment-tabcontent-loaded');
                $('div#comment-section-wrapper').html(data.comments);
            },
            error: function(xhr, ajaxOptions, thrownError){
                showSnackbar('請刷新頁面後重試。');
            }
        });

    }
});

$('div#comment-section-wrapper').on("click", "div.load-replies-btn", function(e) {
    $.ajax({
        type:'GET',
        url:'/loadReplies',
        data: { id: $(this).data("commentid") },
        success: function(data){
            var wrapper = $('div#reply-section-wrapper-' + data.comment_id);
            var button = wrapper.parent().find('.load-replies-btn');
            button.find('.material-icons').text('arrow_drop_up');
            button.find('.reply-btn-text').text('隱藏');
            button.addClass('hide-replies-btn').removeClass('load-replies-btn');
            wrapper.html(data.replies);
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    });
});

$('div#comment-section-wrapper').on("click", "div.hide-replies-btn", function(e) {
    var wrapper = $(this).parent().find('.reply-section-wrapper');
    wrapper.toggle();
    if (wrapper.css('display') == 'none') {
        $(this).find('.material-icons').text('arrow_drop_down');
        $(this).find('.reply-btn-text').text('查看');
    } else {
        $(this).find('.material-icons').text('arrow_drop_up');
        $(this).find('.reply-btn-text').text('隱藏');
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
            $('div#video-save-form-wrapper').html(data.saveBtn);
            showSnackbar('影片已儲存於「我的清單」');
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#comment-section-wrapper').on("submit", "form#comment-create-form", function(e) {
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
            $('span#tab-comments-count').html(data.comment_count);
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

$('div#comment-section-wrapper').on("submit", ".comment-reply-create-form", function(e) {
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
            $('div#comment-reply-wrapper-' + data.comment_id).prepend(data.single_video_comment);
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

$('div#comment-section-wrapper').on("submit", "form#comment-like-form", function(e) {
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
            $(this).find('#comment-like-btn-wrapper').html(json.comment_like_btn);
        },
        error: function(xhr, ajaxOptions, thrownError){
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#comment-section-wrapper').on("click", ".comment-like-btn", function() {
    $(this).parent().parent().find('#is_positive').val(1);
});

$('div#comment-section-wrapper').on("click", ".comment-unlike-btn", function() {
    $(this).parent().parent().find('#is_positive').val(0);
});

$('div#comment-section-wrapper').on("click", ".comment-reply-btn", function() {
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

$('#show-more-caption').click(function(){
    if ($(this).text() == '顯示完整資訊') {
        $('#caption').attr('style', 'color: #bdbdbd; font-weight: 400; margin-top: 10px; line-height: 20px;');
        $(this).text('只顯示部分資訊');

    } else if ($(this).text() == '只顯示部分資訊') {
        $('#caption').attr('style', 'color: #bdbdbd; font-weight: 400; margin-top: 10px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;');
        $(this).text('顯示完整資訊');
    }
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