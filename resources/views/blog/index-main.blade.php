<div class="hidden-xs hidden-sm">
	<div class="row">
		<div class="col-md-12">
			<div class="blog-carousel owl-carousel owl-theme">
				@foreach ($caro_blogs as $blog)
					<div class="embed-responsive embed-responsive-4by3">
						<a href="{{ route('blog.show', ['blog' => $blog]) }}">
							<img class="embed-responsive-item border-radius-2" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->first()->filename }}" alt="日本文化">
							<div class="center-align white-text" style="position:absolute;bottom:0;left:0;right:0;font-size:17px;color:white;background-color: rgba(0, 0, 0, 0.5);height:70px;padding-left:15px;padding-right:15px; border-radius: 0 0 2px 2px;">
								<span style="line-height: 70px; font-weight: 400; letter-spacing: 1px">{{ $blog->title }}</span>
							</div>
						</a>
		            </div>
				@endforeach
			</div>
		</div>
	</div>
</div>