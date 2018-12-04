<div>
    <div>
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