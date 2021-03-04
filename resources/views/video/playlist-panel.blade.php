<div id="video-playlist-wrapper" style="background-color: #303030;">
  <div style="width: 100%; background-color: #3a3c3f; padding: 10px 15px; height: 79px">
    <img style="object-fit: cover; width:58px; height:58px; border-radius: 50%; float: left; border: 2px solid gray" src="{{ $current->cover }}" alt="{{ $current->title }}">
    <h4 style="font-size: 14px; margin-left: 68px; color: white; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-weight: bold">{{ $watch->title }}</h4>
    <h4 style="font-size: 12px; margin-left: 68px; color: darkgray; font-weight: bold;">{{ $watch->videos_count }} 部影片</h4>
  </div>
  <div id="playlist-scroll" class="hover-video-playlist" style="text-align: left; max-height: 370px; overflow-y: scroll; position: relative">
    @foreach ($videos as $video)
      <div id="{{ $video->id == $current->id ? 'current' : ''}}" class="related-watch-wrap">
        @include('video.singleShowRelated', ['source' => 'video'])
      </div>
    @endforeach
  </div>
</div>