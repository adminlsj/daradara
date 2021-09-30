<div id="comment-create-form-wrapper" style="padding-bottom: 10px;">
	@if (Auth::check())
	  <form id="comment-create-form" style="margin-top: 0px;" action="{{ route('video.createComment') }}" method="POST">
	    {{ csrf_field() }}
	    <input name="comment-user-id" type="hidden" value={{ Auth::user()->id }}>
	    <input name="comment-type" type="hidden" value="video">
	    <input name="comment-foreign-id" type="hidden" value="{{ $video_id }}">
	    <input name="comment-count" type="hidden" value={{ $comments->count() }}>
	    <a style="margin-right: 0px;">
	      <img class="img-circle" style="width: 40px; height: auto; float:left;" src="{{ Auth::user()->avatar_temp }}">
	    </a>
	    <input style="margin-left: 55px; width: calc(100% - 55px); line-height: 30px; background-color: inherit; border: none; outline: none; color: white; vertical-align: top; margin-top: -45px; font-weight: 400;" type="text" id="comment-text" name="comment-text" placeholder="新增一則公開評論...">
	  </form>
	  
	@else
	  <div data-toggle="modal" data-target="#signUpModal" style="margin-top: 0px; margin-bottom: 25px;">
	    <img class="img-circle" style="width: 40px; height: auto; float:left;" src="https://i.imgur.com/KqDtqhMb.jpg">
	    <input style="margin-left: 15px; width: calc(100% - 55px); line-height: 30px; background-color: inherit; border: none; outline: none; font-weight: 400;" type="text" id="comment-signup-modal" placeholder="新增一則公開評論...">
	  </div>
	@endif
</div>

<div id="comment-start" style="margin-bottom: -15px;">
	@foreach ($comments as $comment)
		@if ($loop->first)
			<div style="margin-top: 5px"></div>
		@endif
	    @include('video.singleVideoComment')
	@endforeach
</div>