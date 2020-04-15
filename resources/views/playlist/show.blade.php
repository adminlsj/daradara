@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $playlist->title }} - 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $playlist->title }} - 娛見日本 LaughSeeJapan">
    <meta name="description" content="{{ $playlist->description }}">

    @if ($first != null)
    	<script type="application/ld+json">
		{
		  "@context": "https://schema.org",
		  "@type": "VideoObject",
		  "name": "{{ $first->title }}",
		  "description": "{{ $first->description == '' ? $first->title : $first->description}}",
		  "thumbnailUrl": [
		    "https://i.imgur.com/{{ $first->imgur }}l.png"
		   ],
		  "uploadDate": "{{ \Carbon\Carbon::parse($first->created_at)->format('Y-m-d\Th:i:s').'+00:00' }}",
		  "duration": "PT25M54S",
		  @if ($first->outsource)
		      "embedUrl": "{!! $first->source() !!}",
		  @else
		      "contentUrl": "{!! $first->source() !!}",
		  @endif
		  "interactionStatistic": {
		    "@type": "InteractionCounter",
		    "interactionType": { "@type": "http://schema.org/WatchAction" },
		    "userInteractionCount": {{ $first->views }}
		  }
		}
		</script>
    @endif
@endsection

@section('nav')
	@include('nav.top')
@endsection

@section('content')
	<div class="hidden-sm hidden-xs sidebar-menu">
	    @include('nav.side')
	</div>

    <div class="main-content">
    	<div style="background-color: #F5F5F5;">
    		<div class="row no-gutter">
    			<div class="col-md-5" style="padding: 21px 30px 25px 30px; background-color: #F9F9F9; min-height: 100%;">
    				@if ($videos->first())
    					@include('playlist.show-left', ['link' => route('video.show').'?v='.$videos->first()->id.'&list='.$playlist->id, 'image' => $first->imgurH(), 'title' => $first->title])
    				@else
	    				@include('playlist.show-left', ['link' => '', 'image' => 'https://i.imgur.com/JMcgEkPl.jpg', 'title' => ''])
    				@endif
    			</div>
    			<div class="col-md-7" style="padding-top: 12px;">
    				@foreach ($videos as $video)
	    				<div class="multiple-link-wrapper hover-opacity-all intro-video-list">
		    				<a href="{{ route('video.show') }}?v={{ $video->id }}&list={{ $playlist->id }}" class="overlay"></a>
	    					<div style="height: 85px" class="inner">
			    				<span style="float: left; width: 40px; font-weight: 500; padding-top: 30px; text-align: center">{{ $videos->count() - $loop->index }}</span>
		    					<img class="lazy" style="width: 150px; height: auto; float: left;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurH() }}" alt="{{ $video->title }}">
		    					<h4>{{ $video->title }}</h4>
		    					<h5><a href="{{ route('user.show', [$video->playlist()->user()]) }}">{{ $playlist->user()->name }}</a></h5>
		    				</div>
		    				<hr style="border-color: #e1e1e1; margin-left: 40px; margin-right: 25px">
	    				</div>
    				@endforeach
    			</div>
    		</div>
		</div>
	</div>
@endsection