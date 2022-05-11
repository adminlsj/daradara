<table class="download-table">
	<tr>
		<th></th>
		<th>影片畫質</th>
		<th>檔案類型</th>
		<th class="hidden-xs">檔案大小</th>
		<th>下載鏈結</th>
	</tr>
    @foreach (array_reverse($qualities, true) as $key => $value)
		<tr>
			<td style="text-align: center;"><span style="vertical-align: middle;" class="material-icons">play_circle_filled</span></td>
			<td>
			@if ($key >= 1080)
			全高清畫質 ({{ $key }}p)
			@elseif ($key >= 720)
			高清畫質 ({{ $key }}p)
			@elseif ($key >= 360)
			標準畫質 ({{ $key }}p)
			@else
			低清畫質 ({{ $key }}p)
			@endif
			</td>
			<td>mp4</td>
			<td class="hidden-xs">N/A</td>
			<td><a class="exoclick-popunder" style="text-decoration: none; color: white; text-align: center; background-color: crimson; padding: 5px 10px; border-radius: 5px;" href="{{ $value }}" download="{{ $video->title }}">下載</a></td>
		</tr>
    @endforeach
</table>