<div class="hidden-xs hidden-sm">
	<div class="row">
		<div class="col-md-12">
			<div class="blog-carousel owl-carousel owl-theme">
				@foreach ($caro_blogs as $blog)
					<div class="embed-responsive embed-responsive-16by9">
						<a href="{{ route('blog.show', ['blog' => $blog->id]) }}">
							<img class="embed-responsive-item border-radius-2" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/{{ $blog->id }}/{{ $blog->blogImgs->first()->filename }}" alt="First slide">
							<div class="center-align white-text" style="position:absolute;bottom:0;left:0;right:0;font-size:17px;color:white;background-color: rgba(0, 0, 0, 0.5);height:70px;padding-left:15px;padding-right:15px; border-radius: 0 0 2px 2px;">
								<span style="line-height: 70px; font-weight: 300; letter-spacing: 1px">{{ $blog->title }}</span>
							</div>
						</a>
		            </div>
				@endforeach
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		@foreach ($blogs as $blog)
			<div class="col-md-6 col-ms-12">
				<div class="card">
					<div class="embed-responsive embed-responsive-4by3">
		                <a href="{{ route('blog.show', ['blog' => $blog->id]) }}">
		                	<img class="embed-responsive-item" src="https://s3.amazonaws.com/twobayjobs/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" alt="First slide">
		                </a>
	                </div>

				    <div class="card-content">
				        <a style="line-height: 25px; padding: 13px; font-weight: 300; color: grey; display:block; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" href="{{ route('blog.show', ['blog' => $blog->id]) }}">
							{{ $blog->title }}
						</a>
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>