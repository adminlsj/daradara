$(document).on("click", ".load-home-tag-videos", function(e) {
    var parent = $(this).parent();
    if (parent.hasClass('home-anime-wrapper')) {
      var genre = 'anime';
    }
    if (parent.hasClass('home-artist-wrapper')) {
      var genre = 'artist';
    }
    if (parent.hasClass('home-youtuber-wrapper')) {
      var genre = 'youtuber';
    }

    var previous = $('.home-' + genre + '-wrapper .active');
    var current = $(this);
    previous.removeClass("active");
    current.addClass('active');

    $('#sidebar-' + genre + '-results').css('opacity', '0.5');
    $('.ajax-' + genre + '-loading').html('<img style="width: 40px; height: auto; margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" src="https://i.imgur.com/TcZjkZa.gif"/>');

    $.ajax({
        type:'GET',
        url:'/loadHomeTagList?tag=' + current.text().replace('#', '') + '&genre=' + genre,
        datatype: "html",
    })

    .done(function(data){
        $('.ajax-' + genre + '-loading').html(" ");

        newDivName = "d" + String(new Date().valueOf());
        var $newhtml = $("<div id='" + newDivName + "'>" + data + "</div>");
        $('#sidebar-' + genre + '-results').html($newhtml);
        $('#sidebar-' + genre + '-results').css('opacity', '1');

        var container = document.querySelector("#" + newDivName);
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
    })

    .fail(function(jqXHR, ajaxOptions, thrownError){
    });
});

$(document).ready(function () {
  $('#default-anime-tag').click();
  $('#default-artist-tag').click();
  $('#default-youtuber-tag').click();
});