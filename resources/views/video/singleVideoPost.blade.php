<a href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}">
  <img src="{{ $video->blogImgs[0]->original }}" width="100%" height="100%">
</a>

<div style="position: relative;" class="video-title-container">
    <span style="position: absolute; top:-25px; right: 8px; background-color: black; color: white; padding: 0px 5px 0 5px; opacity: 0.7; font-size: 0.85em; border-radius: 2px;">{{ $video->duration() }}</span>
    <div>
        <a href="https://www.instagram.com/laughseejapan/" target="_blank">
            <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/default_laughseejapan_profile_pic.jpg" class="video-profile-pic" width="40px" height="40px">
        </a>
    </div>
    <div>
        <a href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}">
          <h4 class="video-title">{{ $video->title }}</h4>
        </a>

        <p class="video-tags">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}</p>
    </div>
</div>​
<br>