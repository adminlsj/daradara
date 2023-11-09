<div id="main-nav-home-mobile" style="z-index: 10000 !important; position: fixed !important; overflow-x: hidden; background: none; transition: height 0.3s, background-color 0.4s, backdrop-filter 0.4s, -webkit-backdrop-filter 0.4s, top 0.4s; height: 100px !important;" class="hidden-sm hidden-md hidden-lg">

  <div style="padding: 0 15px;">
    <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.40em; line-height: 57px; margin-left: 5px;">
      <img style="width: 15px; margin-top: -7px; margin-right: 2px;" src="https://i.imgur.com/9Yt93a3.png">
    </a>

    @if (Auth::check())
      <a id="user-modal-trigger" href="{{ route('home.list') }}" style="padding-left: 1px; padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" >
          <img style="width: 24px; border-radius: 2px;" src="{{ Auth::user()->avatar_temp }}">
      </a>
    @else
      <a id="user-modal-trigger" href="{{ route('login') }}" style="padding-left: 1px; padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" >
          <img style="width: 24px; border-radius: 2px;" src="https://pbs.twimg.com/media/F-URvjzbUAAVmKM?format=jpg&name=240x240">
      </a>
    @endif

    <a style="margin-top: -1px; padding: 0 11px;" class="nav-icon pull-right" href="{{ route('home.search') }}"><img style="width: 31px;" src="https://i.imgur.com/AnfoEPW.png"></a>

    <a style="padding: 0 10px;" class="nav-icon pull-right" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}"><span style="vertical-align: middle; font-size: 24px" class="material-icons-outlined">cast</span></a>
  </div>
</div>