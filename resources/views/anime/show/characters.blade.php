<div id="characters" class="tabcontent" style="display:none">
    <div class="characters-dropdown flex-row">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
            Filter
        </button>
    </div>
    <div class="characters-wrap flex-row">
        @foreach ($characters as $character)
            <div class="characters-card flex-row">
                <a href="{{ route('character.show', ['character' => $character->id, 'title' => $character->name_en]) }}"><img src="{{ $character->photo_cover }}" alt=""></a>
                <div class="characters-description flex-column">
                    <div class="characters-name flex-row">
                        <a href="{{ route('character.show', ['character' => $character->id, 'title' => $character->name_en]) }}">{{ $character->name_en }}</a>
                        @if ($character->actors->first())
                            <a class="actors" href="{{ route('staff.show', ['staff' => $character->actors->first()->id, 'title' => $character->actors->first()->name_zht]) }}">{{ $character->actors->first()->name_zht }}</a>
                        @else
                            <a href=""></a>
                        @endif
                    </div>
                    <div class="characters-name flex-row">
                        <div>{{ $character->pivot->role }}</div>
                        <div>{{ $character->actors->first() ? $character->actors->first()->language : '' }}</div>
                    </div>
                </div>
                <a href=""><img src="{{ $character->actors->first() ? $character->actors->first()->photo_cover : 'https://cdn.myanimelist.net/images/questionmark_23.gif' }}" alt=""></a>
            </div>
        @endforeach
    </div>
</div>