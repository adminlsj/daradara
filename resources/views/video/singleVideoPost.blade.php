<div class="fb-video"
      data-href="{{ $video->content }}"
      data-width="auto"
      data-allowfullscreen="false"
      data-autoplay="false"
      data-show-captions="false"></div>

<div class="video-title-container">
    <div>
        <a href="https://www.instagram.com/laughseejapan/" target="_blank">
            <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/default_laughseejapan_profile_pic.jpg" class="video-profile-pic" width="40px" height="40px">
        </a>
    </div>
    <div>
        <a href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}">
          <h4 class="video-title">{{ $video->title }}</h4>
        </a>

        <p class="video-tags">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }} • <a href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}" data-image="https://twobayjobs.s3.amazonaws.com/blogImgs/originals/{{ $video->id }}/{{ $video->blogImgs->sortby('created_at')->first()->filename }}" data-title="{{ $video->title }}" data-desc="{{ $video->caption }}" class="btnShare">分享</a></p>
    </div>
</div>​
<br>