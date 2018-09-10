$("[id^='saveJob']").on('submit', function(e) {
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
            if (data.create_save_job) {
                $("#saveJob" + data.job_id).css('display', 'initial');
                $("#saveJobIcon" + data.job_id).css('color', 'rgb(248, 210, 58)');
            } else {
                if($('#selectJobBtn' + data.job_id).css("background-color") == 'rgb(216, 75, 107)') {
                    $("#saveJob" + data.job_id).css('display', 'initial');
                    $("#saveJobIcon" + data.job_id).css('color', 'white');
                } else {
                    $("#saveJob" + data.job_id).css('display', 'none');
                    $("#saveJobIcon" + data.job_id).css('color', 'white');
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(textStatus);
        }
    })
});