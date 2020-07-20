<div style="background-color: #F9F9F9; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); margin-bottom: 15px;">
  @include('video.player')

  <div class="hidden-md hidden-lg" style="background-color: white;">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-format="fluid"
         data-ad-layout-key="-ie+f-17-3w+bl"
         data-ad-client="ca-pub-4485968980278243"
         data-ad-slot="3332191764"></ins>
  </div>

  <div style="padding: 0px 25px 25px 25px;">
    <div class="video-parts-wrapper" style="padding-top: 25px; margin-bottom: -4px; {{ count($video->sd()) == 1 ? 'display:none;' : '' }}">
      @foreach ($video->sd() as $url)
        <span class="{{ $loop->iteration == 1 ? 'active' : '' }}" onclick="changeSrc(this)" data-url="{{ $url }}"><i style="vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: 2px; margin-left: -3px; {{ $loop->iteration == 1 ? '' : 'display:none;' }}" class="material-icons">play_arrow</i>P{{ $loop->iteration }}</span>
      @endforeach
    </div>

    <h3 id="shareBtn-title" style="line-height: 30px; font-weight: bold; font-size: 1.5em">{{ $video->title }}</h3>

    <a href="{{ route('user.show', [$video->user->id]) }}"><img class="lazy" style="float:left; border-radius: 50%; width: 35px; height: 35px;" src="{{ $video->user->avatarCircleB() }}" data-src="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}" data-srcset="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}"></a>

    <h5 style="margin-left: 45px; line-height: 37px;"><a style="text-decoration: none; color: dimgray; font-weight: bold" href="{{ route('user.show', [$video->user]) }}">{{ $video->user->name }}</a></h5>

    @if ($watch != null)
      <div style="float: right; margin-top: -35px;">
        @include('video.watch-subscribe-wrapper', ['tag' => $video->watch->title])
      </div>
    @endif

    <h5 style="color: dimgray; font-weight: 400; margin-top: 19px; line-height: 20px; margin-bottom: -5px; white-space: pre-wrap;">{{ str_replace('[SHOW]', '', $video->caption) }}</h5>

    <h5 style="font-weight: 400; line-height: 20px; margin-bottom: 15px">
      @foreach ($video->tags() as $tag)
          <a style="margin-right: 3px; color: #4377e8;" href="/search?query={{ $tag }}">#{{ $tag }}</a>
      @endforeach
    </h5>

    <!--<h5 style="line-height: 20px; margin-bottom: 15px">
      <a style="text-decoration: none; color: darkgray; font-weight: bold" href="{{ $video->sd }}" target="_blank"><span style="vertical-align: middle; margin-top: -2px; margin-right: 5px" class="material-icons">link</span>{{ str_ireplace('player.', '', str_ireplace('www.', '', parse_url($video->sd, PHP_URL_HOST))) }}</a>
    </h5>-->

    <div class="show-panel-icons" style="padding-bottom: 35px;">
      <div id="video-like-form-wrapper">
        @include('video.like-btn-wrapper')
      </div>
      <div id="comment-icon" class="single-icon-wrapper">
        <div class="single-icon no-select" style="position: relative;">
          <i class="material-icons">chat</i>
          <div>評論</div>
          @if ($current->comments()->count() > 0)
            <span style="position: absolute; margin-top: -55px; right: 11px;" class="alert-circle"></span>
          @endif
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

<div id="comment-section-wrapper" style="background-color: #F9F9F9; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); padding: 5px 25px 0px 25px; margin-top: -5px; margin-bottom: 15px">
  @include('video.comment-section-wrapper')
</div>

@include('video.shareModal')
@include('video.userReportModal')
@if (!Auth::check())
  @include('user.signUpModal')
  @include('user.loginModal')
@endif