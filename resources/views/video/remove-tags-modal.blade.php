<form id="remove-tags-form" action="{{ route('video.removeTags') }}" method="POST">
	{{ csrf_field() }}
	<input id="video_id" name="video_id" type="hidden" value="{{ $current->id }}">
	<div id="remove-tags-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">移除標籤</h4>
	      </div>
	      <div class="modal-body" style="overflow-y: scroll; padding-top: 0px;">
	      	<div style="background-color: #333333; margin: 0 -15px 20px -15px; padding: 5px 15px 0px 15px;">
				<h5 style="font-weight: bold">
			  		注意事項
				</h5>
			    <p style="color: darkgray; padding-bottom: 12px; font-size: 12px; padding-right: 60px;">請僅選擇符合影片內容的標籤，並勾選下方的「我不是機器人」，謝謝各位紳士的合作。</p>
		    </div>

	        <h5 style="margin-bottom: 15px; font-weight: bold">人物設定：</h5>
	        @foreach (App\Video::$setting as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">職業設定：</h5>
	        @foreach (App\Video::$profession as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">外貌身材：</h5>
	        @foreach (App\Video::$appearance as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">劇情內容：</h5>
	        @foreach (App\Video::$storyline as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : 'disabled' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <div style="text-align: center; margin-top: 16px; margin-bottom: 10px;">
				<div style="display: inline-block; vertical-align: top;" class="g-recaptcha" data-sitekey="{{ config('google_captcha.site_key') }}" data-theme="dark"></div>
		    </div>
	      </div>

	      <hr style="border-color: #3a3c3f; margin: 0">
	      <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
			<div style="display: inline-block; width: 50%; float: left; line-height: 46px; color: darkgray; cursor: pointer;" data-dismiss="modal">取消</div>
			<button style="border: none; color: white; background-color: #b08fff; border-radius: 0; height: 100%; width: 50%; font-weight: bold; line-height: 34px;" class="pull-right btn btn-primary" type="submit">儲存</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>