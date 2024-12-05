<div id="characters" class="tabcontent" style="display:none">
    <div class="characters-dropdown flex-row">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
            Filter
        </button>
    </div>
    <div class="characters-wrap flex-row">
        @foreach ($characters as $character)
            @include('anime.show.character')
        @endforeach
    </div>
</div>