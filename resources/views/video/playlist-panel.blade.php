<div id="video-playlist-wrapper" style="background-color: #181818; border-radius: 10px; border: 1px solid #333333">
  <div style="width: 100%; background-color: #2E2E2E; padding: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px;" class="single-icon-wrapper">
    <h4 style="margin-top: 0px; line-height: 20px; margin-bottom: -5px; font-size: 14px; color: white; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-weight: bold;">{{ $current->watch->title }}</h4>
    <h4 style="font-size: 12px; color: darkgray; font-weight: bold; margin-bottom: 4px;">{{ $videos->count() }} 部影片</h4>
    <div id="hide-playlist-btn" style="position: absolute; right: 10px; top: 21px; cursor: pointer;" class="single-icon no-select hidden-md hidden-lg">
      <i class="material-icons noselect" style="padding-top: 3px; padding-left: 3px; font-size: 30px; color: white">keyboard_arrow_down</i>
    </div>
  </div>

  <div id="playlist-scroll" class="hover-video-playlist" style="text-align: left; max-height: 370px; overflow-y: scroll; position: relative;">
    @foreach ($videos as $video)
      <div style="padding: 10px 10px;" class="related-watch-wrap multiple-link-wrapper {{ $video->id == $current->id ? 'videos-scroll' : ''}}">
        <a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
        @include('video.singleShowRelated', ['source' => 'video'])
      </div>
    @endforeach
  </div>
</div>