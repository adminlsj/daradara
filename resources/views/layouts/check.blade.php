Video Check STARTED<br>
@foreach ($videos as $video)
	@foreach ($video->sd() as $url)
		@if (strpos($url, 'https://www.instagram.com/p/') !== false)
			{!! $url = $video->getSourceIG($url) !!}
		@elseif (strpos($url, 'https://api.bilibili.com/') !== false)
			{!! $video->getSourceBB($url) !!}
		@endif
        {!! implode('', $headers = get_headers($url)) !!}
        {!! $http_response_code = substr($headers[0], 9, 3) !!}
        @if (!($http_response_code == 200))
          <span style='color:red; font-weight:600;'>/watch?v={!! $video->id !!}【{!! $video->title !!}】</span><br>
        @endif
	@endforeach
@endforeach