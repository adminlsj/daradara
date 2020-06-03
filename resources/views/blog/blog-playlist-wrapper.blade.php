@foreach ($related as $video)
    <div class="related-watch-wrap hover-opacity-all" style="background-color: #F9F9F9">
    	@include('blog.singleShowRelated', ['source' => 'video'])
	</div>
@endforeach