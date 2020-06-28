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
    <div class="hidden-xs hidden-sm hidden-md sidebar-menu">
	    @include('video.sidebarMenu', ['theme' => 'white'])
    </div>

    <div class="main-content">
    	<div style="background-color: #F5F5F5;">
    		<div class="row no-gutter">
				@if ($first)
					@include('video.intro-left', ['link' => route('video.watch').'?v='.$first->id.'&list='.$watch->id, 'image' => $first->imgurH(), 'title' => $first->title])
				@else
    				@include('video.intro-left', ['link' => '', 'image' => 'https://i.imgur.com/JMcgEkPl.jpg', 'title' => ''])
				@endif
                <div class="intro-right">
                    @foreach ($videos as $video)
                        <div class="related-watch-wrap hover-opacity-all" style="background-color: #F9F9F9; margin-top: 0px; margin-left: 0px; margin-right: 0px;">
                            <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="row no-gutter">
                              <div style="padding-right: 4px; width: 175px;" class="col-xs-6 col-sm-6 col-md-6">
                                <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
                                <span style="position: absolute; bottom: 0px; left: 5px; color: white; font-weight: bold; font-size: 1.1em;">{{ $videos->count() - $loop->index }}</span>
                              </div>
                              <div style="padding-left: 4px; width: calc(100% - 175px)" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
                                <h4>{{ $video->title }}</h4>
                              </div>
                            </a>

                            <div style="position: absolute; bottom: 7px; left: 182px;">
                                <img class="lazy" style="float:left; width: 18px; height: 18px; margin-top: 1px" src="{{ $video->user->avatarCircleB() }}" data-src="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}" data-srcset="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}">
                                <a href="{{ route('user.show', [$video->user]) }}" style="color: darkgray; font-size: 0.8em; margin-left: 5px;">{{ $video->user->name }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
    		</div>
		</div>
	</div>
@endsection