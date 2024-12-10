<div class="list-sidebar flex-column" style="width: 180px;">
    <div class="lists">
        <h3>清單</h3>
        <a href="{{ route('user.animelist', ['user' => Auth::user(), 'name' => Auth::user()->name]) }}">
            <div class="flex-row {{ Request::is('user/*/*/animelist') ? 'active' : '' }}"
                style="justify-content: space-between;">
                <div class="list">全部</div>
                <div></div>
            </div>
        </a>
        @foreach ($anime_statuslists as $anime_statuslist)
            @if ($anime_statuslist->anime_saves->count() != 0)
                <a href="{{ route('user.animelist.show', ['user' => Auth::user(), 'name' => Auth::user()->name, 'savelist' => $anime_statuslist, 'title' => $anime_statuslist->title]) }}">
                    <div class="flex-row {{ Request::is("user/*/*/animelist/{$anime_statuslist->id}/*") ? 'active' : '' }}"
                        style="justify-content: space-between;">
                        <div class="list">{{ App\Anime::$statuslists[$anime_statuslist->title] }}</div>
                        <div class="count">{{ $anime_statuslist->anime_saves->count() }}</div>
                    </div>
                </a>
            @endif
        @endforeach
        @foreach ($anime_lists as $anime_list)
            <a href="{{ route('user.animelist.show', ['user' => Auth::user(), 'name' => Auth::user()->name, 'savelist' => $anime_list, 'title' => $anime_list->title]) }}">
                <div class="flex-row {{ Request::is("user/*/*/animelist/{$anime_list->id}/*") ? 'active' : '' }}"
                    style="justify-content: space-between;">
                    <div class="list">{{ $anime_list->title }}</div>
                    <div class="count">{{ $anime_list->anime_saves->count() }}</div>
                </div>
            </a>
        @endforeach
    </div>

    <button style="background-color: #3db4f2; color: #fff; border-radius: 4px; font-size: 1.4rem; padding: 8px 14px; text-align: center; font-weight: normal; margin-top: 10px;" class="no-select no-button-style" data-toggle="modal" data-target="#createSavelist">
        新增動漫清單
    </button>
</div>