<div id="user-modal-dp-wrapper" class="no-select">
    <img style="width: 45px; border-radius: 50%; display: inline-block;" src="{{ Auth::user()->avatar_temp }}">
    <div style="display: inline-block; vertical-align: middle; margin-left: 15px;">
        <h5 id="user-modal-name" style="font-weight: bold;">{{ Auth::user()->name }}</h5>
        <h5 id="user-modal-created">加入於 {{ Carbon\Carbon::parse(Auth::user()->created_at)->diffForHumans() }}</h5>
    </div>
</div>
<div class="no-select" style="padding: 9px 0px 0px 0px">
    <a class="user-modal-link" href="{{ route('user.edit', Auth::user()) }}">
        <img src="https://vdownload.hembed.com/image/icon/account.png?secure=l5gBmIDxHL-ugl_W8ixQgA==,4853050181">
        <h5>帳戶資料</h5>
    </a>
    <a class="user-modal-link" href="{{ route('playlist.index') }}">
        <img src="https://vdownload.hembed.com/image/icon/playlist.png?secure=6mARyP6E-BcxDSbV-6824A==,4853050079">
        <h5>我的清單</h5>
    </a>
    <a class="user-modal-link" href="{{ route('playlist.show') }}?list=WL">
        <img src="https://vdownload.hembed.com/image/icon/later.png?secure=JXhfYwu-muWtla0nKV3SAw==,4853050227">
        <h5>稍後觀看</h5>
    </a>
    <a class="user-modal-link" href="{{ route('user.edit', Auth::user()) }}">
        <img src="https://vdownload.hembed.com/image/icon/language.png?secure=n3BTcvAK02eFCoMkuNFdbA==,4853050301">
        <h5>語言設定</h5>
    </a>
    <hr id="user-modal-hr">
    <form action="{{ route('logout') }}" method="POST">
        {{ csrf_field() }}
        <button id="user-modal-logout-btn" class="no-button-style user-modal-link" type="submit">
            <img style="width: 19px; display: inline-block;" src="https://vdownload.hembed.com/image/icon/logout.png?secure=UPXjfySbSecaaJ8x0n0aEg==,4853050341">
            <h5 style="display: inline-block; margin-left: 15px; color: white; vertical-align: middle;">登出</h5>
        </button>
    </form>
</div>