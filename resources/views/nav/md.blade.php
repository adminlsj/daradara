<div style="position:fixed; top:0; width:100%; z-index:100; padding: 0 13.6%; height: 77px; line-height: 77px">
	<a href="/"><img style="width: 200px;" src="https://filedoge.com/logo.svg"></a>
	<a href="{{ Auth::check() ? route('file.index', ['user' => Auth::user()]) : route('login') }}"><div style="font-weight: 300; color: white; font-size: 16px;" class="pull-right">Profile</div></a>
	<a href="{{ Auth::check() ? route('file.index', ['user' => Auth::user()]) : route('login') }}"><div style="font-weight: 300; color: white; font-size: 16px; margin-right: 40px;" class="pull-right">Files</div></a>
	<a href="/"><div style="font-weight: 300; color: white; font-size: 16px; margin-right: 40px;" class="pull-right">Upload</div></a>
</div>