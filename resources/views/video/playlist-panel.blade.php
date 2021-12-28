<div id="video-playlist-wrapper" style="background-color: #303030;">
  <div style="width: 100%; background-color: #3a3c3f; padding: 10px 15px; height: 79px; position: relative;" class="single-icon-wrapper">
    <img style="object-fit: cover; width:58px; height:58px; border-radius: 50%; float: left; border: 2px solid gray" src="{{ strpos($current->cover, 'E6mSQA2') !== false ? $current->user->avatar_temp : $current->cover }}" alt="{{ $current->title }}">
    <h4 style="margin-top: 0px; line-height: 20px; margin-bottom: -5px; font-size: 14px; margin-left: 68px; color: white; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-weight: bold; padding-right: 50px;">{{ $current->watch->title }}</h4>
    <h4 style="font-size: 12px; margin-left: 68px; color: darkgray; font-weight: bold;">{{ $videos->count() }} 部影片</h4>
    <div id="hide-playlist-btn" style="position: absolute; right: 10px; top: 21px; cursor: pointer;" class="single-icon no-select hidden-md hidden-lg">
      <i class="material-icons noselect" style="padding-top: 3px; padding-left: 3px; font-size: 30px; color: white">keyboard_arrow_down</i>
    </div>
  </div>
  <div id="playlist-scroll" class="hover-video-playlist" style="text-align: left; max-height: 370px; overflow-y: scroll; position: relative">
    @foreach ($videos as $video)
      <div style="padding-left: 14px; padding-right: 14px;" class="related-watch-wrap {{ $video->id == $current->id ? 'videos-scroll' : ''}}">
        @include('video.singleShowRelated', ['source' => 'video'])
      </div>
    @endforeach
  </div>
</div>