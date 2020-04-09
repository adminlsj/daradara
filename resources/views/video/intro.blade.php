@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $watch->title }} - 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $watch->title }} - 娛見日本 LaughSeeJapan">
    <meta name="description" content="{{ $watch->description }}">

    @if ($first != null)
    	<script type="application/ld+json">
		{
		  "@context": "https://schema.org",
		  "@type": "VideoObject",
		  "name": "{{ $first->title }}",
		  "description": "{{ $first->caption == '' ? $first->title : $first->caption}}",
		  "thumbnailUrl": [
		    "https://i.imgur.com/{{ $first->imgur }}l.png"
		   ],
		  "uploadDate": "{{ \Carbon\Carbon::parse($first->created_at)->format('Y-m-d\Th:i:s').'+00:00' }}",
		  "duration": "{{ $first->durationData() }}",
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
    				<div style="position: relative; text-align: center" class="hover-opacity-all">
    					<a href="{{ route('video.watch') }}?v={{ $videos->first()->id }}">
		    				<img class="lazy" style="width: 100%; height: 100%;" src="{{ $first->imgur16by9() }}" data-src="{{ $first->imgurH() }}" data-srcset="{{ $first->imgurH() }}" alt="{{ $first->title }}">
		    				<div style="position: absolute; bottom: 0px; color: white; background-color: rgba(0, 0, 0, .8); width: 100%; height: 40px; padding-top: 10px"><i style="vertical-align:middle; font-size: 1.95em; margin-top: -3px; margin-right: 7px; margin-left: -3px" class="material-icons">play_arrow</i><span style="font-size: 1.05em">全部播放</span></div>
		    			</a>
    				</div>
    				<h3>{{ $watch->title }}</h3>
    				<h5 style="color: dimgray; font-weight: 400; margin-top: 15px">{{ $videos->count()}} 部影片 <small>•</small> {{ Carbon\Carbon::parse($watch->updated_at)->diffForHumans() }}更新</h5>
    				<h5 style="color: dimgray; font-weight: 400; margin-top: 15px; line-height: 20px">{{ $watch->description }}</h5>
    				<hr style="border-color: #e1e1e1;">
    				<a href="{{ route('user.show', [$watch->user()]) }}"><img class="lazy" style="float:left; border-radius: 50%; width: 50px; height: 50px;" src="{{ $watch->user()->avatarCircleB() }}" data-src="{{ $watch->user()->avatar == null ? $watch->user()->avatarDefault() : $watch->user()->avatar->filename }}" data-srcset="{{ $watch->user()->avatar == null ? $watch->user()->avatarDefault() : $watch->user()->avatar->filename }}"></a>
    				<h5 style="margin-top: 38px; margin-left: 65px"><a style="text-decoration: none; color: #222222" href="{{ route('user.show', [$watch->user()]) }}">{{ $watch->user()->name }}</a></h5>
    				<div style="float: right; margin-top: -25px; width: 75px">
	    				@include('video.intro-subscribe-wrapper', ['tag' => $watch->title])
    				</div>
    			</div>
    			<div class="col-md-7" style="padding-top: 12px;">
    				@foreach ($videos as $video)
	    				<div class="multiple-link-wrapper hover-opacity-all">
		    				<a href="{{ route('video.watch') }}?v={{ $video->id }}" class="overlay"></a>
	    					<div style="height: 85px" class="inner">
			    				<span style="float: left; width: 40px; font-weight: 500; padding-top: 30px; text-align: center">{{ $videos->count() - $loop->index }}</span>
		    					<img class="lazy" style="width: 150px; height: auto; float: left;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurH() }}" alt="{{ $video->title }}">
		    					<h4 style="margin-left: 200px; padding-right: 25px; font-size: 1.2em; line-height: 22px">{{ $video->title }}</h4>
		    					<h5 style="margin-left: 200px; color: dimgray; font-weight: 400; font-size: 0.95em"><a href="{{ route('user.show', [$video->watch()->user()]) }}">{{ $watch->user()->name }}</a></h5>
		    				</div>
		    				<hr style="border-color: #e1e1e1; margin-left: 40px; margin-right: 25px">
	    				</div>
    				@endforeach
    			</div>
    		</div>
		</div>
	</div>
@endsection