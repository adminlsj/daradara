<div id="comment-create-form-wrapper" style="padding: 0px 15px;">
	<h4 style="line-height: 23px; font-weight: 400; margin-top:15px; margin-bottom: 10px; color:white; font-size: 1.15em">評論<span id="comment-count" style="margin-left: 10px; color: gray">{{ $current->comments()->count() }}</span></h4>
	@if (Auth::check())
	  <form id="comment-create-form" style="margin-top: 10px;" action="{{ route('video.createComment') }}" method="POST">
	    {{ csrf_field() }}
	    <input name="comment-type" type="hidden" value="video">
	    <input name="comment-foreign-id" type="hidden" value="{{ $current->id }}">
	    <a href="{{ route('user.show', Auth::user()) }}">
	      <img class="lazy img-circle" style="width: 35px; height: auto; float:left;" src="https://i.imgur.com/JMcgEkPs.jpg" data-src="{{ Auth::user()->avatar == null ? Auth::user()->avatarDefault() : Auth::user()->avatar->filename }}" data-srcset="{{ Auth::user()->avatar == null ? Auth::user()->avatarDefault() : Auth::user()->avatar->filename }}">
	    </a>
	    <input style="margin-left: 10px; width: calc(100% - 45px); line-height: 30px; background-color: inherit; border: none; outline: none;" type="text" id="comment-text" name="comment-text" placeholder="新增一則公開評論...">
	  </form>
	@else
	  <div data-toggle="modal" data-target="#signUpModal" style="margin-top: 10px;">
	    <img class="img-circle" style="width: 35px; height: auto; float:left;" src="https://i.imgur.com/KqDtqhMb.jpg">
	    <input style="margin-left: 10px; width: calc(100% - 45px); line-height: 30px; background-color: inherit; border: none; outline: none;" type="text" id="comment-signup-modal" placeholder="新增一則公開評論...">
	  </div>
	@endif
</div>

<hr style="border:solid 0.5px #383838; margin-top: 19px; margin-bottom: 0px">

<div id="comment-start" style="padding: 0px 15px; {{ $current->comments()->count() == 0 ? '' : 'padding-top:20px;' }}">
	@foreach ($current->comments() as $comment)
	  @include('video.singleVideoComment')
	@endforeach
</div>