@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content') 
<div class="banner"
    style="background-image: url('https://s4.anilist.co/file/anilistcdn/media/anime/banner/16498-8jpFCOcDmneX.jpg');">
    <div class="shadow"></div>
</div>
<div class="headings-wrapper">
    <div class="headings" style="position: relative;">
        <div class="cover">
            <img style="object-fit: cover;" src="{{ $anime->photo_cover }}" alt="">
            <div style="width: 100%; margin-top: 20px; margin-bottom: 20px;">
                <div class="no-select addtolist"
                    style="width: calc(100% - 85px); background-color: rgb(61,180,242); height: 35px; line-height: 35px; display: inline-block; border-top-left-radius: 3px; border-bottom-left-radius: 3px; text-align: center; color: white; font-weight: 400; cursor: pointer;"
                    data-toggle="modal" data-target="#createSavelist{{ $anime->id }}">
                    {{ $anime_save ? App\Savelist::$statuslists[$status] : '添加至列表' }}
                </div>

                <form
                    style="height: 35px; width: 35px; font-size: 17px; padding: 0; float: right; background-color: rgb(236,41,75); display: inline-block; border-radius: 3px; color: white; text-align: center; cursor: pointer;"
                    id="anime-like-form"
                    action="{{ route('like.create', ['type' => 'App\Anime', 'id' => $anime->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <input id="redirectTo" name="redirectTo" type="hidden" value="{{ Request::url() }}">
                    <button
                        style="line-height: 35px; width: 35px; color: {{ Auth::check() ? App\Like::where('user_id', Auth::user()->id)->where('likeable_id', $anime->id)->where('likeable_type', 'App\Anime')->first() ? '#810000' : 'white' : 'white'}}"
                        class="no-button-style" type="submit">
                        ♥
                    </button>
                </form>

                <div class="dropdownlist" style="height: 35px; width: 35px; font-size: 17px; padding: 0; float: right; background-color: #5EBFF4; display: inline-block; margin-right: 15px; border-top-right-radius: 3px; border-bottom-right-radius: 3px; text-align: center; cursor: pointer;"
                    data-toggle="modal" data-target="#createSavelist{{ $anime->id }}">
                    <i style="line-height: 35px; color: white; font-size: 14px;" class="fa fa-chevron-down"></i>
                </div>
            </div>
        </div>

        @include('anime.save-panel')

        <div class="heading-content">
            <div>
                <h1 style="color: rgb(92,114,138); font-size: 1.9rem; font-weight: 400; margin-top: 25px">
                    {{ $anime->getTitle($chinese) }}
                </h1>
                <p
                    style="color: rgb(122,133,143); font-size: 1.4rem; font-weight: 400; line-height: 1.6; max-width: 900px; padding: 10px 0; transition: .2s;">
                    {{ $chinese->to(SteelyWing\Chinese\Chinese::ZH_HANT, $anime->description) }}
                </p>
                <h4 class="alternative-name-mobile">{{ $anime->title_zhs }} · {{ $anime->title_jp }} ·
                    {{ $anime->title_en }} · {{ $anime->title_ro }}
                </h4>
            </div>

            <div class="details-mobile">
                <hr>
                <div class="details-content-mobile">
                    <div class="ratings details-content">
                        <p>{{ $anime->rating_mal_count + $anime->rating_bangumi_count }}人評分</p>
                        <h3>{{ $anime->rating_mal }}</h3>
                        <p>&#9733;&#9733;&#9733;&#9733;&#9733;</p>
                    </div>
                    <hr style="height: 50px; display: inline-block; border-left:1px solid #eeeeee;">
                    <div class="episodes details-content">
                        <p>每集{{ $anime->episodes_length }}分鐘</p>
                        <h3>{{ $anime->episodes_count }}集</h3>
                        <p>{{ $anime->airing_status }}</p>
                    </div>
                    <hr style="height: 50px; display: inline-block; border-left:1px solid #eeeeee;">
                    <div class="genres-ranking details-content">
                        <p>類別</p>
                        <h3>#3</h3>
                        <p>動作</p>
                    </div>
                    <hr style="height: 50px; display: inline-block; border-left:1px solid #eeeeee;">
                    <a href="">
                        <div class="animation-studio details-content">
                            <p>動畫社</p>
                            <h3><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-building" viewBox="0 0 16 16">
                                    <path
                                        d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                                    <path
                                        d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z" />
                                </svg></h3>
                            <p>{{ $anime->animation_studio }}</p>
                        </div>
                    </a>
                    <hr style="height: 50px; display: inline-block; border-left:1px solid #eeeeee;">
                    <div class="genres-ranking details-content">
                        <p>首播日期</p>
                        <h3>{{ Carbon\Carbon::parse($anime->started_at)->format('m/d') }}</h3>
                        <p>{{ Carbon\Carbon::parse($anime->started_at)->format('Y') }}年</p>
                    </div>
                    <hr style="height: 50px; display: inline-block; border-left:1px solid #eeeeee;">
                    <div class="genres-ranking details-content">
                        <p>完播日期</p>
                        <h3>{{ Carbon\Carbon::parse($anime->ended_at)->format('m/d') }}</h3>
                        <p>{{ Carbon\Carbon::parse($anime->ended_at)->format('Y') }}年</p>
                    </div>
                </div>
                <hr>
            </div>

            <div class="genres-mobile">
                <div class="genre">動作</div>
                <div class="genre">冒險</div>
                <div class="genre">愛情</div>
                <div class="genre">怪獸</div>
                <div class="genre">戰鬥</div>
                <div class="genre">卡夫卡</div>
                <div class="genre">大叔</div>
                <div class="genre">搞笑</div>
                <div class="genre">王道</div>
                <div class="genre">8號</div>
                <div class="genre">很多怪獸</div>
                <div class="genre">戰隊</div>
            </div>

            <div class="navtabs">
                <a style="text-decoration: none;"
                    href="{{ route('anime.show', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}"><button
                        class="tablinks {{ !Request::is('anime/*/*/*') ? 'active' : '' }}">簡介</button></a>
                <a style="text-decoration: none;"
                    href="{{ route('anime.episodes', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}"><button
                        class="tablinks {{ Request::is('anime/*/*/episodes') ? 'active' : '' }}">集數列表</button></a>
                <a style="text-decoration: none;"
                    href="{{ route('anime.characters', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}"><button
                        class="tablinks {{ Request::is('anime/*/*/characters') ? 'active' : '' }}">登場人物</button></a>
                <a style="text-decoration: none;"
                    href="{{ route('anime.staff', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}"><button
                        class="tablinks {{ Request::is('anime/*/*/staff') ? 'active' : '' }}">製作人員</button></a>
                <a style="text-decoration: none;"
                    href="{{ route('anime.comments', ['anime' => $anime, 'title' => $anime->getTitle($chinese)]) }}"><button
                        class="tablinks {{ Request::is('anime/*/*/comments') ? 'active' : '' }}">評論</button></a>
            </div>
        </div>
    </div>
</div>

<script>
    var dropdownMenu = document.getElementById('dropdownMenu');
    function toggleDropdownMenu() {
        if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
            dropdownMenu.style.display = 'flex';
        }
        else if (dropdownMenu.style.display === 'flex') {
            dropdownMenu.style.display = 'none';
        }
    }
</script>

<script>
    window.addEventListener('mouseup', function (event) {
        var dropdownMenu = document.getElementById('dropdownMenu');
        if (event.target != dropdownMenu) {
            dropdownMenu.style.display = 'none';
        }
    });
</script>

<script>
    var modal = document.getElementById('addToList');

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<script>
    window.addEventListener('mouseup', function (event) {
        var optionWatchingStatus = document.getElementById('option-watching-status');
        var optionListPrivacy = document.getElementById('option-list-privacy');

        if (event.target === optionWatchingStatus) {
            optionWatchingStatus.style.display = 'block';
        }
        else if (event.target === optionListPrivacy) {
            optionListPrivacy.style.display = 'block';
        }

        optionWatchingStatus.style.display = 'none';
        optionListPrivacy.style.display = 'none';
    });  
</script>

<div class="flex-center-wrapper" style="margin-top: 30px;">
    <div class="flex-center-content">
        @include('anime.show.sidebar')

        @if (Request::is('anime/*/*/episodes'))
            @include('anime.show.episodes')
        @elseif (Request::is('anime/*/*/characters'))
            @include('anime.show.characters')
        @elseif (Request::is('anime/*/*/staff'))
            @include('anime.show.staffs')
        @elseif (Request::is('anime/*/*/comments'))
            @include('anime.show.comments')
        @elseif (Request::is('anime/*/*'))
            @include('anime.show.overview')
        @endif
    </div>
</div>
@endsection