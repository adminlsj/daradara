$("[id^='selectJobTitle']").click(
    function(e) {
        e.preventDefault();
        $(this).parent().click();
    }
);

$("[id^='selectJobTitle']").on({
    mouseenter: function () {
        if($(this).closest("button").css("background-color") == 'rgb(216, 75, 107)') {
            $(this).css('color', 'rgb(20, 20, 21)');
        } else {
            $(this).css('color', '#97344a');
        }
    },
    mouseleave: function () {
        if($(this).closest("button").css("background-color") == 'rgb(216, 75, 107)') {
            $(this).css('color', 'white');
        } else {
            $(this).css('color', '#d84b6b');
        }
    }
});

$("[id^='selectJobBtn']").on({
    mouseenter: function () {
        if($(this).css('background-color') != 'rgb(216, 75, 107)') {
            $(this).css('background-color', 'pink');
        }
    },
    mouseleave: function () {
        if($(this).css('background-color') != 'rgb(216, 75, 107)') {
            $(this).css('background-color', 'white');
        }
    }
});

$("[id^='selectJob']").on('submit', function(e) {
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
            $("#job-company-name").text(data.company_name);
            $("#job-company-description").text(data.company_description);
            $("#job-title").text(data.job_title);
            $("#job-responsibility").text(data.job_responsibility);
            $("#job-requirement").text(data.job_requirement);

            $("#selectJobBtn" + data.current_id).css("background-color","white");
            $("#selectJobBtn" + data.current_id).css("color","#636b6f");
            $("#selectJobTitle" + data.current_id).css("color","#d84b6b");

            $("#selectJobBtn" + data.job_id).css("background-color","#d84b6b");
            $("#selectJobBtn" + data.job_id).css("color","white");
            $("#selectJobTitle" + data.job_id).css("color","white");
            $("[id^='currentId']").val(data.job_id);
            $("#job_id").val(data.job_id);

            $("#applyBtn").html(data.btn_text);
            $("#applyBtn").prop('disabled', data.disabled);


            if($("#saveJobIcon" + data.current_id).css('color') != 'rgb(248, 210, 58)') {
                $("#saveJob" + data.current_id).css("display","none");
            }
            $("#saveJob" + data.job_id).css("display","initial");
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(textStatus);
        }
    })
});