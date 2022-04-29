<div id="playlist-show-video-wrapper-{{ $video->id }}" class="home-rows-videos-div col-xs-4 col-sm-3 col-md-2 col-lg-2" style="position: relative; display: inline-block; margin-bottom:50px;">

  <div style="position: relative;">
    <a class="playlist-show-links" style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}" target="_blank">
      <div style="position: relative; overflow: hidden;">
        <img style="width: 100%" src="{{ $video->cover }}">
        @if (strpos($video->cover, 'E6mSQA2') !== false)
          <img style="position: absolute; top: 0; left: 0; height: 100%; object-fit: cover;" src="{{ $video->thumbL() }}">
        @endif
        <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 2px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video->title }}</div>
      </div>
    </a>

    @if ($editable)
      <form style="display: none" class="playitem-delete-form" action="{{ route('playitem.delete') }}">
        {{ csrf_field() }}

        <input class="playlist-show-id" name="playlist-show-id" type="hidden" value="{{ request('list') }}">
        <input class="playlist-show-video-id" name="playlist-show-video-id" type="hidden" value="{{ $video->id }}">

        <div style="position: absolute; top: 0px; right: 0; background-color: black; height: 30px; width: 30px; cursor: pointer;" class="no-select playitem-delete-btn">
          <span class="material-icons" style="font-size: 30px; color: white; padding-left: 0px;">clear</span>
        </div>
      </form>
    @endif
  </div>
</div>
