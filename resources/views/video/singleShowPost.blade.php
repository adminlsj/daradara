@include('video.player')

<div class="hidden-md hidden-lg" style="background-color: white; border-top: 1px solid #383838;">
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-format="fluid"
       data-ad-layout-key="-ie+f-17-3w+bl"
       data-ad-client="ca-pub-4485968980278243"
       data-ad-slot="3332191764"></ins>
</div>

<div style="background-color: #f9f9f9; padding-top: 7px; padding-bottom: 9px; padding-left: 15px; padding-right: 15px;">
    <p style="font-size: 0.9em; padding-bottom: 2px;">
      @foreach ($video->tags() as $tag)
        @if (strpos($tag, '完整版') !== false)
          <a style="color:#a9a9a9" href="{{ route('video.watch') }}?v={{ App\Video::where('category', $video->category)->orderBy('created_at', 'desc')->first()->id }}">#{{ $tag }}</a>
        @else
          <a style="color:#a9a9a9" href="{{ route('video.search') }}?query={{ $tag }}">#{{ $tag }}</a>
        @endif
      @endforeach
    </p>

    <a id="shareBtn-link" href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; pointer-events: none;">
      <h4 id="shareBtn-title" style="line-height: 23px; font-weight: 500; margin-top:-10px; margin-bottom: 0px; color: #323232; font-size: 1.25em">{{ $video->title }}</h4>
    </a>

    <p style="color: #a9a9a9; margin-top: 10px; margin-bottom: 2px; font-size: 0.85em;">
      <i style="vertical-align:middle; font-size: 1.2em; margin-top: -2px; margin-right: 3px;" class="material-icons">remove_red_eye</i>{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}
    </p>

    <div id="toggleVideoDescription" style="margin-top: -31px; padding-top:10px; padding-right:2px;cursor: pointer; color: gray;" class="pull-right"><i id="toggleVideoDescriptionIcon" class="material-icons noselect">expand_more</i></div>

    <a style="margin-top: -26px; margin-right: 12px; padding-right:3px; cursor: pointer;" class="pull-right" data-toggle="modal" data-target="#reportModal">
      <i style="color: gray;" class="material-icons pull-right noselect">flag</i>
    </a>

    <a id="shareBtn" style="margin-top: -26px; margin-right:11px; padding-right:7px; cursor: pointer; text-decoration: none;" class="pull-right">
      <i style="color: gray;-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1);" class="material-icons pull-right noselect">reply</i>
    </a>

    @include('video.userReportModal')

    <div id="videoDescription" style="display: none; margin-top: 10px;">
      <p style="white-space: pre-wrap; color: gray; margin-bottom: 4px;">{{ $video->caption }}</p>
    </div>
</div>​