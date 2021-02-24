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

$("#comment-icon").click(function() {
    $(".alert-circle").css('display', 'none');
    $("#comment-section-wrapper").css('display', 'block');
    if (!is_mobile) {
        $("#comment-text").focus();
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

/* $(document).ready(function(){
    var urlParams = new URLSearchParams(window.location.search);
    $.ajax({ 
        type:"GET",
        url: "/loadPlaylist",
        data: {v: urlParams.get('v'), list: urlParams.get('list')},
        dataType: 'html',
        success: function(data){
            $('.ajax-loading').html(" ");
            $('div#video-playlist-wrapper').html(data);

            var container = document.querySelector('div#video-playlist-wrapper');
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
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#video-playlist-wrapper').html(xhr.responseText);
        }
    });

    $.ajax({ 
        type:"GET",
        url: "/getVideoSd",
        data: {v: urlParams.get('v')},
        dataType: 'json',
        success: function(data){
            if (data.outsource) {
                $('iframe#iframe').attr("src", data.sd);
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#video-playlist-wrapper').html(xhr.responseText);
        }
    });
}); */

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
    var videoWrap = $(".dplayer-video-wrap");
    if (videoWrap.css("padding-bottom") == "0px") {
        videoWrap.css("padding-bottom", "56.25%");
    } else {
        videoWrap.css("padding-bottom", "0px");
    }
} */

function showSnackbar(text) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerHTML = text;
    snackbar.className = "show";
    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 4000);
}