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