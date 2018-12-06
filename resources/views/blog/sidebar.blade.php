<div>
    <div>
        <h3 style="color: grey; font-weight: 300">日本文化與專題</h3>
        <hr>
    </div>
    @foreach($relatedBlogs as $blog)
        <div class="col-md-12">
            @include('blog.related-blogs')
        </div>
    @endforeach
    <br>
</div>