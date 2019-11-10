@include('video.player')

<div style="background-color: #f9f9f9; padding-top: 7px; padding-bottom: 9px;" class="padding-setup">
    <p style="font-size: 0.9em; padding-bottom: 2px;">
      @foreach ($video->tags() as $tag)
        @if (strpos($tag, '完整版') !== false)
          <a style="color:#a9a9a9" href="{{ route('video.watch') }}?v={{ App\Blog::where('category', $video->category)->orderBy('created_at', 'desc')->first()->id }}">#{{ $tag }}</a>
        @else
          <a style="color:#a9a9a9" href="{{ route('blog.search') }}?query={{ $tag }}">#{{ $tag }}</a>
        @endif
      @endforeach
    </p>

    <a id="shareBtn-link" href="{{ route('video.trending') }}?v={{ $video->id }}" style="text-decoration: none; pointer-events: none;">
      <h4 id="shareBtn-title" style="line-height: 23px; font-weight: 500; margin-top:-10px; margin-bottom: 0px; color: #323232; font-size: 1.25em">{{ $video->title }}</h4>
    </a>

    <p style="color: #a9a9a9; margin-top: 4px; margin-bottom: 0px; font-size: 0.85em;"><i style="vertical-align:middle; font-size: 1.2em; margin-top: -2px; margin-right: 3px;" class="material-icons">remove_red_eye</i>{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}</p>

    <div id="toggleVideoDescription" style="margin-top: -32px; padding-top:10px; padding-right:2px;cursor: pointer; color: gray;" class="pull-right"><i id="toggleVideoDescriptionIcon" class="material-icons noselect">expand_more</i></div>

    <a id="shareBtn" style="margin-top: -27px; padding-right:10px; cursor: pointer; text-decoration: none;" class="pull-right">
      <i style="color: gray;-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1);" class="material-icons pull-right noselect">reply</i>
    </a>

    <div id="videoDescription" style="display: none; margin-top: 5px;">
      <p style="white-space: pre-wrap; color: gray; margin-bottom: 5px;">{{ $video->caption }}</p>
    </div>
</div>​