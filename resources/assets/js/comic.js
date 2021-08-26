$(document).ready(function() {
  /* var zoom = typeof Cookies.get('zoom') === 'undefined' ? 1 : parseInt(Cookies.get('zoom'));
  var image = $('#current-page-image');
  if (zoom > 1) {
    var new_width = image.width() * zoom;
    if (new_width > 0 && new_width < $(window).width()) {
      image.css('width', new_width);
    } else {
      image.css('width', $(window).width());
    }
    image.css('height', '100%');
    image.css('max-height', '100%');
  } */

  $("html").animate(
    {
      scrollTop: $("#comic-content-wrapper").offset().top
    },
    500 //speed
  );
});

$('.comic-show-content-nav-item-wrapper').on('click', function(e) {
  e.preventDefault();

  var galleries_id = $('.comic-show-content-nav').attr('data-id');
  var page = parseInt($(this).attr('data-page'));
  $('.current-page-number').html(page);

  var base = window.location.pathname;
  base = base.split('/');
  base.pop();
  base = base.join('/') + '/';
  var string = base + page;
  window.history.replaceState(page, 'Hanime1.me', string);

  var arrow_left = $('.arrow-left');
  var fast_rewind = $('.fast-rewind');
  if (page == 1) {
    arrow_left.addClass('comic-nav-hidden');
    fast_rewind.addClass('comic-nav-hidden');
    arrow_left.attr('data-page', page);
    arrow_left.attr('href', base + page);
  } else {
    arrow_left.removeClass('comic-nav-hidden');
    fast_rewind.removeClass('comic-nav-hidden');
    arrow_left.attr('data-page', page - 1);
    arrow_left.attr('href', base + (page - 1));
  }

  var arrow_right = $('.arrow-right');
  var fast_forward = $('.fast-forward');
  if (page == $('.comic-show-content-nav').attr('data-pages')) {
    arrow_right.addClass('comic-nav-hidden');
    fast_forward.addClass('comic-nav-hidden');
    arrow_right.attr('data-page', page);
    arrow_right.attr('href', base + page);
  } else {
    arrow_right.removeClass('comic-nav-hidden');
    fast_forward.removeClass('comic-nav-hidden');
    arrow_right.attr('data-page', page + 1);
    arrow_right.attr('href', base + (page + 1));
  }

  var image = $('#current-page-image');
  var extensions = window.extensions;
  var parseExt = {'j': 'jpg', 'p': 'png'};
  var url = 'https://i.nhentai.net/galleries/' + galleries_id + '/' + page + '.' + parseExt[extensions[page - 1]];
  image.css('filter', 'brightness(0%)');
  image.attr('src', url);
  image.on("load", function() {
      image.css('filter', 'brightness(100%)');
  });

  $('html').scrollTop( $("#comic-content-wrapper").offset().top);

  for (i = 1; i <= 3; i++) {
    var new_page = page + i;
    var preload = new Image();
    preload.src = 'https://i.nhentai.net/galleries/' + galleries_id + '/' + new_page  + '.' + parseExt[extensions[new_page - 1]];
  }
});

$("html").keydown(function(e){
  if(e.keyCode == 37) { // left
    $("a.comic-show-content-nav-item-wrapper.arrow-left")[0].click();
  }
  else if(e.keyCode == 39) { // right
    $("a.comic-show-content-nav-item-wrapper.arrow-right")[0].click();
  }
});

$('#current-page-image').on('click', function(e) {
  let center = $(this).width() / 2;
  if (e.offsetX < center) {
    $("a.comic-show-content-nav-item-wrapper.arrow-left")[0].click();
  } else {
    $("a.comic-show-content-nav-item-wrapper.arrow-right")[0].click();
  }
});

$('#show-more-comics-btn').on('click', function(e) {
  var hidden = $('.comics-thumbnail-wrapper .hidden');
  if (hidden.length <= 30) {
    hidden.removeClass('hidden');
    $('#comics-thumbnail-show-btn-wrapper').hide();
  } else {
    hidden.slice(0, 30).removeClass('hidden');
  }
});

$('#show-all-comics-btn').on('click', function(e) {
  var hidden = $('.comics-thumbnail-wrapper .hidden');
  hidden.removeClass('hidden');
  $('#comics-thumbnail-show-btn-wrapper').hide();
});

/* $('.comics-content-zoom-out').on('click', function(e) {
  var zoom = typeof Cookies.get('zoom') === 'undefined' ? 1 : parseInt(Cookies.get('zoom'));
  var image = $('#current-page-image');
  var max_height = $(window).height() - 38;
  if (image.height() > max_height && zoom > 1) {
    zoom = zoom - 1;
  }
  var new_height = max_height * zoom;
  if (new_height < max_height) {
    image.css('max-height', max_height);
  } else {
    image.css('max-height', new_height);
  }
  image.css('width', 'auto');
  $('.zoom-ratio').html(zoom + '.0x')
  Cookies.set('zoom', zoom, { expires: 365 });
});

$('.comics-content-zoom-in').on('click', function(e) {
  var zoom = typeof Cookies.get('zoom') === 'undefined' ? 1 : parseInt(Cookies.get('zoom'));
  var image = $('#current-page-image');
  if (image.width() < $(window).width()) {
    zoom = zoom + 1;
  }
  var new_width = image.width() / (zoom - 1) * zoom;
  if (new_width > $(window).width()) {
    image.css('width', $(window).width());
  } else {
    image.css('width', new_width);
  }
  image.css('height', 'auto');
  image.css('max-height', '100%');
  $('.zoom-ratio').html(zoom + '.0x')
  Cookies.set('zoom', zoom, { expires: 365 });
}); */

$('.comic-rows-wrapper .comic-rows-videos-div').on({ 'touchstart' : function(){
  $(this).find('.comic-rows-videos-title').addClass('active');
}});

$('.comic-rows-wrapper .comic-rows-videos-div').on({ 'touchend' : function(){
  $(this).find('.comic-rows-videos-title').removeClass('active');
}});