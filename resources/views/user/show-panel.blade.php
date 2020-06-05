<div class="row no-gutter load-more-container" style="padding-top: 19px;">
  <img class="lazy user-show-title" style="float:left; width: 56px; height: 56px; border-top-left-radius: 3px; border-bottom-left-radius: 3px; margin-right: 15px" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
  <h5 class="user-show-title" style="font-size: 1em; color: #555555; font-weight: normal; line-height: 0px">{{ $subscribers }} 位訂閱者</h5>
  <h3 class="user-show-title no-select" style="font-size: 2em; margin-top: 4px; margin-bottom: -5px"><span style="font-size: 0.93em">{{ $user->name }}</span></h3>
</div>

<div class="subscribes-tab" style="border: none; margin-bottom: 0px">
    <a href="{{ route('user.show', [$user, 'featured']) }}" class="{{ Request::is('user/*') && !Request::is('user/*/*') || Request::is('user/*/featured') ? 'active' : '' }}" style="margin-right: 5px;">首頁</a>
    <a href="{{ route('user.show', [$user, 'videos']) }}" class="{{ Request::is('user/*/videos') ? 'active' : '' }}" style="margin-right: 5px;">影片</a>
    <a href="{{ route('user.show', [$user, 'playlists']) }}" class="{{ Request::is('user/*/playlists') ? 'active' : '' }}" style="margin-right: 5px;">播放清單</a>
    <a href="{{ route('user.show', [$user, 'about']) }}" class="{{ Request::is('user/*/about') ? 'active' : '' }}" style="margin-right: 5px;">簡介</a>
    @if (Auth::check() && $user->id == Auth::user()->id)
      <a href="{{ route('user.userEditUpload', $user) }}" style="margin-right: 5px;">上傳影片</a>
      <form id="logout-form" style="display: inline-block; margin-top: -10px; margin-bottom: -10px" action="{{ route('logout') }}" method="POST">
          {{ csrf_field() }}
          <button style="margin: 0px; margin-right: 5px; border: none;" type="submit">登出</button>
      </form>
    @endif
</div>