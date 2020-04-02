@if ($is_mobile)
  <div id="custom-scroll-slider">
    @foreach ($selected as $watch)
      <div style="border-radius: 10px; box-shadow: 1px 4px 6px rgba(0,0,0,0.1); width: 150px !important; background: #fff; display: inline-block; vertical-align: text-top;">
        <a style="text-decoration: none; color: black" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">
          <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 10px; border-top-right-radius: 10px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">

          <div style="height: 47px; padding: 2px 15px;">
            <h4 style="line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-weight: 450; white-space: initial">{{ $watch->title }}</h4>
          </div>
        </a>
      </div>
    @endforeach
  </div>

@else
  <div id="custom-scroll-slider" style="position: relative;">
    @foreach ($selected as $watch)
      @if ($loop->iteration <= 6)
        <div style="border-radius: 10px; box-shadow: 1px 4px 6px rgba(0,0,0,0.1); width: calc((100% - 190px) / 6) !important; background: #fff; display: inline-block; vertical-align: text-top;">
          <a style="text-decoration: none; color: black" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">
            <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 10px; border-top-right-radius: 10px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">

            <div style="height: 47px; padding: 2px 15px;">
              <h4 style="line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-weight: 450; white-space: initial">{{ $watch->title }}</h4>
            </div>
          </a>
        </div>
      @endif
      @if ($loop->iteration == 7)
        <a href="{{ route('video.varietyList') }}" style="color:black; width: 64px; height:64px; background-color: white; box-shadow: 1px 4px 6px rgba(0,0,0,0.1); border-radius: 50%; text-align: center; position: absolute; top:calc(50% - 35px); right: 30px">
          <i style="vertical-align:middle; font-size: 2em; margin-top: 19px; margin-left: 3px;" class="material-icons">arrow_forward_ios</i>
        </a>
      @endif
    @endforeach
  </div>
  
@endif