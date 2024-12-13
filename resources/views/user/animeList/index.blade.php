@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')

<div class="flex-column user-profile" style="background-color:rgb(237,241,245);">
    @include('user.show.userProfile')
    @include('user.show.navTabs')

    <div class="content flex-row userlists">
        @include('user.animeList.sidebar')
        <div class="list-wrap flex-column">
            @foreach ($anime_statuslists as $anime_statuslist)
                @if ($anime_statuslist->anime_saves->count() != 0)
                    <div class="title-link">
                        <h3>{{ App\Anime::$statuslists[$anime_statuslist->title] }}</h3>
                    </div>
                    <div class="list-entries">
                        <div class="list-section flex-row">
                            @foreach ($anime_statuslist->anime_saves as $anime_save)
                                @include('user.animeList.card', ['redirectTo' => 'user.animelist'])
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach ($anime_lists as $anime_list)
                @if ($anime_list->anime_saves->count() != 0)
                    <div class="title-link">
                        <h3>{{ $anime_list->title }}</h3>
                    </div>
                    <div class="list-entries">
                        <div class="list-section flex-row">
                            @foreach ($anime_list->anime_saves as $anime_save)
                                @include('user.animeList.card', ['redirectTo' => 'user.animelist'])
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <br>

    @if (Auth::check() && Auth::user()->id == $user->id)
        @include('user.animeList.create')
    @endif

</div>
@endsection