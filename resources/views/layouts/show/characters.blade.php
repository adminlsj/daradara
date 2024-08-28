<div id="characters" class="tabcontent" style="display:none">
    <div class="characters-dropdown flex-row">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
            Filter
        </button>
    </div>
    <div class="characters-wrap flex-row">
        @foreach ($characters as $character)
            <div class="characters-card flex-row">
                <a href=""><img src="https://i.meee.com.tw/LTdGCqJ.png" alt=""></a>
                <div class="characters-name flex-row">
                    <a href="">{{ $character->name_zht }}</a>
                    <a href="">福島潤</a>
                </div>
                <a href=""><img src="https://i.meee.com.tw/2MBOWkt.png" alt=""></a>
            </div>
        @endforeach
    </div>
</div>