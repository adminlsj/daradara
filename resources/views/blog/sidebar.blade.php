<div>
    <div>
        <h3 style="color: grey; font-weight: 300">日本文化與專題</h3>
        <hr>
    </div>
    @foreach($sideBlogsDesktop as $blog)
        <div class="col-md-12">
            <a href="{{ route('blog.show', ['blog' => $blog]) }}">
                <div class="row hover-box-shadow" style="border-radius: 5px; border: solid 1px #f2f2f2; margin-bottom: 15px; background-color:white;">
                    <div class="col-xs-5 col-sm-5 col-md-5" style="padding-left: 0px; padding-right: 2px">
                        <div class="embed-responsive embed-responsive-4by3">
                            <img style="width:100%;" src="https://s3.amazonaws.com/twobayjobs/blogImgs/thumbnails/{{ $blog->id }}/{{ $blog->blogImgs->sortby('created_at')->first()->filename }}" class="embed-responsive-item" alt="日本文化">
                        </div>
                    </div>
                    <div class="col-xs-7 col-sm-7 col-md-7">
                        <div><h3 style="font-weight: 400; font-size: 15px">{{ str_limit($blog->title, 60) }}</h3></div>
                        <div class="related-blogs-date" style="font-size: 12.5px; color: #42464A">{{ Carbon\Carbon::parse($blog->created_at)->format('Y年m月d日') }}</div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
    <br>
</div>