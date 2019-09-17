<div class="aspect-ratio">
    <iframe src="{{ $video->content }}?autoplay-mute=true&queue-enable=false&quality=480&byline=false&portrait=false&title=false" border="0" frameborder="0" framespacing="0" allowfullscreen allow="autoplay"></iframe>
</div>

<div style="padding: 0px 15px;" class="video-title-container">
    <div>
        <p style="margin: 7px 0px 2px 0px; font-size: 0.9em">
          @foreach ($video->tags() as $tag)
            <a style="color: #97344a" href="{{ route('blog.category.index', ['genre' => 'laughseejapan', 'category' => $tag]) }}">#{{ $tag }}</a>
          @endforeach
        </p>
        <a href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}">
          <h4 style="line-height: 23px; font-weight: 600; margin-top:0px; margin-bottom: 0px;">{{ $video->title }}</h4>
        </a>
        <p style="color: gray; margin-top: 4px; margin-bottom: 0px; font-size: 0.9em;">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }} • <a href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}" data-image="https://twobayjobs.s3.amazonaws.com/blogImgs/originals/{{ $video->id }}/{{ $video->blogImgs->sortby('created_at')->first()->filename }}" data-title="{{ $video->title }}" data-desc="{{ $video->caption }}" class="btnShare">分享</a></p>
    </div>
    <hr style="border-color: #d9d9d9; background-color: #d9d9d9; color: #d9d9d9; padding:0px; margin: 10px -15px 0px -15px;">
      <div>
          <a href="https://www.instagram.com/laughseejapan/" target="_blank">
              <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/default_laughseejapan_profile_pic.jpg" class="video-profile-pic" width="40px" height="40px">
          </a>
      </div>
      <div>
          <a href="https://www.instagram.com/laughseejapan/">
            <h4 style="color: black; font-weight: 400;" class="video-title">Laughseejapan</h4>
          </a>
          <p style="white-space: pre-wrap; margin-left: 50px; margin-top: -10px; color: gray; margin-bottom: 0px;" class="video-caption">@Instagram</p>
      </div>
    <hr style="border-color: #d9d9d9; background-color: #d9d9d9; color: #d9d9d9; padding:0px; margin: 10px -15px 10px -15px;">
      <p style="white-space: pre-wrap; color: gray; margin-bottom: 0px;">{{ $video->caption }}</p>
    <hr style="border-color: #d9d9d9; background-color: #d9d9d9; color: #d9d9d9; padding:0px; margin: 10px -15px 0px -15px;">
</div>​