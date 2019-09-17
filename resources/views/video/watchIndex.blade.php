@extends('layouts.app')

@section('content')
<div style="width:78%; margin: 0 auto;" class="mobile-container">
	<div class="row video-no-gutter">
		<div class="col-md-8" style="margin-top: 15px;">
			<div>
		        <h3 class="mobile-margin-top" style="color: black; font-weight: 500; margin-top:15px; margin-bottom: 17px;">日娛節目</h3>
		    </div>
			<div class="video-sidebar-wrapper">
				@foreach ($videos as $video)
					<div style="margin-bottom: 15px;">
					  <a href="{{ route('blog.show', ['blog' => $video, 'genre' => $video->genre, 'category' => $video->category ]) }}" class="row no-gutter">
					    <div style="padding-left: 15px; padding-right: 3px; position: relative;" class="col-xs-6 col-sm-6 col-md-6">
					      <img src="{{ $video->blogImgs[0]->thumbnail }}" width="100%" height="100%">
					      <div style="position: absolute; right:3px; bottom: 0; height: 100%; width: 25%; background-color: rgba(0,0,0,.7); text-align: center; color: white;">
					      	<div style="margin: 0;position: absolute;top: 50%; left: 50%; transform: translate(-50%, -50%);">
						      	<div style="font-size: 1em;">{{ $counts[$video->category] }}</div>
						      	<div><i style="font-size: 2em;" class="material-icons">playlist_play</i></div>
					      	</div>
					      </div>
					    </div>
					    <div style="padding-top: 2px; padding-right: 15px; padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-6">
					      <h4 style="font-weight: 600; margin-top:0px; margin-bottom: 0px; font-size: 1.2em;">{{ $titles[$video->category] }}</h4>
					      <p style="color: gray; margin-top:3px; margin-bottom: 0px; font-size: 0.9em;">{{ $counts[$video->category] }}部影片</p>
					    </div>
					  </a>
					</div>
				@endforeach
			</div>
		</div>

		<div class="hidden-xs hidden-sm col-md-4 sticky">
			<div>
		        <h3 style="color: black; font-weight: 500; margin-top:15px; margin-bottom: 17px;">推薦內容</h3>
		    </div>
		    @foreach ($sideBlogsDesktop as $blog)
				<div style="border-left: black 3px solid; margin-left: 0px" class="row">
		            <a href="{{ route('blog.show', ['blog' => $blog, 'genre' => $blog->genre, 'category' => $blog->category ]) }}">
		                <div class="col-md-12">
		                    <div style="font-weight: 400; font-size: 15px; color: black">{{str_limit($blog->title, 80)}}</div>
		                    <div style="font-size: 12.5px; color: #D3D3D3; margin-top: 10px;">{{ Carbon\Carbon::parse($blog->created_at)->format("Y年m月d日") }}</div>
		                </div>
		            </a>
		        </div>
		        <br>
		    @endforeach
		    <div style="margin:5px 0px 25px 0px; border: 1px black solid">
	            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	            <!-- Content-Top -->
	            <ins class="adsbygoogle"
	                 style="display:block"
	                 data-ad-client="ca-pub-4485968980278243"
	                 data-ad-slot="4060710969"
	                 data-ad-format="auto"
	                 data-full-width-responsive="true"></ins>
	            <script>
	            (adsbygoogle = window.adsbygoogle || []).push({});
	            </script>
	        </div>
		</div>
	</div>
</div>
@endsection