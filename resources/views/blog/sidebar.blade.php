<div>
    <div style="margin-top: 40px;">
        <h3 style="color: grey; font-weight: 300">為您推薦的貼文</h3>
        <hr>
    </div>
    @foreach($relatedBlogs as $blog)
        <div class="col-md-12">
            @include('blog.related-blogs')
        </div>
    @endforeach
    <br>
</div>

<a href="/jobs/search?location=深圳"><img style="width:100%; border: solid 1px #f2f2f2; border-radius: 3px" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-side.png" alt="Los Angeles"></a>

<h3 style="color: grey; font-weight: 300; margin-top: 35px">為您推薦的工作</h3>
<hr>
<div class="col-md-12">
    @include('blog.related-jobs')
</div>
<br>
<a href="/jobs/search?location=深圳"><img style="width:100%; border: solid 1px #f2f2f2; border-radius: 3px" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-side.png" alt="Los Angeles"></a>
<br><br><br><br><br>