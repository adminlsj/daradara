@extends('layouts.app')

@section('content')
<div class="container" style="width:90%;">
	<div class="row">
		<div class="col-md-8 col-ms-12 blog-content">
			<img class="img-responsive border-radius-2" style="width:100%;height:100%" src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="First slide">
			
			<div class="">
				<h4 style="padding-top: 10px">
					{{ $blog->title }}
					<span class="pull-right" style="font-size:15px;font-weight:300">
						<div style="margin-bottom:-25px">{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日') }}</div>
					</span>
				</h4>
				<br>
				{!! $content !!}
				<div class="right"><iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Ffreeriderhk%2F&width=450&layout=standard&action=like&show_faces=true&share=true&height=80&appId" width="260" height="80" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>
			</div>

			<br>

			<div class="row">
				<div class="col-md-12 col-ms-12">
				    <h3 style="color: grey; font-weight: 300">推薦的貼文</h3>
					<hr>
				</div>
			</div>
			@foreach ($similar_blogs as $blog)
				<div class="col-md-6 col-ms-12">
					<div class="card">
		                <a href="{{ route('blog.show', ['blog' => $blog->id]) }}"><img class="img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="First slide"></a>

					    <div class="card-content">
					        <a style="line-height: 25px; padding: 13px; font-weight: 300; color: grey; display:block; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" href="{{ route('blog.show', ['blog' => $blog->id]) }}">
								{{ $blog->title }}
							</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>
			
		<div class="col-md-4" style="padding-left: 25px">
			@include('blog.sidebar')
		</div>
	</div>
</div>
@endsection