@include('video.player')

<div style="background-color:#222222; padding-bottom: 5px" class="padding-setup">
    <div style="margin-bottom: 5px; padding-top: 7px;">
        <p style="margin-bottom:2px; font-size: 0.9em; {{ count($video->sd()) > 1 ? 'display:none;' : '' }}">
          @foreach ($video->tags() as $tag)
            @if (strpos($tag, '完整版') !== false)
              <a style="color:#e5e5e5;" href="{{ route('video.watch') }}?v={{ App\Video::where('category', $video->category)->orderBy('created_at', 'desc')->first()->id }}">#{{ $tag }}</a>
            @else
              <a style="color:#e5e5e5;" href="{{ route('video.search') }}?query={{ $tag }}">#{{ $tag }}</a>
            @endif
          @endforeach
        </p>

        <a id="shareBtn-link" href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; pointer-events: none;">
          <h4 id="shareBtn-title" style="line-height: 23px; font-weight: 500; margin-top:0px; margin-bottom: 0px; color:white; font-size: 1.25em">{{ $video->title }}</h4>
        </a>

        <div class="video-parts-wrapper" style="padding-top: 12px; padding-bottom: 5px; {{ count($video->sd()) == 1 ? 'display:none;' : '' }}">
          @foreach ($video->sd() as $url)
            <span class="{{ $loop->iteration == 1 ? 'active' : '' }}" onclick="changeSrc(this)" data-url="{{ $url }}"><i style="vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: 2px; margin-left: -3px; {{ $loop->iteration == 1 ? '' : 'display:none;' }}" class="material-icons">play_arrow</i>P{{ $loop->iteration }}</span>
          @endforeach
        </div>

        <script>
          function changeSrc(identifier) {
            $('#dplayer').addClass('dplayer-loading');

            link = $(identifier).data('url');
            $(".video-parts-wrapper>span.active>i").hide();
            $(".video-parts-wrapper>span.active").removeClass("active");
            $(identifier).addClass('active');
            $(".video-parts-wrapper>span.active>i").show();
            
            $.ajax({
               type:'GET',
               url:'/getSourceIG',
               data: {urlIG : link},
               success:function(source) {
                  const dp = new DPlayer({
                    container: document.getElementById('dplayer'),
                    autoplay: true,
                    theme: '#d84b6b',
                    preload: 'auto',
                    video: {
                      url: source,
                      pic: 'https://i.imgur.com/{{ $video->imgur }}l.png',
                      thumbnails: 'https://i.imgur.com/{{ $video->imgur }}l.png',
                    },
                  });
               }
            });
          }
        </script>

    </div>
    <div style="margin-left: -4px;">
        <a style="text-decoration: none; {{ $prev != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $prev }}"><i class="material-icons noselect">skip_previous</i></a>
        <a style="text-decoration: none; margin-left: 8px; {{ $next != false ? 'color: white;' : 'pointer-events: none; color: #414141;' }}" href="{{ route('video.watch') }}?v={{ $next }}"><i class="material-icons noselect">skip_next</i></a>
    </div>

    <div id="toggleVideoDescription" style="margin-top: -40px; padding-top:11px; padding-right:2px;cursor: pointer; color: white" class="pull-right"><i id="toggleVideoDescriptionIcon" class="material-icons noselect">expand_more</i></div>

    <a style="margin-top: -34px; margin-right: 31px; padding-right:10px; cursor: pointer;" class="pull-right" data-toggle="modal" data-target="#reportModal">
      <i style="color: white;" class="material-icons pull-right noselect">flag</i>
    </a>

    <a id="shareBtn" style="margin-top: -34px; margin-right: 74px; padding-right:8px; cursor: pointer; text-decoration: none;" class="pull-right">
      <i style="color: white;-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1);" class="material-icons pull-right noselect">reply</i>
    </a>

    @include('video.userReportModal')

    <div id="videoDescription" style="display: none; margin-top: 5px; padding-bottom: 10px;">
      <p style="white-space: pre-wrap; color: white; margin-bottom: 5px;"><strong>{{ $video->title() }}</strong></p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $video->caption }}</p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 5px;"><strong>劇情大綱</strong></p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $watch != false ? $watch->description : ''}}</p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 5px;"><strong>登場人物</strong></p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $watch != false ? $watch->cast : ''}}</p>
      <p><a style="color:white; text-decoration: none;" href="{{ route('video.intro', [$video->genre, $watch->titleToUrl()]) }}"><strong>完整介紹 ></strong></a></p>
    </div>
</div>​