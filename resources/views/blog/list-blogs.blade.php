<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8">
		<div>
	        <h3 style="color: black; font-weight: 500">更多內容</h3>
	    </div>
		<div style="margin-top: -8px" class="sidebar-wrapper">
		    <div id="sidebar-results">
		    	@foreach ($sideBlogsMobile as $blog)
		            <div class="row hover-box-shadow" style="margin:0px -5px; padding: 15px 15px;">
                        <a href="{{ route('blog.show', ['blog' => $blog]) }}">
                            <div class="col-xs-4" style="position:relative; padding-right:5px">
		                        <div class="row">
		                            <img style="width:100%; border-radius:2px" src="{{ $blog->imgur() }}" alt="日本文化">
		                            <div class="related-blogs-date" style="font-size: 12.5px; color: gray; position:absolute; bottom:1px; right:-93px; font-weight:400;">{{ Carbon\Carbon::parse($blog->created_at)->format("Y-m-d") }}</div>
		                        </div>
		                    </div>

		                    <div style="padding: 0px 30px 0px 40px" class="col-xs-8">
	                            <div class="row">
	                                <div style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" class="blog-title">{{ $blog->title }}</div>
	                                <div class="hidden-xs" style="font-weight: 400; font-size: 13.5px; color: #696969; margin-top:10px">{{ str_limit($blog->caption, 300) }}</div>
	                            </div>
	                        </div>
                        </a>
                    </div>
		        @endforeach
		    </div>
		</div>
	</div>

	<div class="hidden-xs hidden-sm col-md-4 sticky">
		<div>
	        <h3 style="color: black; font-weight: 500; margin-bottom: 17px;">推薦內容</h3>
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
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Blog Show Ads -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-4485968980278243"
                 data-ad-slot="6532428575"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
	</div>
</div>