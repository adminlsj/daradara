<div class="list-card">
    <a href="{{ route('anime.show', ['anime' => $anime_save->anime, 'title' => $anime_save->anime->getTitle($chinese)]) }}"><img style="object-fit: cover" src="{{ $anime_save->anime->photo_cover }}" alt=""></a>
    <div class="list-card-info flex-column">
        <a class="title" href="{{ route('anime.show', ['anime' => $anime_save->anime, 'title' => $anime_save->anime->getTitle($chinese)]) }}"><div>{{ $anime_save->anime->getTitle($chinese) }}</div>
        </a>
        <div class="user-review flex-row">
            <div class="progress" style="margin:0px;background-color:transparent; align-content: flex-end;">觀看至 {{ $anime_save->episode_progress ? $anime_save->episode_progress : 0 }} / {{ $anime_save->anime->episodes_count }} 集</div>
            <!-- <div class="score">10</div> -->
        </div>
    </div>
    <div class="list-card-edit" data-toggle="modal" data-target="#createSavelist{{ $anime_save->anime->id }}">
        <i style="font-size: 28px; color: rgb(237,241,245); vertical-align: middle; line-height: 30px; margin-left: 1px; -webkit-transform:scale(0.9,1); /* Safari and Chrome */ -moz-transform:scale(0.9,1); /* Firefox */ -ms-transform:scale(0.9,1); /* IE 9 */ -o-transform:scale(0.9,1); /* Opera */ transform:scale(0.9,1); /* W3C */" class="material-icons">more_horiz</i>
    </div>
</div>

@include('anime.save-panel', ['anime' => $anime_save->anime, 'status' => $anime_save->status, 'saved_lists' => $anime_save->savelists->pluck('id')->toArray()])