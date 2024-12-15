<div class="landing-section">
	<div class="title-link">
		<a href="">
			<h3>{{ $title }}<span class="title-link-expand pull-right">顯示更多</span></h3>
		</a>
	</div>
	<div class="media-wrap">
		@foreach ($animes as $anime)
			@include('home.media-card')
		@endforeach
	</div>
</div>