@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-xs hidden-sm hidden-md sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5;">
		<div class="paravi-padding-setup" style="margin-top: 10px; margin: 0 auto 0 auto; padding-top: 15px;">
			<div class="row">
				<div class="col-md-8">
					<div style="border: 1px solid black; padding: 0px">
						<h3 style="font-weight: 600; background-color: #d5d5d5; margin: 0px; padding: 10px">匿名留言板</h3>
						<div style="height: 500px; overflow-y: scroll; padding-top: 5px">
							@foreach ($feedbacks as $feedback)
								<div style="padding: 10px;">
								    <img class="img-circle" style="width: 35px; height: auto; float:left;" src="https://i.imgur.com/KqDtqhMb.jpg">
									<div class="comment-index-text" style="font-size: 0.9em;"><a style="text-decoration: none; color: gray;">{{ $feedback->name }} • <span style="color: gray;">{{ Carbon\Carbon::parse($feedback->created_at)->diffForHumans() }}</span></a></div>
									<div class="comment-index-text" style="color: #222222; font-size: 1em; margin-top: 1px;">{{ $feedback->text }}</div>
								</div>
							@endforeach
						</div>
					</div>
					<form style="margin-top: 5px; padding-bottom: 10px" action="{{ route('home.createFeedback') }}" method="POST">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-3" style="padding-right: 0px">
								<input class="form-control" style="margin-top: 10px;" type="text" id="name" name="name" placeholder="暱稱" required>
							</div>
							<div class="col-md-7">
								<input class="form-control" style="margin-top: 10px;" type="text" id="email" name="email" placeholder="電郵地址（選填）">
							</div>
						</div>
						<div class="row">
							<div class="col-md-10">
								<input class="form-control" style="margin-top: 10px;" type="text" id="text" name="text" placeholder="新增一則公開評論..." required>
							</div>
							<div class="col-md-2">
								<button class="form-control" style="margin-top: 10px; background-color: #d5d5d5" type="submit">發佈</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-4">
					<a style="color: white; text-decoration: none;" href="/terms">
						<div style="text-align: center; padding: 10px; border: 1px solid black; font-size: 1.2em" class="btn-info">服務條款</div>
					</a>
					<div style="margin-top: 10px">
						<a style="color: white; text-decoration: none;" href="/policies">
							<div style="text-align: center; padding: 10px; border: 1px solid black; font-size: 1.2em" class="btn-info">社群規範</div>
						</a>
					</div>
					<div style="margin-top: 10px">
						<a style="color: white; text-decoration: none;" href="/copyright">
							<div style="text-align: center; padding: 10px; border: 1px solid black; font-size: 1.2em" class="btn-info">版權申訴</div>
						</a>
					</div>
					<div style="margin-top: 10px">
						<a style="color: white; text-decoration: none;" href="/copyright">
							<div style="text-align: center; padding: 10px; border: 1px solid black; font-size: 1.2em" class="btn-info">電郵地址</div>
						</a>
					</div>
				</div>
			</div>
		</div>

		<script type="application/ld+json">
		{
		  "@context": "https://schema.org",
		  "@type": "Organization",
		  "url": "http://www.laughseejapan.com",
		  "name": "娛見日本 LaughSeeJapan",
		  "contactPoint": {
		    "@type": "ContactPoint",
		    "email": "laughseejapan@freemail.hu",
		    "contactType": "Customer service"
		  }
		}
		</script>
	</div>
</div>
@endsection