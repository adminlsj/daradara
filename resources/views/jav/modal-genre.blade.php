<div id="genre-modal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
        <h4 class="modal-title">影片類型</h4>
      </div>
      <div class="modal-body" style="padding: 0; text-align: center">
        <input type="hidden" id="genre" name="genre" value="{{ $genre }}">

        @foreach (['全部', '中文字幕', '日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人'] as $option)
	        <div style="line-height: 30px" class="simple-dropdown-item genre-option {{ $genre == $option ? 'active' : ''}}"><div class="hentai-sort-options">{{ $option }}</div></div>
			<hr style="margin: 0; border-color: #323434;">
        @endforeach

		<a style="color: white; text-decoration: none; line-height: 30px" href="/"><div class="simple-dropdown-item genre-option">H動漫</div></a>
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