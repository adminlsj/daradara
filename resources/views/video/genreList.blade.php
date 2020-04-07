@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
  <div style="background-color: #F5F5F5;">
    <div class="explore-slider-title paravi-padding-setup">
        <a href="{{ route('video.varietyList') }}"><h4>LaughSeeJapan 綜藝頻道</h4></a>
    </div>
    <div class="row no-gutter load-more-container">
        <div class="video-sidebar-wrapper">
            <div id="sidebar-results"><!-- results appear here --></div>
            <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
        </div>
      </div>
  </div>
</div>
@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection