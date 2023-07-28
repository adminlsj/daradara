<div id="comment-create-form-wrapper" style="padding-bottom: 10px;">
	@if (Auth::check())
	  <form id="comment-create-form" style="margin-top: 0px;" action="{{ route('video.createComment') }}" method="POST">
	    {{ csrf_field() }}
	    <input name="comment-user-id" type="hidden" value={{ Auth::user()->id }}>
	    <input name="comment-type" type="hidden" value="{{ $type }}">
	    <input name="comment-foreign-id" type="hidden" value="{{ $foreign_id }}">
	    <input id="comment-count" name="comment-count" type="hidden" value="0">
	    <input id="comment-is-political" name="comment-is-political" type="hidden" value="0">
	    <a style="margin-right: 0px;">
	      <img class="img-circle" style="width: 40px; height: auto; float:left;" src="{{ Auth::user()->avatar_temp }}">
	    </a>
	    <input style="margin-left: 55px; width: calc(100% - 55px); line-height: 30px; background-color: inherit; border: none; outline: none; color: white; vertical-align: top; margin-top: -45px; font-weight: 400; padding-left: 0px;" type="text" id="comment-text" name="comment-text" placeholder="新增一則公開評論...">
	    <button id="comment-create-btn" type="submit" style="display: none;"></button>
	  </form>
	  
	@else
	  <div data-toggle="modal" data-target="#signUpModal" style="margin-top: 0px; margin-bottom: 25px;">
	    <img class="img-circle" style="width: 40px; height: auto; float:left;" src="https://cdn.jsdelivr.net/gh/jokogebai/jokogebai@v1.0.0/user_default.jpg">
	    <input disabled style="margin-left: 15px; width: calc(100% - 55px); line-height: 30px; background-color: inherit; border: none; outline: none; font-weight: 400; padding-left: 0px" type="text" id="comment-signup-modal" placeholder="新增一則公開評論...">
	  </div>
	@endif
</div>

<div id="comment-start" style="margin-bottom: -15px; padding-top: 5px;">
	@foreach ($comments as $comment)
		<span class="{{ $comment->is_political ? 'is-political' : 'not-political' }}">
		    @include('video.singleVideoComment')
		</span>
	@endforeach
</div>