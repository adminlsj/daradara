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