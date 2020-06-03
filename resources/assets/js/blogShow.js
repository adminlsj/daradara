$(document).ready(function(){
    var urlParams = new URLSearchParams(window.location.search);
    $.ajax({ 
        type:"GET",
        url: "/loadBloglist",
        data: {r: urlParams.get('r')},
        dataType: 'html',
        success: function(data){
            $('.ajax-loading').html(" ");
            $('div#blog-playlist-wrapper').html(data);

            var container = document.querySelector('div#blog-playlist-wrapper');
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
        },
        error: function(xhr, ajaxOptions, thrownError){
            $('div#blog-playlist-wrapper').html(xhr.responseText);
        }
    });
});