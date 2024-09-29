<div id="episodes" class="tabcontent" style="display:none">
    <div class="episodes-wrap flex-row">
       @foreach ($episodes as $episode)
       <div class="episodes-card">
            <a href="">
                <img src="{{ $episode->episodes_thumbnail }}" alt="">
                <div class="title">{{ $episode->title_zht }}</div>
            </a>
        </div>
       @endforeach
    </div>
</div>