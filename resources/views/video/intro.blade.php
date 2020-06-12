@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $watch->title }}&nbsp;-&nbsp;播放清單&nbsp;-&nbsp;娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $watch->title }} - 播放清單 - 娛見日本 LaughSeeJapan">
    <meta name="description" content="{{ $watch->description }}">

    @if ($first != null)
      <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "ImageObject",
        "name": "{{ $watch->title }}",
        "description": "{{ $watch->description }}",
        "contentUrl": "https://i.imgur.com/{{ $first->imgur }}l.png",
        "uploadDate": "{{ \Carbon\Carbon::parse($watch->updated_at)->format('Y-m-d\Th:i:s').'+00:00' }}"
      }
      </script>
    @endif
@endsection

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
    <div class="hidden-sm hidden-xs sidebar-menu">
	    @include('video.sidebarMenu', ['theme' => 'white'])
    </div>

    <div class="main-content">
    	<div style="background-color: #F5F5F5;">
    		<div class="row no-gutter">
    			<div class="col-md-5 intro-left">
    				@if ($first)
    					@include('video.intro-left', ['link' => route('video.watch').'?v='.$first->id.'&list='.$watch->id, 'image' => $first->imgurH(), 'title' => $first->title])
    				@else
	    				@include('video.intro-left', ['link' => '', 'image' => 'https://i.imgur.com/JMcgEkPl.jpg', 'title' => ''])
    				@endif
    			</div>
    			<div class="col-md-7 intro-right playlist-scoll-wrapper">
    				@foreach ($videos as $video)
	    				<div class="multiple-link-wrapper hover-opacity-all intro-video-list">
		    				<a href="{{ route('video.watch') }}?v={{ $video->id }}&list={{ $watch->id }}" class="overlay"></a>
	    					<div style="height: 85px;" class="inner">
		    					<img class="lazy" style="width: 155px; height: auto; float: left;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurH() }}" alt="{{ $video->title }}">
                                <span style="position: absolute; bottom: -3px; left: 6px; color: white; font-weight: bold; font-size: 1.2em;">{{ $videos->count() - $loop->index }}</span>
		    					<h4 style="margin-left: 165px; font-weight: bold; padding-right: 0px">{{ $video->title }}</h4>
                                <div style="position: absolute; bottom: 0px; left: 165px;">
                                    <img class="lazy" style="float:left; width: 18px; height: 18px; margin-top: 1px" src="{{ $video->user->avatarCircleB() }}" data-src="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}" data-srcset="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}">
                                    <a href="{{ route('user.show', [$video->user]) }}" style="color: darkgray; font-size: 0.8em; margin-left: 5px;">{{ $video->user->name }}</a>
                                </div>
		    				</div>
		    				@if ($videos->count() - $loop->index > 1)
                                <hr style="border-color: #e1e1e1; margin-top: 23px;">
                            @else
                                <div style="margin-top: 12px;"></div>
                            @endif
	    				</div>
    				@endforeach
    			</div>
    		</div>
		</div>
	</div>
@endsection