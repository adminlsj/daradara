var _throttleTimer = null;
var _throttleDelay = 100;
var $window = $(window);
var $document = $(document);
$document.ready(function () {
    $window
        .off('scroll', ScrollHandler)
        .on('scroll', ScrollHandler);
});

var page = 1; //track user scroll as page number, right now page number is 1
var urlParams = new URLSearchParams(window.location.search);
var query = urlParams.get('query');
var video = urlParams.get('v');
var genre = urlParams.get('g');
load_more(page); //initial content load

function ScrollHandler(e) {
    //throttle event:
    clearTimeout(_throttleTimer);
    _throttleTimer = setTimeout(function () {
        if ($(window).scrollTop() + $(window).height() + 1500 >= getDocHeight()) {
	        page++; //page number increment
			load_more(page); //load content   
	   }
    }, _throttleDelay);
}

function getDocHeight() {
    var D = document;
    return Math.max(
        D.body.scrollHeight, D.documentElement.scrollHeight,
        D.body.offsetHeight, D.documentElement.offsetHeight,
        D.body.clientHeight, D.documentElement.clientHeight
    );
}

function load_more(page){
    $.ajax({
        url: '?v=' + video + '&g=' + genre + '&page=' + page + '&query=' + query,
        type: "get",
        datatype: "html",
    })

    .done(function(data){
        if (data.length == 0){
	        console.log(data.length);
            $('.ajax-loading').html(" ");
            return;
        }

        newDivName = "d" + String(new Date().valueOf());
        var $newhtml = $("<div id='" + newDivName + "'>" + data + "</div>");
        $('#sidebar-results').append($newhtml);

        $('#' + newDivName + ' h5').each(function (index) {
            rank = index + 1 + (page - 1) * 10;
            if (rank < 10) {
                $(this).html('<span style="color:white; background-color:pink; padding: 3px 10px; border-radius:3px;">' + rank + '</span>');
            } else {
                $(this).html('<span style="color:white; background-color:pink; padding: 3px 6px; border-radius:3px;">' + rank + '</span>');
            }
        });

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
}