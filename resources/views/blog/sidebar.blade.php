<div>
    <div>
        <h3 style="color: grey; font-weight: 300">為您推薦的貼文</h3>
        <hr>
    </div>
    @foreach($relatedBlogs as $blog)
        <div class="col-md-12">
            @include('blog.related-blogs')
        </div>
        @if ($loop->iteration % 10 == 0)
            <div class="hidden-xs hidden-sm row">
                <div class="col-sm-12 col-md-12">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Home Page Ads -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-4485968980278243"
                         data-ad-slot="9914751067"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <br>
                </div>
            </div>

            <div class="visible-xs-block visible-sm-block">
                <div class="col-sm-12 col-md-12">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Home Page Ads -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-4485968980278243"
                         data-ad-slot="9914751067"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <br>
                </div>
            </div>
        @endif
    @endforeach
    <br>
</div>