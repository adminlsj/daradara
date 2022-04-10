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
            data: { id: $(this).data("foreignid"), type: $(this).data("type") },
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