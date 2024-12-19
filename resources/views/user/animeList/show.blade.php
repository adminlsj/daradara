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
            <div class="title-link flex-row">
                <h3>
                    {{ $savelist->is_status ? App\Anime::$statuslists[$savelist->title] : $savelist->title }}
                
                @if (!$savelist->is_status)
                    @if (Auth::check() && Auth::user()->id == $user->id)
                        <button class="no-button-style no-select save-edit-btn" style="font-size: 1.2rem; cursor: pointer; padding: 3px 3px; text-align: center; width: 40px; font-weight: normal; border-radius: 3px; margin-top: -3px; vertical-align: middle; margin-left: 5px;" data-toggle="modal" data-target="#updateSavelist">編輯</button>
                    @endif
                    </h3>
                @endif
            </div>
            <div class="list-entries">
                <div class="list-section flex-row">
                    @foreach ($anime_saves as $anime_save)
                        @include('user.animeList.card', ['redirectTo' => "user.animelist.show.{$savelist->id}.{$savelist->title}"])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <br>
</div>

@if (Auth::check() && Auth::user()->id == $user->id)
    @include('user.animeList.create')
    @include('user.animeList.edit')
@endif

@endsection