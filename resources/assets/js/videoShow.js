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

$('[id=toggleVideoDescription]').click(function(e) {
    var description = document.getElementById("videoDescription");
    var videoTags = document.getElementById("video-tags");
    var icon = document.getElementById("toggleVideoDescriptionIcon");
    if (description.style.display === "none") {
        description.style.display = "block";
        icon.innerHTML = 'expand_less';
    } else {
        description.style.display = "none";
        icon.innerHTML = 'expand_more';
    }
});

$('[id=toggle-subscribe-tags]').click(function(e) {
    var wrapper = $("#subscribe-tags-wrapper");
    var icon = $("#toggle-subscribe-tags-icon");
    if (wrapper.css('height') == 'auto') {
        wrapper.css('height', '34px');
        icon.html('expand_more');
    } else {
        wrapper.css('height', 'auto');
        icon.html('expand_less');
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
            $('div#video-like-form-wrapper').html(data.unlikeBtn);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#video-like-form-wrapper').html(xhr.responseText);
        }
    })
});

$('div#video-like-form-wrapper').on("submit", "form#video-unlike-form", function(e) {
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
            $('div#video-like-form-wrapper').html(xhr.responseText);
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
            showSnackbar('影片已儲存於「訂閱」項目');
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#video-save-form-wrapper').html(xhr.responseText);
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
            $('div#video-save-form-wrapper').html(xhr.responseText);
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
            $('div#comment-create-form-wrapper').html(xhr.responseText);
        }
    })
});

$("#comment-icon").click(function() {
    if (is_mobile) {
      $('html, body').animate({
          scrollTop: $('#comment-create-form-wrapper').offset().top - 15
      }, 'slow');
    } else {
      $('html, body').animate({
          scrollTop: $('#comment-create-form-wrapper').offset().top - 65
      }, 'slow');
    }
});

$(document).ready(function(){
    var urlParams = new URLSearchParams(window.location.search);
    $.ajax({ 
        type:"GET",
        url: "/loadPlaylist",
        data: {v: urlParams.get('v')},
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

function handleFullscreenChange() {
  if (!is_mobile) {
    var videoWrap = $(".dplayer-video-wrap");
    if (videoWrap.css("padding-bottom") == "0px") {
        videoWrap.css("padding-bottom", "56.25%");
    } else {
        videoWrap.css("padding-bottom", "0px");
    }
  }
}

function showSnackbar(text) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerHTML = text;
    snackbar.className = "show";
    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 4000);
}