<div id="comment-create-form-wrapper" style="padding-bottom: 20px;">
	<h4 style="line-height: 30px; font-weight: 500; font-size: 1.25em; margin-top: -8px; color: white"><span id="comment-count">{{ $comments->count() }}</span>&nbsp;則評論</h4>
	@if (Auth::check())
	  <form id="comment-create-form" style="margin-top: 12px;" action="{{ route('video.createComment') }}" method="POST">
	    {{ csrf_field() }}
	    <input name="comment-type" type="hidden" value="video">
	    <input name="comment-foreign-id" type="hidden" value="{{ $current->id }}">
	    <a href="{{ route('user.show', Auth::user()) }}">
	      <img class="lazy img-circle" style="width: 35px; height: auto; float:left;" src="https://i.imgur.com/JMcgEkPs.jpg" data-src="{{ Auth::user()->avatar == null ? Auth::user()->avatarDefault() : Auth::user()->avatar->filename }}" data-srcset="{{ Auth::user()->avatar == null ? Auth::user()->avatarDefault() : Auth::user()->avatar->filename }}">
	    </a>
	    <input style="margin-left: 10px; width: calc(100% - 45px); line-height: 30px; background-color: inherit; border: none; outline: none; color: white;" type="text" id="comment-text" name="comment-text" placeholder="新增一則公開評論...">
	  </form>
	@else
	  <div data-toggle="modal" data-target="#signUpModal" style="margin-top: 12px;">
	    <img class="img-circle" style="width: 35px; height: auto; float:left;" src="https://i.imgur.com/KqDtqhMb.jpg">
	    <input style="margin-left: 10px; width: calc(100% - 45px); line-height: 30px; background-color: inherit; border: none; outline: none;" type="text" id="comment-signup-modal" placeholder="新增一則公開評論...">
	  </div>
	@endif
</div>

<div id="comment-start">
	@foreach ($comments as $comment)
		@if ($loop->first)
			<div style="margin-top: 5px"></div>
		@endif
	    @include('video.singleVideoComment')
	@endforeach
</div>