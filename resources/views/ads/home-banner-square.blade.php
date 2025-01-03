@if (!$is_mobile)
	<div class="hidden-xs hidden-sm" style="margin-top: 50px; margin-bottom: 50px; padding-top: 5px; padding-bottom: 40px; text-align: center;">
		@include('layouts.exoclick', ['id' => $desktop_home_3, 'width' => '900', 'height' => '250'])
	</div>

	<div class="hidden-md hidden-lg" style="text-align: center; padding-top: 35px; padding-bottom: 50px;">
		@include('layouts.exoclick', ['id' => $tablet_home_3, 'width' => '300', 'height' => '250'])

		<span class="hidden-xs" style="vertical-align: top; margin-top: 5px;">
			<!-- JuicyAds v3.1 -->
			<script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
			<ins id="940480" data-width="300" data-height="262"></ins>
			<script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':940480});</script>
			<!--JuicyAds END-->
		</span>
	</div>
@else
	<div class="hidden-sm hidden-md hidden-lg" style="text-align: center; padding-top: 35px; padding-bottom: 55px;">
		@include('layouts.exoclick', ['id' => $mobile_home_3, 'width' => '300', 'height' => '250'])
	</div>
@endif