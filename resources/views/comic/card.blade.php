<div class="comic-rows-videos-div" style="position: relative; display: inline-block; margin-bottom: 0px; vertical-align: top;">
  <a style="text-decoration: none;" href="{{ route('comic.showCover', ['comic' => $comic->id]) }}">
  <img class="lazy" style="border-top-left-radius: 5px; border-top-right-radius: 5px;" src="https://i.imgur.com/0n3iJ9Ol.jpg" data-srcset="{{ $comic->nhentai_id ? 'https://t.nhentai.net/galleries/'.$comic->galleries_id.'/cover.'.$comic->extension : $comic->prefix.'000.'.$comic->extension }}">
  <div style="position: relative; height: 51px;">
    <div class="comic-rows-videos-title">{{ $comic->title_n_before }} {{ $comic->title_n_pretty }} {{ $comic->title_n_after }}</div>
  </div>
  </a>
</div>