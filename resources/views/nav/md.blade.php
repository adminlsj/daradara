<div class="nav">
	<a href="/" style="font-size: 20px; font-weight: 300; color: white; text-decoration: none;">Swift<span style="font-weight: 600; margin-left: 3px;">Share</span></a>
	<a href="{{ Auth::check() ? route('file.index', ['user' => Auth::user()]) : route('login') }}"><div class="pull-right">Profile</div></a>
	<a href="{{ Auth::check() ? route('file.index', ['user' => Auth::user()]) : route('login') }}"><div style="margin-right: 20px;" class="pull-right">Files</div></a>
	<a href="/"><div style="margin-right: 20px;" class="pull-right">Upload</div></a>
</div>