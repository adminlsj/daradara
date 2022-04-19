<div class="comic-rows-videos-div col-xs-4 col-sm-4 col-md-2" style="position: relative; margin-bottom: 0px; vertical-align: top; padding: 0 2px;">
  <a style="text-decoration: none;" href="{{ route('comic.showCover', ['comic' => $comic->id]) }}">
  <img class="lazy" style="border-top-left-radius: 5px; border-top-right-radius: 5px;" src="https://i.imgur.com/0n3iJ9Ol.jpg" data-srcset="https://t.nhentai.net/galleries/{{ $comic->galleries_id }}/cover.{{ $comic->extension }}">
  <div style="position: relative; height: 51px;">
    <div class="comic-rows-videos-title">{{ $comic->title_n_before }} {{ $comic->title_n_pretty }} {{ $comic->title_n_after }}</div>
  </div>
  </a>
</div>

<!-- <div class="col-xs-4 col-sm-4 col-md-2" style="padding: 0 2px;">
  <a style="text-decoration: none;" href="{{ route('comic.showCover', ['comic' => $comic->id]) }}">
  <img style="width: 100%;" class="lazy" style="border-top-left-radius: 5px; border-top-right-radius: 5px;" src="https://i.imgur.com/0n3iJ9Ol.jpg" data-srcset="https://t.nhentai.net/galleries/{{ $comic->galleries_id }}/cover.{{ $comic->extension }}">
  <div style="position: relative; height: 51px;">
    <div class="comic-rows-videos-title">{{ $comic->title_n_before }} {{ $comic->title_n_pretty }} {{ $comic->title_n_after }}</div>
  </div>
  </a>
</div> -->
