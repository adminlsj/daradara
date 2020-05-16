<div class="row paravi-padding-setup" style="padding-top: 10px;">
	<div style="padding: 0px 10px;">
		<div class="col-xs-6 col-sm-3 col-md-2 hover-opacity-all" style="padding-left:8px; padding-right:8px; margin-bottom: 6px; position: relative; width: 20%">
			<div style="background-color: {{ $color }}; border-radius: 3px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1);">
				<div style="width: 100%; padding-bottom: 56.25%;"></div>
				<div style="position: relative; height: 82px;"></div>​
			</div>
			<div style="color: black; border-radius: 3px; text-align: center; height: inherit; position: absolute; margin: 0; width: 100%; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">
				<div style="font-weight: normal; font-size: 1em">{{ $subtitle }}</div>
				<div style="font-weight: bold; font-size: 1.5em; line-height: 40px">{{ $title }}</div>
			</div>
		</div>
		@foreach ($videos as $video)
			@include('video.new-singleHomeVideo')
		@endforeach
	</div>
</div>