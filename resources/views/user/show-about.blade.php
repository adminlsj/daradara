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

    <div class="paravi-padding-setup" style="margin-top: 18px; padding-bottom: 5px;">
      <div>用戶名稱：{{ $user->name }}</div>
      <div>電郵地址：[***僅該用戶可查看***]</div>
    </div>
  </div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection