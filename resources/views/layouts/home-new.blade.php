@extends('layouts.app')

@section('nav')
	@include('nav.home')
@endsection

@section('content')
<div class="hidden-xs" style="background-color: #222222; color: #A3A3A3; width: 100%; height: 57px; line-height: 57px; padding: 0 4%; font-weight: 400; font-size: 14px; text-align: center; overflow-x: hidden;">
	<a href="https://discord.gg/WWYc9m9CUQ" style="color: #5865F2; text-decoration: underline; padding: 10px;" target="_blank">Discord</a>
	<a href="https://theporndude.com/zh" style="color: #B85A1C; text-decoration: underline; padding: 10px;" target="_blank">PornDude</a>
	<a href="https://qingse.one" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">情色網站大全</a>
	<a href="https://141jj.com/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">141JJ 導航</a>
	<a href="http://www.pornbest.org/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">PornBest  免費中文視頻</a>
	<a href="https://www.17dm.net/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">妖氣動漫導航</a>
    <a href="https://share.acgnx.net/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">末日動漫資源庫</a>
    <a href="https://moeli-desu.com/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">夢璃</a>
	<a href="https://www.sshs.pw/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">紳士會所</a>
</div>

<div class="nav-bottom-padding" style="background: #090812; background-image: linear-gradient(to bottom,#090812,#111520 100vh,#07090e 200vh);">
	<div class="hidden-xs" style="position: relative;">
		<div id="main-nav-home" style="z-index: 10000 !important; position: absolute;">
		  @include('nav.main-content')
		</div>
		<script>
			var targetOffset = $("#main-nav-home").offset().top;
			var $window = $(window).scroll(function(){
			    if ( $window.scrollTop() > targetOffset ) {   
			      $("#main-nav-home").css({"position":"fixed", 'background-color':'#141414'});
			    } else {
			      $("#main-nav-home").css({"position":"absolute", 'background-color':'transparent'});
			    }
			});
		</script>
	</div>

	<div style="position: relative; margin-top: 0px; padding-top: 100px;">

		<div class="owl-home-top-row owl-carousel owl-theme">
		    @foreach ($newest as $video)
				<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
					<div class="home-rows-videos-div" style="position: relative; display: inline-block;">
						<img src="{{ $video->cover }}">
				        <div class="owl-home-rows-title" style="position: absolute; bottom:0; left:0; white-space: initial; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%); font-weight: bold">{{ $video->title }}</div>
			        </div>
				</a>
			@endforeach
		</div>

		<script>
			var padding = $(window).width() * 0.04;
			var mobile_padding = 10;
			$('.owl-home-top-row').owlCarousel({
			    loop:true,
			    dots:false,
			    responsiveClass:true,
			    responsive:{
			        0:{
			            items:3,
			            margin:5,
			        	stagePadding: mobile_padding
			        },
			        768:{
			            items:4,
			            margin:10,
			        	stagePadding: padding
			        },
			        992:{
			            items:6,
			            margin:10,
			        	stagePadding: padding
			        },
			        1200:{
			        	items:7,
			        	margin:10,
			        	stagePadding: padding
			        }
			    }
			})
		</script>

		<div class="content-padding-new" style="margin-top: 40px;">
			<a class="home-rows-header" style="text-decoration: none;" href="/search?query=&genre=全部&sort=最新上傳">
				<h5 style="color: #8e9194;">新鮮</h3>
				<h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">最新上傳<span style="vertical-align: middle; margin-top: -2px; margin-left: 2px" class="material-icons">chevron_right</span></h3>
			</a>
			<div class="owl-home-uncover-row owl-carousel owl-theme">
				@foreach ($upload as $set)
					<div class="item">
						@foreach ($set as $video)
							@include('layouts.owl-home-uncover-row', ["video" => $video])
						@endforeach
					</div>
				@endforeach
			</div>
		</div>

		<div style="margin-top: 20px;">
			<div class="content-padding-new">
				<a class="home-rows-header" style="text-decoration: none;" href="/search?query=&genre=全部&sort=最新上傳">
					<h5 style="color: #8e9194; ">本週</h3>
					<h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">發燒影片<span style="vertical-align: middle; margin-top: -2px; margin-left: 2px" class="material-icons">chevron_right</span></h3>
				</a>
			</div>
			<div class="owl-home-row owl-carousel owl-theme">
			    @foreach ($trending as $video)
				    @include('layouts.owl-home-row', ["video" => $video])
				@endforeach
			</div>
		</div>

		<div class="content-padding-new" style="margin-top: 40px;">
			<a class="home-rows-header" style="text-decoration: none;" href="/search?query=&genre=全部&sort=最新上傳">
				<h5 style="color: #8e9194;">分類</h3>
				<h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">影片標籤<span style="vertical-align: middle; margin-top: -2px; margin-left: 2px" class="material-icons">chevron_right</span></h3>
			</a>
			<div class="owl-home-uncover-row owl-carousel owl-theme">
			    @foreach (array_chunk($tags, 2) as $set)
				    <div class="item">
				    	@foreach ($set as $item)
					    	<div class="hover-lighter" style="margin-bottom: 10px;">
								<a href="{{ $item['link'] }}" style="text-decoration: none;">
									<div style="position: relative;">
										<img style="width: 100%;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/thumbnail/2jSdwcGl.jpg">
										<img style="position: absolute; top: 0; left: 0; height: 100%; object-fit: cover; filter: brightness(60%);" src="{{ $item['imgur'] }}">
										<div style="position: absolute; width: 100%; bottom: 5px; left: 8px;">
											<div class="home-tags-title">{{ $item['title'] }}</div>
											<div class="home-tags-total">{{ $item['total'] }} 部影片</div>
									    </div>
								    </div>
								</a>
							</div>
				    	@endforeach
				    </div>
				@endforeach
			</div>
		</div>

		<script>
			$('.owl-home-uncover-row').owlCarousel({
			    loop: false,
			    margin: 10,
			    responsive:{
			        0:{
			            items:2
			        },
			        768:{
			            items:3
			        },
			        992:{
			            items:4
			        },
			        1200:{
			        	items:5
			        }
			    }
			})
		</script>

		<div style="margin-top: 40px;">
			<div class="content-padding-new">
				<a class="home-rows-header" style="text-decoration: none;" href="/search?query=&genre=全部&sort=最新上傳">
					<h5 style="color: #8e9194;">當下</h3>
					<h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">熱門影片<span style="vertical-align: middle; margin-top: -2px; margin-left: 2px" class="material-icons">chevron_right</span></h3>
				</a>
			</div>
			<div class="owl-home-row owl-carousel owl-theme">
			    @foreach ($cover as $video)
				    @include('layouts.owl-home-row', ["video" => $video])
				@endforeach
			</div>
		</div>

		<script>
			var padding = $(window).width() * 0.04;
			var mobile_padding = 10;
			$('.owl-home-row').owlCarousel({
			    loop:false,
			    dots:false,
			    responsive:{
			        0:{
			            items:3,
			            margin:5,
			            stagePadding: mobile_padding,
			        },
			        768:{
			            items:4,
			            margin:10,
			            stagePadding: padding,
			        },
			        992:{
			            items:6,
			            margin:10,
			            stagePadding: padding,
			        },
			        1200:{
			        	items:7,
			        	margin:10,
			        	stagePadding: padding,
			        }
			    }
			})
		</script>

		<div class="hidden-xs content-padding-new" style="margin-top: 40px;">
			<a class="home-rows-header" style="text-decoration: none;" href="/search?query=&genre=全部&sort=最新上傳">
				<h5 style="color: #8e9194;">動態</h3>
				<h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">正在觀看<span style="vertical-align: middle; margin-top: -2px; margin-left: 2px" class="material-icons">chevron_right</span></h3>
			</a>

			<div class="owl-home-uncover-last-row owl-carousel owl-theme">
				@foreach ($uncover->split(5) as $set)
					<div class="item">
						@foreach ($set as $video)
							@include('layouts.owl-home-uncover-row', ["video" => $video])
						@endforeach
					</div>
				@endforeach
			</div>
		</div>

		<div class="hidden-sm hidden-md hidden-lg content-padding-new" style="margin-top: 40px;">
			<a class="home-rows-header" style="text-decoration: none;" href="/search?query=&genre=全部&sort=最新上傳">
				<h5 style="color: #8e9194;">動態</h3>
				<h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">正在觀看<span style="vertical-align: middle; margin-top: -2px; margin-left: 2px" class="material-icons">chevron_right</span></h3>
			</a>

			<div class="owl-home-uncover-last-row owl-carousel owl-theme">
				@foreach ($uncover->split(2) as $set)
					<div class="item">
						@foreach ($set as $video)
							@include('layouts.owl-home-uncover-row', ["video" => $video])
						@endforeach
					</div>
				@endforeach
			</div>
		</div>

		<script>
			$('.owl-home-uncover-last-row').owlCarousel({
			    loop: false,
			    margin: 10,
			    responsive:{
			        0:{
			            items:2
			        },
			        768:{
			            items:3
			        },
			        992:{
			            items:4
			        },
			        1200:{
			        	items:5
			        }
			    }
			})
		</script>

	</div>

	<div style="margin-bottom: 15px;">
		@include('ads.home-banner-square')
	</div>

	<div style="background-color: #212121;">
		<div class="hentai-footer">
			<p>Hanime1.me 暗黑版 anime1.me 帶給你最新最全的無碼高清中文字幕Hentai成人動漫。我們提供最優質的Hentai色情動漫裏番，並以最高畫質1080p呈現的Blu-ray rip。我們的18禁H漫網站適用於手機設備，並提供全網最優質的Hentai動畫。最新最全的Hentai裏番資料庫，Hanime1.me hentai 讓你一個按鈕觀看所有Hentai成人動畫，包括最新的2020年Hentai成人動漫。在這裏，你可以找到最優質的中文字幕H動畫 24小時！免費享受hentai動漫，成人動畫，H動漫，並且更有中文字幕，不必再聽日語猜故事！這個網站是繼avbebe之後，亞洲最優質的色情工口Hentai成人動漫，並且有許多Hentai分類，包括顏射、乳交、口交、熟女、學生妹、中出、百合、肛交，以及更多！</p>

			<p>Hentai是什麼？Hentai（変態 或 へんたい），Hentai 或 成人動漫的詞源來自日本，並指色情或成人動漫和動畫，特別是來自日本的18禁H動漫和成人動畫。</p>
		</div>
	</div>
</div>

@include('layouts.nav-bottom')

@endsection