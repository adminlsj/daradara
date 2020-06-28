@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $user->name }}&nbsp;-&nbsp;娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $user->name }} - 娛見日本 LaughSeeJapan">
    <meta name="description" content="{{ $user->name }}">
@endsection

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<div class="hidden-xs hidden-sm hidden-md sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5;">

    @include('user.show-panel')

    <div class="row no-gutter load-more-container" style="margin-top: 18px; padding-bottom: 5px;">
        <div class="video-sidebar-wrapper" style="position: relative; overflow-y: hidden;">
            <div id="sidebar-results"><!-- results appear here --></div>
            <div style="text-align: center;" class="ajax-loading-default"><img style="width: 40px; height: auto; padding-top: 20px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
            <div style="text-align: center;" class="ajax-loading"></div>
        </div>
    </div>

	</div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection