<div class="user-profile" style="position: relative;">
    <div class="user-banner" style="background-image: url('https://s4.anilist.co/file/anilistcdn/user/banner/b944578-vYqmqdYd1SWq.jpg');">
        <div style="background: linear-gradient(180deg, rgba(6,13,34, 0) 40%, rgba(6,13,34, .6)); height: 100%; left: 0; position: absolute; top: 0; width: 100%;"></div>
    </div>
    <div class="user-photo flex-row">
        <img src="{{ $user->avatar_temp }}" alt="">
        <h1 style="font: 800; font-size: 1.9rem; letter-spacing: 1px;">{{ $user->name }}</h1>
    </div>
</div>