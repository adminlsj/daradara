<div class="col-xs-6 col-sm-3 col-md-3 hover-opacity-all load-more-wrapper" style="position: relative;">
    <a style="text-decoration: none; color: black" href="{{ route('video.playlist') }}?list={{ $watch->id }}">
      <img class="lazy" style="width: 100%; height: 100%;" src="https://i.imgur.com/JMcgEkPl.jpg" data-src="{{ $first ? $first->imgurH() : 'https://i.imgur.com/JMcgEkPl.jpg' }}" data-srcset="{{ $first ? $first->imgurH() : 'https://i.imgur.com/JMcgEkPl.jpg' }}" alt="{{ $watch->title }}">
      <span>
        <div style="margin: 0;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
          <div>{{ $watch->videos()->count() }}</div>
          <i style="font-size: 1.6em; margin-right: -2px" class="material-icons">playlist_play</i>
        </div>
      </span>

      <div class="hover-underline">
        <h4 style="padding-right: 10px" class="text-ellipsis">{{ $watch->title }}</h4>
      </div>
    </a>
</div>