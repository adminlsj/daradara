@include('video.player')

<div style="background-color:#222222; padding-bottom: 5px" class="padding-setup">
    <div style="margin-bottom: 5px;">
        <p style="padding: 7px 0px 2px 0px; font-size: 0.9em;">
          @foreach ($video->tags() as $tag)
            @if (strpos($tag, '完整版') !== false)
              <a style="color:#e5e5e5;" href="{{ route('video.watch') }}?v={{ App\Blog::where('category', $video->category)->orderBy('created_at', 'desc')->first()->id }}">#{{ $tag }}</a>
            @else
              <a style="color:#e5e5e5;" href="{{ route('blog.search') }}?query={{ $tag }}">#{{ $tag }}</a>
            @endif
          @endforeach
        </p>
        <a id="shareBtn-link" href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; pointer-events: none;">
          <h4 id="shareBtn-title" style="line-height: 23px; font-weight: 500; margin-top:-10px; margin-bottom: 0px; color:white; font-size: 1.25em">{{ $video->title }}</h4>
        </a>
    </div>
    <div style="margin-left: -4px;">
        <a style="text-decoration: none; {{ $prev != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $prev }}"><i class="material-icons noselect">skip_previous</i></a>
        <a style="text-decoration: none; margin-left: 8px; {{ $next != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $next }}"><i class="material-icons noselect">skip_next</i></a>
    </div>
    <div id="toggleVideoDescription" style="margin-top: -40px; padding-top:10px; padding-right:2px;cursor: pointer; color: white" class="pull-right"><i id="toggleVideoDescriptionIcon" class="material-icons noselect">expand_more</i></div>
    <a id="shareBtn" style="margin-top: -35px; margin-right: 30px; padding-right:10px; cursor: pointer; text-decoration: none;" class="pull-right">
      <i style="color: white;-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1);" class="material-icons pull-right noselect">reply</i>
    </a>
    <div id="videoDescription" style="display: none; margin-top: 5px; padding-bottom: 10px;">
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $video->caption }}</p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">劇情大綱</p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $watch != false ? $watch->description : ''}}</p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">角色聲優</p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $watch != false ? $watch->cast : ''}}</p>
      <p><a href="{{ route('video.intro', [$video->genre, $watch->titleToUrl()]) }}">更多詳情 ></a></p>
    </div>
</div>​