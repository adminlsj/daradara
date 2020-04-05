<div class="watch-slider" style="position: relative;">
  <div id="custom-scroll-slider" style="background-color: inherit">
    @foreach ($selected as $watch)
      <div style="border-radius: 10px; box-shadow: 1px 4px 6px rgba(0,0,0,0.1); display: inline-block; vertical-align: text-top; margin-right: 5px">
        <a style="text-decoration: none; color: black" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">
          <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 10px; border-top-right-radius: 10px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">

          <div style="height: 47px; padding: 2px 15px;">
            <h4 style="line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-weight: 450; white-space: initial">{{ $watch->title }}</h4>
          </div>
        </a>
      </div>
    @endforeach
  </div>
  <div class="slider-scroll-left no-select"><i style="vertical-align:middle; font-size: 1em; margin-top: -7px; margin-left: 3px" class="material-icons">arrow_back_ios</i></div>
  <div class="slider-scroll-right no-select"><i style="vertical-align:middle; font-size: 1em; margin-top: -7px; margin-left: 1px; {{ $is_mobile ? 'display:none' : '' }}" class="material-icons">arrow_forward_ios</i></div>
</div>