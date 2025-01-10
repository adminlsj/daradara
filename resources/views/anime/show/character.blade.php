<div class="characters-card flex-row">
    <a href="{{ route('character.show', ['character' => $character->id, 'title' => $character->name_en]) }}"><img style="border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $character->photo_cover }}" alt=""></a>
    <div class="characters-description flex-column">
        <div class="characters-name characters-name-upper flex-row" style="color: rgb(92,114,138);">
            <a style="max-width: calc(100% - 65px);" href="{{ route('character.show', ['character' => $character->id, 'title' => $character->getName($chinese)]) }}">{{ $character->getName($chinese) }}</a>
            @if ($character->actors->first())
                <a style="max-width: calc(100% - 65px);" class="actors" href="{{ route('staff.show', ['staff' => $character->actors->first()->id, 'title' => $character->actors->first()->getName($chinese)]) }}">{{ $character->actors->first()->getName($chinese) }}</a>
            @else
                <a href="">Unknown</a>
            @endif
        </div>
        <div class="characters-name characters-name-lower flex-row">
            <div>{{ $character->pivot->role }}</div>
            <div>{{ $character->actors->first() ? $character->actors->first()->language : 'Japanese' }}</div>
        </div>
    </div>
    @if ($character->actors->first())
        <a href="{{ route('staff.show', ['staff' => $character->actors->first()->id, 'title' => $character->actors->first()->getName($chinese)]) }}"><img style="border-top-right-radius: 3px; border-bottom-right-radius: 3px;" src="{{ $character->actors->first()->photo_cover }}" alt="{{ $character->actors->first()->getName($chinese) }}"></a>
    @else
        <a href="#"><img style="border-top-right-radius: 3px; border-bottom-right-radius: 3px;" src="https://images2.imgbox.com/8b/b1/PSDIPPwq_o.gif" alt=""></a>
    @endif
</div>