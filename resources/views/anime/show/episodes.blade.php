<div id="episodes">
    <div class="episodes-wrap flex-row">
       @foreach ($episodes as $episode)
           @include('anime.show.episode')
       @endforeach
    </div>
</div>