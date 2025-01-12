<div class="media-card" style="">
	<a style="height: 185px;" class="cover" href="{{ route('company.show', ['company' => $company->id, 'title' => $company->getName($chinese)]) }}">
		<img src="{{ $company->photo_cover }}" alt="">
	</a>
	<a style="text-decoration: none" href="{{ route('company.show', ['company' => $company->id, 'title' => $company->getName($chinese)]) }}">{{ $company->getName($chinese) }}
	</a>
</div>