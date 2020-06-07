@extends('layouts.app')

@section('head')
    @parent
    <meta property="og:url" content="{{ route('blog.show', ['blog' => $current]) }}" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="{{ $current->title }}" />
	<meta property="og:description" content="{{ $current->caption }}" />
	<meta property="og:image" content="https://i.imgur.com/{{ $current->imgur }}.jpg" />

	<meta name="title" content="{{ $current->title }} | 娛見日本 LaughSeeJapan">
	<title>{{ $current->title }} | 娛見日本 LaughSeeJapan</title>
	<meta name="description" content="{{ $current->caption }}">
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
			<div class="col-md-8 single-show-player">
				<div style="background-color: #F9F9F9; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); margin-bottom: 15px;" class="blog-content">
					<img class="lazy" style="width: 100%; height: 100%;" src="{{ $blog->imgur16by9() }}" data-src="{{ $blog->imgurH() }}" data-srcset="{{ $blog->imgurH() }}" alt="{{ $blog->title }}">
					<div class="hidden-md hidden-lg" style="background-color: white;">
					    <ins class="adsbygoogle"
					         style="display:block"
					         data-ad-format="fluid"
					         data-ad-layout-key="-ie+f-17-3w+bl"
					         data-ad-client="ca-pub-4485968980278243"
					         data-ad-slot="3332191764"></ins>
					</div>
					<div style="padding: 0px 25px 25px 25px;">
						<h3 style="line-height: 30px; font-weight: bold; font-size: 1.5em">{{ $blog->title }}</h3>

						<a href="{{ route('user.show', [$blog->user()]) }}"><img class="lazy" style="float:left; border-radius: 50%; width: 35px; height: 35px;" src="{{ $blog->user()->avatarCircleB() }}" data-src="{{ $blog->user()->avatar == null ? $blog->user()->avatarDefault() : $blog->user()->avatar->filename }}" data-srcset="{{ $blog->user()->avatar == null ? $blog->user()->avatarDefault() : $blog->user()->avatar->filename }}"></a>

					    <h5 style="margin-left: 45px; line-height: 37px;"><a style="text-decoration: none; color: dimgray; font-weight: bold" href="{{ route('user.show', [$blog->user()]) }}">{{ $blog->user()->name }}</a></h5>

					    <div style="padding-top: 8px">
							@foreach ($content as $cont)
								{!! $cont !!}
							@endforeach
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-4 single-show-list">
				<div style="padding-bottom: 7px;">
					<div class="hidden-xs hidden-sm" style="margin: 15px 15px 10px 15px;">
						<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- fixed square ad -->
						<ins class="adsbygoogle"
						     style="display:inline-block;width:100%;height:305px;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1); border-radius: 3px; background-color: #F9F9F9;"
						     data-ad-client="ca-pub-4485968980278243"
						     data-ad-slot="2765106128"></ins>
						<script>
						     (adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</div>

					<div id="blog-playlist-wrapper">
						<div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 14px; padding-bottom: 28px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/blogShow.js') }}"></script>
@endsection