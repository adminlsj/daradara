@include('video.player')

<div class="hidden-md hidden-lg" style="background-color: #151515; border-top: 1px solid #383838;">
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-format="fluid"
       data-ad-layout-key="-ie+f-17-3w+bl"
       data-ad-client="ca-pub-4485968980278243"
       data-ad-slot="3332191764"></ins>
</div>

<div style="padding-bottom: 5px; padding-left: 15px; padding-right: 15px; border-top: 1px solid #383838">
    <div style="margin-bottom: 5px; padding-top: 6px; position:relative;">
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

            link = $(identifier).data('url');
            $('#dplayer').addClass('dplayer-loading');
            $(".video-parts-wrapper>span.active>i").hide();
            $(".video-parts-wrapper>span.active").removeClass("active");
            $(identifier).addClass('active');
            $(".video-parts-wrapper>span.active>i").show();

            if (is_mobile) {
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

            } else {
              $('.aspect-ratio').html('<iframe src="' + link + '" style="border: 0; overflow: hidden;" allow="autoplay" allowfullscreen></iframe>');

            }
          }
        </script>

    </div>

    <div id="videoDescription" style="display: none; margin-top: 5px;">
      <p style="white-space: pre-wrap; color: white; margin-bottom: 20px;">{{ $video->caption }}</p>
      @if ($is_program)
        <p style="white-space: pre-wrap; color: white; margin-bottom: 5px;"><strong>頻道簡介</strong></p>
        <p style="white-space: pre-wrap; color: white; margin-bottom: 10px;">{{ $watch != false ? $watch->description : ''}}</p>
      @endif
    </div>

    <div class="show-panel-icons">
      <div id="video-like-form-wrapper">
        @include('video.like-btn-wrapper')
      </div>
      <div id="comment-icon" class="single-icon-wrapper">
        <div class="single-icon no-select">
          <i class="material-icons">chat</i>
          <div>評論</div>
        </div>
      </div>
      <div id="shareBtn" class="single-icon-wrapper" data-toggle="modal" data-target="#shareModal">
        <div class="single-icon no-select">
          <i class="material-icons noselect" style="-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1); font-size: 2.2em; margin-top: -4px;">reply</i>
          <div style="margin-top: -5px;">分享</div>
        </div>
      </div>
      <div id="video-save-form-wrapper">
        @include('video.save-btn-wrapper')
      </div>
      <div class="single-icon-wrapper" data-toggle="modal" data-target="#reportModal">
        <div class="single-icon no-select">
          <i class="material-icons noselect">flag</i>
          <div>報告</div>
        </div>
      </div>
    </div>
</div>

<hr style="border:solid 0.5px #383838; margin-top: 53px; margin-bottom: 0px">

@if (!$is_mobile)
  @include('video.comment-section-wrapper')
@endif

@include('video.shareModal')
@include('video.userReportModal')
@if (!Auth::check())
  @include('user.signUpModal')
  @include('user.loginModal')
@endif