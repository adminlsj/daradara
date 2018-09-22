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

<div style="position: relative;" style="width: 100%">
    <img style="width:100%; border: solid 1px #f2f2f2; border-radius: 3px" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-banner-mobile.png" alt="Los Angeles">
    <img style="position:absolute; top: 7%; left: 7%; width: 40px; border: 1px solid white" src="https://s3.amazonaws.com/twobayjobs/system/intro/featured-company-freerider.png" alt="TKO">
    <h1 style="font-family: 'Comic Sans MS'; letter-spacing:5px; font-size: 15px; color:white; font-weight: 600; position:absolute; top: 5%; left: 23%;">TWOBAYJOBS.COM</h1>
    <h1 style="font-family: 'Comic Sans MS'; letter-spacing:5px; font-size: 20px; color:white; font-weight: 600; position:absolute; top: 13%; left: 28%;">幫您挑選兩岸好工作</h1>
</div>

<h3 style="color: grey; font-weight: 300; margin-top: 35px">為您推薦的工作</h3>
<hr>
<div class="col-md-12">
    @include('blog.related-jobs')
</div>
<br>
<a href="/jobs/search?location=深圳"><img style="width:100%; border: solid 1px #f2f2f2; border-radius: 3px" src="https://s3.amazonaws.com/twobayjobs/system/intro/poster-side.png" alt="Los Angeles"></a>
<br><br><br><br><br>