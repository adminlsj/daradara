@extends('layouts.app')

@section('content')
<div style="width:100%">
	<div class="fb-video"
              data-href="https://www.facebook.com/laughseejapan/videos/647389892359730/"
              data-width="auto"
              data-allowfullscreen="false"
              data-autoplay="false"
              data-show-captions="false"></div>
	<div class="row">
		<div class="fb-video"
              data-href="https://www.facebook.com/laughseejapan/videos/647389892359730/"
              data-width="auto"
              data-allowfullscreen="false"
              data-autoplay="false"
              data-show-captions="false"></div>


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