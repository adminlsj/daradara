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
        <p class="video-tags">@laughseejapan | <a href="{{ route('blog.category.index', ['genre' => $video->genre, 'category' => $video->category]) }}">{{ array_search($video->category, App\Blog::$genres[$video->genre]['categories']) }}</a> | {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }} | <span class="fb-share-button" data-href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">分享</a></span></p>
    </div>
</div>​
<br>