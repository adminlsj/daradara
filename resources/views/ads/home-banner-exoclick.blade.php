@if (!$is_mobile)
	<div class="hidden-xs hidden-sm home-banner-exoclick-md">
		@include('layouts.exoclick', ['id' => $desktop_home_1, 'width' => '900', 'height' => '250'])
	</div>

	<div class="hidden-md hidden-lg home-banner-exoclick-margin-bottom" style="text-align: center; padding-top: 30px; padding-bottom: 0px;">
		@include('layouts.exoclick', ['id' => $tablet_home_1, 'width' => '300', 'height' => '250'])

		<span class="hidden-xs" style="vertical-align: top; margin-top: 5px;">
			<!-- JuicyAds v3.1 -->
			<script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
			<ins id="940480" data-width="300" data-height="262"></ins>
			<script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':940480});</script>
			<!--JuicyAds END-->
		</span>
	</div>
@else
	<div class="hidden-sm hidden-md hidden-lg home-banner-exoclick-margin-bottom" style="text-align: center; padding-top: 30px; padding-bottom: 0px;">
		@include('layouts.exoclick', ['id' => $mobile_home_1, 'width' => '300', 'height' => '250'])
	</div>
@endif