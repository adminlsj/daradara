<div id="genre-modal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
        <h4 class="modal-title">影片類型</h4>
      </div>
      <div class="modal-body" style="padding: 0; text-align: center">
        <input type="hidden" id="genre" name="genre" value="{{ $genre }}">

        @foreach (['全部', '裏番', '泡麵番', 'Motion Anime', '3D動畫', '同人作品', 'Cosplay'] as $option)
	        <div style="line-height: 30px" class="simple-dropdown-item genre-option {{ $genre == $option ? 'active' : ''}}"><div class="hentai-sort-options">{{ $option }}</div></div>
			<hr style="margin: 0; border-color: #323434;">
        @endforeach

		<a style="color: white; text-decoration: none; line-height: 30px" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}"><div class="simple-dropdown-item genre-option">新番預告</div></a>
		<hr style="margin: 0; border-color: #323434;">
		<a style="color: white; text-decoration: none; line-height: 30px" href="{{ route('comic.index') }}"><div class="simple-dropdown-item genre-option">H漫畫</div></a>
		<hr class="hidden-sm hidden-md hidden-lg hidden-xl" style="margin: 0; border-color: #323434;">
      </div>

      <hr style="border-color: #323434; margin: 0">
	  <div class="modal-footer">
		<div data-dismiss="modal">取消</div>
		<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	  </div>
    </div>
  </div>
</div>