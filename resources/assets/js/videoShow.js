const shareButton = document.querySelector('#shareBtn');
shareButton.addEventListener('click', event => {
  if (navigator.share) {
    navigator.share({
      title: document.getElementById("shareBtn-title").innerHTML,
      url: document.getElementById("shareBtn-link").href
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
    var icon = document.getElementById("toggleVideoDescriptionIcon");
    if (description.style.display === "none") {
        description.style.display = "block";
        icon.innerHTML = 'expand_less';
    } else {
        description.style.display = "none";
        icon.innerHTML = 'expand_more';
    }
});