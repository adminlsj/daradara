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
        videoTags.classList.remove("text-ellipsis");
        icon.innerHTML = 'expand_less';
    } else {
        description.style.display = "none";
        videoTags.classList.add("text-ellipsis");
        icon.innerHTML = 'expand_more';
    }
});

$(".dplayer-full-icon, .dplayer-full-in-icon").on('click', function(event){
  if (!is_mobile) {
    var videoWrap = $(".dplayer-video-wrap");
    if (videoWrap.css("padding-bottom") == "0px") {
        videoWrap.css("padding-bottom", "56.25%");
    } else {
        videoWrap.css("padding-bottom", "0px");
    }
  }
});