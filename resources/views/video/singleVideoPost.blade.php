<div id="{{ $video->id }}" class="fb-video"
      data-href="{{ $video->content }}"
      data-width="auto"
      data-allowfullscreen="false"
      data-autoplay="false"
      data-show-captions="false"></div>

<div class="video-title-container">
    <div>
        <a href="https://www.facebook.com/laughseejapan/" target="_blank">
            <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/default_laughseejapan_profile_pic.jpg" class="video-profile-pic" width="40px" height="40px">
        </a>
    </div>
    <div>
        <a href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}">
            <h4 class="video-title">{{ $video->title }}</h4>
        </a>
        <p class="video-caption">{{ $video->caption }}</p>
        <p class="video-tags">娛見日本@laughseejapan | <a href="{{ route('blog.category.index', ['genre' => $video->genre, 'category' => $video->category]) }}">{{ array_search($video->category, App\Blog::$genres[$video->genre]['categories']) }}</a> | {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}</span></p>
    </div>
</div>​
<br>