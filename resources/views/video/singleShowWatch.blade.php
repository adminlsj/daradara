@include('video.player')

<div style="background-color: #151515">
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-format="fluid"
       data-ad-layout-key="-ia+f-1a-3i+b9"
       data-ad-client="ca-pub-4485968980278243"
       data-ad-slot="3332191764"></ins>
 </div>

<div style="padding-bottom: 5px; padding-left: 15px; padding-right: 15px; border-top: 1px solid #383838">
    <div style="margin-bottom: 5px; padding-top: 6px; position:relative;">
        <!-- <p id="video-tags" class="text-ellipsis" style="padding-right:40px; margin-bottom:2px; font-size: 0.85em; {{ count($video->sd()) > 1 ? 'display:none;' : '' }}">
          @foreach ($video->tags() as $tag)
            @if (strpos($tag, '完整版') !== false)
              <a style="color:#e5e5e5;" href="{{ route('video.watch') }}?v={{ App\Video::where('category', $video->category)->orderBy('created_at', 'desc')->first()->id }}">#{{ $tag }}</a>
            @else
              <a style="color:#e5e5e5;" href="{{ route('video.search') }}?query={{ $tag }}">#{{ $tag }}</a>
            @endif
          @endforeach
        </p>-->

        <a style="text-decoration: none; pointer-events: none;">
          <h4 id="shareBtn-title" style="padding-right:40px; line-height: 23px; font-weight: 400; margin-top:0px; margin-bottom: 0px; color:white; font-size: 1.15em">{{ $video->title }}</h4>
        </a>

        <div id="toggleVideoDescription" style="position:absolute; top:6px; right:3px; cursor: pointer; color: darkgray" class="pull-right"><i id="toggleVideoDescriptionIcon" class="material-icons noselect">expand_more</i></div>

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
               url:'/getSource',
               data: {url : link},
               success:function(source) {
                  const dp = new DPlayer({
                    container: document.getElementById('dplayer'),
                    autoplay: true,
                    theme: '#d84b6b',
                    preload: 'auto',
                    video: {
                      url: source,
                    },
                  });
               }
            });
          }
        </script>

    </div>

    <div id="videoDescription" style="display: none; margin-top: 5px;">
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $video->caption }}</p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 5px;"><strong>劇情大綱</strong></p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $watch != false ? $watch->description : ''}}</p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 5px;"><strong>登場人物</strong></p>
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $watch != false ? $watch->cast : ''}}</p>
    </div>

    <div class="show-panel-icons">
      <div class="single-icon">
        <i style="color: #363636" class="material-icons noselect">thumb_up</i>
        <div style="color: #363636">0</div>
      </div>
      <div class="single-icon">
        <i style="color: #363636" class="material-icons noselect">chat</i>
        <div style="color: #363636">評論</div>
      </div>
      <div id="shareBtn" class="single-icon" data-toggle="modal" data-target="#shareModal">
        <i class="material-icons noselect" style="-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1); font-size: 2.05em; margin-top: -4px;">reply</i>
        <div style="margin-top: -4px;">分享</div>
      </div>
      <div class="single-icon">
        <i style="color: #363636" class="material-icons noselect">library_add</i>
        <div style="color: #363636">儲存</div>
      </div>
      <div class="single-icon" data-toggle="modal" data-target="#reportModal">
        <i class="material-icons noselect">flag</i>
        <div>報告</div>
      </div>
    </div>
</div>

<hr style="border:solid 0.5px #383838; margin-top: 53px; margin-bottom: 10px">
<div style="padding-left: 15px; padding-right: 15px;">
  <a href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">
    <img class="lazy img-circle" style="width: 35px; height: auto; float:left;" src="https://i.imgur.com/JMcgEkPs.jpg" data-src="https://i.imgur.com/{{ $video->watch()->imgur }}s.jpg" data-srcset="https://i.imgur.com/{{ $video->watch()->imgur }}s.jpg" alt="{{ $video->watch()->title }}">
  </a>
  <div style="margin-left: 45px;">
    <div><a style="text-decoration: none; color: white;" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">{{ $video->watch()->title }}</a></div>
    <div style="color: darkgray; font-size: 0.85em; margin-top: -1px;">7.01M 位訂閱者</div>
    <div id="subscribe-panel">
      @if ($is_subscribed)
        @include('video.unsubscribeBtn')
      @else
        @include('video.subscribeBtn')
      @endif
    </div>
  </div>
</div>
<hr style="border:solid 0.5px #383838; margin-top: 9px">

@include('video.shareModal')
@include('video.userReportModal')
@include('video.subscribeModal', ['watch' => $video->watch()])
@if (!Auth::check())
  @include('user.signUpModal')
  @include('user.loginModal')
@endif