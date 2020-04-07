<div class="{{ $watch->genre == 'variety' ? 'watch-variety' : 'watch-single' }} {{ Request::is('*subscribes*') ? 'watch-index-white-theme' : 'watch-index-dark-theme' }}">
  <div style="border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
    <a style="text-decoration: none;" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">

      <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-top-right-radius: 3px; padding-top: 1px; padding-left: 1px; padding-right: 1px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">

      <div style="height: 47px; padding: 0px 8px;">
        <div style="margin-top: -29px;float: right; margin-right: -3px">
          <span style="background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px; font-weight: 500">
            @if ($watch->genre == 'variety')
              {{ Carbon\Carbon::parse($watch->updated_at)->diffForHumans() }}更新
            @else
              {{ explode(' ', $watch->videos()->last()->title())[0] }}
            @endif
          </span>
        </div>
        <h4 style="margin-top:6px; line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: {{ $watch->genre == 'variety' ? 1 : 2 }}; -webkit-box-orient: vertical; font-weight: 500;">{{ $watch->title }}</h4>

        <p style="margin-top: -6px; margin-bottom: 2px; font-size: 0.8em; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; {{ $watch->genre == 'variety' ? '' : 'display:none;' }}">
          {{ $watch->cast }}
        </p>
      </div>
    </a>
  </div>
</div>