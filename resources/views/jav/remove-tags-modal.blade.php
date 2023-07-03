<form id="remove-tags-form" action="{{ route('video.removeTags') }}" method="POST">
	{{ csrf_field() }}
	<input id="video_id" name="video_id" type="hidden" value="{{ $current->id }}">
	<div id="remove-tags-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">移除標籤</h4>
	      </div>
	      <div class="modal-body" style="overflow-y: scroll; padding-top: 0px;">
	      	<div style="background-color: #333333; margin: 0 -15px 20px -15px; padding: 5px 15px 0px 15px;">
				<h5 style="font-weight: bold">
			  		注意事項
				</h5>
			    <p style="color: darkgray; padding-bottom: 12px; font-size: 12px; padding-right: 60px; font-weight: normal;">請僅選擇符合影片內容的標籤，並勾選下方的「我是人類」，謝謝各位紳士的奉獻。</p>
		    </div>

	        <h5 style="margin-bottom: 15px; font-weight: bold">衣著服飾</h5>
	        @foreach (App\Video::$costume as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">身材外表</h5>
	        @foreach (App\Video::$body as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">交合方式</h5>
	        @foreach (App\Video::$sexpose as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">玩法性癖</h5>
	        @foreach (App\Video::$fantasy as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">劇情設定</h5>
	        @foreach (App\Video::$storysetting as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">角色扮演</h5>
	        @foreach (App\Video::$character as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">地點場所</h5>
	        @foreach (App\Video::$location as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">雜項其它</h5>
	        @foreach (App\Video::$others as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <div style="text-align: center; margin-top: 20px; margin-bottom: 10px;">
				<div style="display: inline-block; vertical-align: top;" class="h-captcha" data-sitekey="{{ config('hcaptcha.site_key') }}" data-theme="dark"></div>
		    </div>
	      </div>

	      <hr style="border-color: #323434; margin: 0">
	      <div class="modal-footer">
			<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">移除勾選標籤</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>