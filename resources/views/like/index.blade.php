@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')

<div class="flex-column user-profile" style="background-color:rgb(237,241,245);">
    @include('user.show.userProfile')
    @include('user.show.navTabs')

    <div class="flex-center-wrapper">
        <div class="flex-center-content flex-column">
            <div class="content-wrap">                
                <div class="landing-section" style="margin-top: 30px;">
                    <div class="title-link">
                        <a href="">
                            <h3>喜愛的動漫</h3>
                        </a>
                    </div>
                    <div class="media-wrap">
                        @foreach ($anime_likes as $anime_like)
                            @include('home.media-card', ['anime' => $anime_like->anime])
                        @endforeach
                    </div>
                </div>

                <div class="landing-section" style="margin-top: 30px;">
                    <div class="title-link">
                        <a href="">
                            <h3>喜愛的角色</h3>
                        </a>
                    </div>
                    <div class="media-wrap">
                        @foreach ($character_likes as $character_like)
                            @include('character.media-card', ['character' => $character_like->character])
                        @endforeach
                    </div>
                </div>

                <div class="landing-section" style="margin-top: 30px;">
                    <div class="title-link">
                        <a href="">
                            <h3>喜愛的幕後人員</h3>
                        </a>
                    </div>
                    <div class="media-wrap">
                        @foreach ($staff_likes as $staff_like)
                            @include('staff.media-card', ['staff' => $staff_like->staff])
                        @endforeach
                    </div>
                </div>

                <div class="landing-section" style="margin-top: 30px;">
                    <div class="title-link">
                        <a href="">
                            <h3>喜愛的製作公司</h3>
                        </a>
                    </div>
                    <div class="media-wrap">
                        @foreach ($company_likes as $company_like)
                            @include('company.media-card', ['company' => $company_like->company])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

</div>

@endsection