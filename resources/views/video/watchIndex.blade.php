@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'dark'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
  @include('video.sidebarMenu', ['theme' => 'dark'])
</div>

<div class="main-content">
  @include('layouts.nav-index')
  <div style="background-color: #1F1F1F; padding-top: 10px; {{ Request::is('drama') || Request::is('anime') ? 'margin-top: 27px;' : '' }}">
    <div style="padding-top: 10px" class="hidden-xs hidden-sm"></div>
    <div class="padding-setup">
      <div class="row home-video-wrapper">
        @foreach ($watches as $watch)
          @include('video.singleWatchIndex', ['watch' => $watch])
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection