
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

$('[id=toggleSearchBar]').click(function(e) {
    var x = document.getElementById("searchBar");
    if (x.style.display === "none") {
        x.style.display = "block";
        document.getElementById("query").focus();
    } else {
        x.style.display = "none";
    }
});

$('#search-submit-btn').click(function(e) {
    $("#search-form").submit();
});

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos || currentScrollPos < 60) {
    document.getElementById("scroll-hide-nav").style.top = "0";
    document.getElementById("scroll-hide-nav2").style.top = "0";
  } else {
    document.getElementById("scroll-hide-nav").style.top = "-50px";
    document.getElementById("scroll-hide-nav2").style.top = "-50px";
  }
  prevScrollpos = currentScrollPos;
}

document.addEventListener("DOMContentLoaded", function() {
  var lazyVideos = [].slice.call(document.querySelectorAll("video.lazy"));

  if ("IntersectionObserver" in window) {
    var lazyVideoObserver = new IntersectionObserver(function(entries, observer) {
      entries.forEach(function(video) {
        if (video.isIntersecting) {
          for (var source in video.target.children) {
            var videoSource = video.target.children[source];
            if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
              videoSource.src = videoSource.dataset.src;
            }
          }

          video.target.load();
          video.target.classList.remove("lazy");
          lazyVideoObserver.unobserve(video.target);
        }
      });
    }, {
      rootMargin: "0px 0px 256px 0px"
    });

    lazyVideos.forEach(function(lazyVideo) {
      lazyVideoObserver.observe(lazyVideo);
    });
  }
});

require('./loadMore');
require('./shareVideo');
require('./toggleVideoDescription');