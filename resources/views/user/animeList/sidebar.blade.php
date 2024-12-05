<div class="sidebar flex-column">
    <div class="lists">
        <h3>清單</h3>
        <a href="{{ route('user.animelist', ['user' => Auth::user(), 'name' => Auth::user()->name]) }}">
            <div class="flex-row {{ Request::is('user/*/*/animelist') ? 'active' : '' }}"
                style="justify-content: space-between;">
                <div class="list">All</div>
                <div></div>
            </div>
        </a>
        @foreach ($anime_statuslists as $anime_statuslist)
            @if ($anime_statuslist->anime_saves->count() != 0)
                <a href="{{ route('user.animelist.show', ['user' => Auth::user(), 'name' => Auth::user()->name, 'savelist' => $anime_statuslist, 'title' => $anime_statuslist->title]) }}">
                    <div class="flex-row {{ Request::is("user/*/*/animelist/{$anime_statuslist->id}/*") ? 'active' : '' }}"
                        style="justify-content: space-between;">
                        <div class="list">{{ $anime_statuslist->title }}</div>
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

    <button class="no-select" data-toggle="modal" data-target="#createSavelist">
        新增動漫清單
    </button>
</div>