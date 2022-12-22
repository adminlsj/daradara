<div class="card-mobile-panel inner">
  <div style="width: 150px; display: inline-block;">
    <div style="position: relative; display: inline-block;">
      <img style="width: 100%; height: 100%; border-radius: 5px;" src="https://i.imgur.com/D1l0JoC.jpg">
      <img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 5px; {{ $video->id == $current->id ? 'filter: brightness(15%);' : '' }}" src="{{ $video->thumbL() }}" alt="{{ $video->title }}">

      @if ($video->id == $current->id)
        <div style="margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #e5e5e5;">現正播放</div>
      @endif
    </div>
  </div>

  <div style="display: inline-block; text-decoration: none; color: black; margin-top: -2px; margin-left: 8px; height: 50px; width: calc(100% - 168px); vertical-align: top;">
    <div class="card-mobile-title" style="color: #e5e5e5;">{{ str_replace("[".$video->user->name."] ", "", $video->title) }}</div>

    <div class="card-mobile-genre-wrapper" style="margin-top: 4px; margin-left: -2px">
      <a href="{{ route('home.search') }}?query={{ $video->user->name }}" style="font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user">{{ $video->user->name }}</a>
    </div>

    <div style="float: left; margin-top: -3px;">
      @if ($video->duration != null)
          <div class="card-mobile-duration" style="background: #2E2E2E; padding: 0px 4px; color: #b8babc;line-height: 19px;">
            {{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
          </div>
        @endif

        <div class="card-mobile-duration" style="background: #2E2E2E; padding: 0px 4px; margin-right: 5px; color: #b8babc; line-height: 19px;">
          {{ $video->views() }}次
        </div>
    </div>
  </div>
</div>