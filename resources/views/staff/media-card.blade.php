<div class="media-card">
	<a class="cover" href="{{ route('staff.show', ['staff' => $staff->id, 'title' => $staff->getName($chinese)]) }}">
		<img src="{{ $staff->photo_cover }}" alt="">
	</a>
	<a style="text-decoration: none" href="{{ route('staff.show', ['staff' => $staff->id, 'title' => $staff->getName($chinese)]) }}">{{ $staff->getName($chinese) }}
	</a>
</div>