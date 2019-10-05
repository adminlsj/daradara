<div class="aspect-ratio">
    <iframe src="{{ $video->content }}?autoplay-mute=true&queue-enable=false&quality=480&byline=false&portrait=false&title=false" border="0" frameborder="0" framespacing="0" allowfullscreen allow="autoplay" autostart="true"></iframe>
</div>

<div class="padding-setup" class="video-title-container">
    <div>
        <p style="margin: 7px 0px 2px 0px; font-size: 0.9em">
          @foreach ($video->tags() as $tag)
            <a style="color: #97344a" href="{{ route('blog.search') }}?query={{ $tag }}">#{{ $tag }}</a>
          @endforeach
        </p>
        <a id="shareBtn-link" href="{{ route('video.trending') }}?v={{ $video->id }}">
          <h4 id="shareBtn-title" style="line-height: 23px; font-weight: 600; margin-top:0px; margin-bottom: 0px;">{{ $video->title }}</h4>
        </a>
        <p style="color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 0.9em;">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}</p>
    </div>
    <hr style="border-color: #d9d9d9; background-color: #d9d9d9; color: #d9d9d9; padding:0px; margin: 10px -15px 0px -15px;">
      <div>
          <a href="https://www.instagram.com/laughseejapan/" target="_blank">
              <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/default_laughseejapan_profile_pic.jpg" class="video-profile-pic" width="40px" height="40px">
          </a>
      </div>
      <div>
          <a href="https://www.instagram.com/laughseejapan/">
            <h4 style="color: black; font-weight: 400;" class="video-title">Laughseejapan.com</h4>
          </a>
          <p style="white-space: pre-wrap; margin-left: 50px; margin-top: -10px; color: gray; margin-bottom: 0px;" class="video-caption">@Instagram</p>
      </div>
      <div id="toggleVideoDescription" style="margin-top: -40px; padding-top:10px; padding-right:2px;cursor: pointer; color: gray" class="pull-right"><i id="toggleVideoDescriptionIcon" class="material-icons noselect">expand_more</i></div>
      <a id="shareBtn" style="margin-top: -42px; margin-right: 30px; padding-right:10px; cursor: pointer; text-decoration: none;" class="pull-right">
        <i style="color: gray;-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1);" class="material-icons pull-right noselect">reply</i>
        <p style="white-space: pre-wrap; color: gray; margin-bottom: 0px; margin-top: 15px; font-size: 0.85em" class="video-caption noselect">分享</p>
      </a>
    <hr style="border-color: #d9d9d9; background-color: #d9d9d9; color: #d9d9d9; padding:0px; margin: 10px -15px 0px -15px;">
    <div id="videoDescription" style="display: none; margin-top: 10px;">
      <p style="white-space: pre-wrap; color: gray; margin-bottom: 0px;">{{ $video->caption }}</p>
      <hr style="border-color: #d9d9d9; background-color: #d9d9d9; color: #d9d9d9; padding:0px; margin: 10px -15px 0px -15px;">
    </div>
</div>​