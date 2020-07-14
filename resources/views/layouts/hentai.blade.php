@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original-dark', ['theme' => 'white'])
@endsection

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
  @include('layouts.sidebarMenu', ['theme' => 'white'])
</div>

<div class="paravi-padding-setup" style="padding-top: 13px; background-color: #303030">
	<div class="row">
		@foreach ($watches as $watch)
			<div class="col-xs-4 col-sm-3 col-md-2 hover-opacity-all">
				<a href="/playlist?list={{ $watch->id }}" style="text-decoration: none;">
					<img class="lazy" style="border-radius: 3px; width: 100%; height: 100%;" src="{{ App\Image::$portrait }}" data-src="{{ $watch->cover }}" data-srcset="{{ $watch->cover }}" alt="{{ $watch->title }}">
					<div style="height: 65px; padding: 3px 1px; color: #fff; font-size: 0.95em; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 19px;">{{ $watch->title }}</div>
				</a>
			</div>
		@endforeach
	</div>
</div>

@include('layouts.nav-bottom')

@endsection