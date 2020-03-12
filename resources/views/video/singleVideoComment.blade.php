<a href="{{ route('user.show', $comment->user()) }}">
  <img class="img-circle" style="width: 35px; height: auto; float:left;" src="{{ $comment->user()->avatar == null ? $comment->user()->avatarDefault() : $comment->user()->avatar->filename }}">
</a>
<div style="padding-left: 45px; font-size: 0.9em;"><a style="text-decoration: none; color: gray;" href="{{ route('user.show', $comment->user()) }}">{{ $comment->user()->name }} • <span style="color: gray;">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span></a></div>
<div style="color: white; font-size: 1em; padding-left: 45px; margin-top: 1px;">{{ $comment->text }}</div>
<br>