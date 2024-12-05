<div id="characters">
    <div class="characters-wrap flex-row">
        @foreach ($characters as $character)
            @include('anime.show.character')
        @endforeach
    </div>
</div>