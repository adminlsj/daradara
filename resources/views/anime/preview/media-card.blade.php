<div class="preview-media-card media-preview-card">
	<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->getTitle($chinese)]) }}">
		<img src="{{ $anime->photo_cover }}" alt="">
		<div class="title">
			<p>{{ $anime->getTitle($chinese) }}</p>
			<a href="{{ route('company.show', ['company' => 123, 'title' => $anime->animation_studio]) }}">
				<h5>{{ $anime->animation_studio }}</h5>
			</a>
		</div>
	</a>
	<div class="relations-content">
		<div>
			<p style="padding:15px 15px 0px">{{ $anime->episodes_count }}集首播</p>
			<h3>{{ Carbon\Carbon::parse($anime->started_at)->format('Y-m-d') }}</h3>
			<p style="padding:0px 15px">來源: {{ $anime->source }}</p>
		</div>
		<p class="description">{{ $anime->description }}</p>
		<div class="tags">
			<p>tags</p>
			<p>tagsssss</p>
		</div>
	</div>
</div>