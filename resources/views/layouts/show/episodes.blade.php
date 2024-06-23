<div id="episodes" class="tabcontent" style="display:none">
    <div class="episodes-wrap">
       @foreach ($episodes as $episode)
       <div class="episodes-card">
            <a href="">
                <img src="{{ $episode->episodes_thumbnail }}" alt="">
                <div class="title">第{{ $episode->id }}集 - {{ $episode->title_zht }}</div>
            </a>
        </div>
       @endforeach
    </div>
</div>