<div id="episodes" class="tabcontent">
    <div class="episodes-wrap flex-row">
       @foreach ($episodes as $episode)
       <div class="episodes-card">
            <a href="">
                <img src="https://images2.imgbox.com/ef/9a/b5E1kCpS_o.jpg" alt="">
                <div class="title">{{ $episode->title_zhs ? $episode->title_jp.' / '.$episode->title_zhs : $episode->title_jp}}</div>
            </a>
        </div>
       @endforeach
    </div>
</div>