$(document).on("click", ".load-tag-videos", function(e) {
    var previous = $('.subscribes-tab .active');
    var current = $(this);
    previous.removeClass("active");
    current.addClass('active');

    if (current.text().indexOf("全部") >= 0) {
      $('#home-preload-videos').css('display', 'block');
    } else {
      $('#home-preload-videos').css('display', 'none');
    }

    $('#sidebar-results').css('opacity', '0.3');
    $('.ajax-loading').html('<img style="width: 40px; height: auto; margin: 0; position: absolute; top: 150px; left: 50%; transform: translate(-50%, -50%);" src="https://i.imgur.com/wgOXAy6.gif"/>');
    $('.ajax-loading-default').html('<img style="width: 40px; height: auto; padding-top: 20px; padding-bottom: 50px;" src="https://i.imgur.com/wgOXAy6.gif"/>');

    var _throttleTimer = null;
    var _throttleDelay = 100;
    var $window = $(window);
    var $document = $(document);
    $window.off('scroll', ScrollHandler).on('scroll', ScrollHandler);
    $(document).on("click", ".load-tag-videos", function(e) {
        $window.off('scroll', ScrollHandler);
    });

    var tag = current.text().replace('#', '');
    var page = 1; //track user scroll as page number, right now page number is 1
    load_more(tag, page); //initial content load

    function ScrollHandler(e) {
      //throttle event:
      clearTimeout(_throttleTimer);
      _throttleTimer = setTimeout(function () {
          if ($(window).scrollTop() + $(window).height() + 1500 >= getDocHeight()) {
            page++; //page number increment
            load_more(tag, page); //load content
          }
      }, _throttleDelay);
    }
});

$(document).ready(function () {
  $('#default-tag').click();
});

function load_more(tag, page){
    $.ajax({
        type:'GET',
        url: window.location.pathname + '/loadTagList?tag=' + tag + '&page=' + page,
        datatype: "html",
    })

    .done(function(data){
        if (data.length == 0){
          $('.ajax-loading').html(" ");
          $('.ajax-loading-default').html(" ");
          return;
        }

        newDivName = "d" + String(new Date().valueOf());
        var $newhtml = $("<div id='" + newDivName + "'>" + data + "</div>");
        if (page == 1) {
          $('#sidebar-results').html($newhtml);
          $('#sidebar-results').css('opacity', '1');
          $('.ajax-loading').html(" ");
        } else {
          $('#sidebar-results').append($newhtml);
        }

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

function getDocHeight() {
    var D = document;
    return Math.max(
        D.body.scrollHeight, D.documentElement.scrollHeight,
        D.body.offsetHeight, D.documentElement.offsetHeight,
        D.body.clientHeight, D.documentElement.clientHeight
    );
}