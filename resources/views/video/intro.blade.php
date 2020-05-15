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
    			<div class="col-md-5" style="padding: 21px 30px 25px 30px; background-color: #F9F9F9; min-height: 100%;">
    				@if ($videos->first())
    					@include('video.intro-left', ['link' => route('video.watch').'?v='.$videos->first()->id.'&list='.$watch->id, 'image' => $first->imgurH(), 'title' => $first->title])
    				@else
	    				@include('video.intro-left', ['link' => '', 'image' => 'https://i.imgur.com/JMcgEkPl.jpg', 'title' => ''])
    				@endif
    			</div>
    			<div class="col-md-7" style="padding-top: 12px;">
    				@foreach ($videos as $video)
	    				<div class="multiple-link-wrapper hover-opacity-all intro-video-list">
		    				<a href="{{ route('video.watch') }}?v={{ $video->id }}&list={{ $watch->id }}" class="overlay"></a>
	    					<div style="height: 85px" class="inner">
			    				<span style="float: left; width: 40px; font-weight: 500; padding-top: 30px; text-align: center">{{ $videos->count() - $loop->index }}</span>
		    					<img class="lazy" style="width: 150px; height: auto; float: left;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurH() }}" alt="{{ $video->title }}">
		    					<h4>{{ $video->title }}</h4>
		    					<h5><a href="{{ route('user.show', [$video->watch()->user()]) }}">{{ $watch->user()->name }}</a></h5>
		    				</div>
		    				<hr style="border-color: #e1e1e1; margin-left: 40px; margin-right: 25px">
	    				</div>
    				@endforeach
    			</div>
    		</div>
		</div>
	</div>
@endsection