<h4>
	{{ $blog->title }}
	<span class="pull-right" style="font-size:15px;font-weight:300">
		<div style="margin-bottom:-25px">{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日')}}</div>
		<div style="display: inline !important; margin:2px">
			<div class="fb-like" data-href="https://www.facebook.com/freeriderhk/" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>

			<div class="fb-share-button right" style="margin-bottom:-50px;" data-href="https://www.facebook.com/freeriderhk/posts/1591857584440962:0" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.facebook.com%2Ffreeriderhk%2Fposts%1593758424250878%3A0&amp;src=sdkpreparse">分享</a>
		</div>
	</span>
</h4>

<br>

{!! $content !!}

<div class="right"><iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Ffreeriderhk%2F&width=450&layout=standard&action=like&show_faces=true&share=true&height=80&appId" width="260" height="80" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></div>