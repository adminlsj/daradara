<a href="{{ route('video.trending') }}?v={{ $video->id }}">
  <img src="https://i.imgur.com/{{ $video->imgur }}l.png" style="width:100%; height:100%;" alt="{{ $video->title }}">
</a>

<div style="position: relative;" class="video-title-container">
    <span style="position: absolute; top:-26px; right: 7px; background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; font-size: 0.85em; border-radius: 2px; opacity: 0.9">{{ $video->duration() }}</span>
    <div>
        <a href="https://www.instagram.com/laughseejapan/" target="_blank">
            <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/default_laughseejapan_profile_pic.jpg" class="video-profile-pic" width="40" height="40">
        </a>
    </div>
    <div>
        <a href="{{ route('video.trending') }}?v={{ $video->id }}">
          <h4 class="video-title">{{ $video->title }}</h4>
        </a>

        <p class="video-tags">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}</p>
    </div>
</div>​
<br>