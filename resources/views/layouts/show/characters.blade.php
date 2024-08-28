<div id="characters" class="tabcontent" style="display:none">
    <div class="characters-dropdown flex-row">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
            Filter
        </button>
    </div>
    <div class="characters-wrap flex-row">
        @foreach ($characters as $character)
            <div class="characters-card flex-row">
                <a href=""><img src="{{ $character->photo_cover }}" alt=""></a>
                <div class="characters-description flex-column">
                    <div class="characters-name flex-row">
                        <a href="">{{ $character->name_zht }}</a>
                        <a href="">福島潤</a>
                    </div>
                    <div class="characters-name flex-row">
                        <div>{{ $character->role }}</div>
                        <div>日文</div>
                    </div>
                </div>
                <a href=""><img src="https://i.meee.com.tw/2MBOWkt.png" alt=""></a>
            </div>
        @endforeach
    </div>
</div>