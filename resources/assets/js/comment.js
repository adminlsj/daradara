// $('div#content-div').on("click", ".tablinks", function(e) {
$(".tablinks").click(function() {
    var content = $(this).data("tabcontent");
    $('.tablinks').removeClass("active");
    $(this).addClass("active");
    $('.tabcontent').css('display', 'none');
    $('#' + content).css('display', 'block');
    if (content == 'comment-tabcontent') {
        $('button.comment-tablinks').data('tabcontent', 'comment-tabcontent-loaded');
        $('div#comment-tabcontent').attr('id', 'comment-tabcontent-loaded');
        $.ajax({
            type:'GET',
            url:'/loadComment',
            data: { id: $(this).data("foreignid"), type: $(this).data("type"), content: this.id },
            success: function(data){
                $('div#comment-section-wrapper').html(data.comments);
                $('#' + data.content).click();
            },
            error: function(xhr, ajaxOptions, thrownError){
                showSnackbar('請刷新頁面後重試。');
            }
        });
    }

    $comments = $('#comment-start');
    $input_comments_count = $('input#comment-count');
    $comment_placeholder = $('input#comment-text');
    $comment_signup_placeholder = $('input#comment-signup-modal');
    if (this.id == 'comment-tablink') {
        $comments.css('display', 'block');
        $input_comments_count.val($('span#tab-comments-count').html());
        $comment_placeholder.attr('placeholder', '新增一則公開評論...');
        $comment_signup_placeholder.attr('placeholder', '新增一則公開評論...');
    }
});

$('div#comment-section-wrapper').on("submit", "form#comment-create-form", function(e) {
    $('#comment-create-btn').prop('disabled', true);
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
            $('input#comment-count').val(data.comment_count);
            $('#comment-create-btn').prop('disabled', false);
            if (is_mobile) {
              $('html, body').animate({
                  scrollTop: $('#comment-create-form-wrapper').offset().top - 15
              }, 'slow');
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('#comment-create-btn').prop('disabled', false);
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#comment-section-wrapper').on("submit", ".comment-reply-create-form", function(e) {
    $('.comment-reply-create-btn').prop('disabled', true);
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
            $('.comment-reply-create-btn').prop('disabled', false);
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('.comment-reply-create-btn').prop('disabled', false);
            showSnackbar('請刷新頁面後重試。');
        }
    })
});

$('div#comment-section-wrapper').on("submit", "form.comment-like-form", function(e) {
    $('.comment-like-btn').prop('disabled', true);
    $('.comment-unlike-btn').prop('disabled', true);
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
            $(this).find('.comment-like-btn-wrapper').html(json.comment_like_btn);
            $('.comment-like-btn').prop('disabled', false);
            $('.comment-unlike-btn').prop('disabled', false);
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
    $(this).find('.material-icons').text('arrow_drop_up');
    $(this).find('.reply-btn-text').text('隱藏');
    $(this).addClass('hide-replies-btn').removeClass('load-replies-btn');
    $(this).next().css('display', 'block');
    $.ajax({
        type:'GET',
        url:'/loadReplies',
        data: { id: $(this).data("commentid") },
        success: function(data){
            $('div#reply-section-wrapper-' + data.comment_id).html(data.replies);
            $('.comment-reply-ajax-loading').css('display', 'none');
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