$('#storeComment').on('submit',function(e){
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
            console.log(data);
            var newComment = '<div id="comment' + data.comment_id + '" class="row"><div class="col-md-1"><a href="/users/' + data.user_id + '"><img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/thumbnails/' + data.avatar_filename + '.jpg" class="img-responsive img-circle"></a></div><div class="col-md-9"><div class="row"><a style="color: black; font-weight: 600" href="/user/' + data.user_id + '">' + data.user_name + '</a></div><div class="row"><p>' + data.comment_text + '</p></div></div><div class="col-md-2 text-right"><small>' + data.comment_created_at + '</small><form id="deleteComment' + data.comment_id + '" action="/order/' + data.order_id + '/comment/' + data.comment_id + '" method="POST" name="delete_item"><input type="hidden" name="_token" value="' + data.csrf_token + '"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger" style="margin-top: 5px; line-height: 15px"><small>Delete</small></button></form></div></div><br>';

            $("#comments-count").text("商品評論 (" + data.comments_count + ")");
            $("#comment-start").prepend(newComment);
            $("#commentBox").val("");
            $("#commentBtn").blur();
        },
        error: function(data){
        	alert("here arrr");
        }
    })
});

$('#comment-start').on("submit", "form[id^='deleteComment']", function(e) {
    $.ajaxSetup({
        header:$('meta[name="_token"]').attr('content')
    })
    e.preventDefault(e);

    $.ajax({
        type:"DELETE",
        url: $(this).attr("action"),
        data:$(this).serialize(),
        dataType: 'json',
        success: function(data){
            console.log(data);
            $("#comments-count").text("商品評論 (" + data.comments_count + ")");
            $("#comment" + data.comment_id).next().remove();
            $("#comment" + data.comment_id).remove();
        },
        error: function(xhr, ajaxOptions, thrownError){
        	$("#comments-count").text(xhr.responseText);
        }
    })
});