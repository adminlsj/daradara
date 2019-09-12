@extends('layouts.app')

@section('content')
<div style="width:78%; margin: 0 auto;" class="mobile-container">
	<div class="row video-no-gutter">
		<div class="col-md-8" style="margin-top: 15px;">
			<div class="video-sidebar-wrapper">
				@include('video.singleFBVideoPost')
				<div style="padding: 0px 15px; font-weight: 400; margin-top:-9px; margin-bottom: 10px; font-size: 1.2em;">相關影片</div>
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-format="fluid"
				     data-ad-layout-key="-7c+ef+1v-2l-f"
				     data-ad-client="ca-pub-4485968980278243"
				     data-ad-slot="7870160701"></ins>
				<br>
			    <div id="sidebar-results">
			    	<!-- results appear here -->
			    </div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif"/></div>
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
	            <!-- Content-Top -->
	            <ins class="adsbygoogle"
	                 style="display:block"
	                 data-ad-client="ca-pub-4485968980278243"
	                 data-ad-slot="4060710969"
	                 data-ad-format="auto"
	                 data-full-width-responsive="true"></ins>
	        </div>
		</div>
	</div>
</div>
@endsection