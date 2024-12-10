@extends('layouts.app')

@section('nav')
    @include('layouts.nav')
@endsection

@section('content')
<div class="flex-column user-profile" style="background-color:rgb(237,241,245);">
    @include('user.show.userProfile')
    @include('user.show.navTabs')

    <div class="content flex-row userlists">
        @include('user.animeList.sidebar')
        <div class="list-wrap flex-column">
            <div class="title-link flex-row">
                <h3>{{ $savelist->is_status ? App\Anime::$statuslists[$savelist->title] : $savelist->title }}</h3>
                @if (!$savelist->is_status)
                    <div class="flex-row">
                        <button class="fas fa-pen no-select pen-button" data-toggle="modal" data-target="#updateSavelist"></button>
                        @if (Auth::check() && Auth::user()->id == $user->id)
                            <form id="destroySavelistForm" action="{{ route('user.savelist.destroy', ['user' => $user, 'savelist' => $savelist->id]) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button class="trash-button" type="submit"><i class="fas fa-trash"></i></button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
            <div class="list-entries">
                <div class="list-section flex-row">
                    @foreach ($anime_saves as $anime_save)
                        @include('user.animeList.card', ['redirectTo' => "user.animelist.show.{$savelist->id}.{$savelist->title}"])
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <br>

    @if (Auth::check() && Auth::user()->id == $user->id)
        <form id="createSavelistForm" action="{{ route('user.savelist.store', ['user' => $user]) }}" method="POST">
            {{ csrf_field() }}

            <input id="type" name="type" type="hidden" value="anime">
            <input id="is_status" name="is_status" type="hidden" value="false">

            <div id="createSavelist" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="material-icons pull-left no-select modal-close-btn"
                                data-dismiss="modal">close</span>
                            <h4 class="modal-title">建立動漫清單</h4>
                        </div>
                        <div class="modal-body" style="padding: 15px 20px 5px 20px; text-align: left">
                            <h4>填寫標題及說明</h4>
                            <p style="color: darkgray; padding-bottom: 10px; margin-top: -10px; margin-left: -10px;">
                                打造屬於你的動漫清單，並向全世界分享你的收藏。</p>
                            <div class="form-group" style="margin-top: 10px;">
                                <input style="background-color: #333333; color: white; border-color: #333333;" type="text"
                                    class="form-control" name="title" id="title" placeholder="標題" required>
                            </div>
                            <div class="form-group">
                                <textarea
                                    style="background-color: #333333; color: white; border-color: #333333; height: 100%; border-radius: 4px; outline: 0px; padding: 12px; width: 100%;"
                                    id="description" name="description" rows="4" placeholder="詳細說明 (選填)"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="is_private" value="1" id="is_private">
                                <label class="no-select" for="is_private">私人清單</label>
                            </div>
                        </div>
                        <hr style="border-color: #333333; margin: 0;">
                        <div class="modal-footer">
                            <div class="toggle-playlist-modal" data-dismiss="modal">返回</div>
                            <button id="video-create-playlist-btn" method="POST"
                                class="pull-right btn btn-primary">建立播放清單</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

    @if (Auth::check() && Auth::user()->id == $user->id)
        <form id="updateSavelistForm"
            action="{{ route('user.savelist.update', ['user' => $user, 'savelist' => $savelist->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <input id="type" name="type" type="hidden" value="anime">
            <input id="is_status" name="is_status" type="hidden" value="false">

            <div id="updateSavelist" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="material-icons pull-left no-select modal-close-btn"
                                data-dismiss="modal">close</span>
                            <h4 class="modal-title">編輯動漫清單</h4>
                        </div>
                        <div class="modal-body" style="padding: 15px 20px 5px 20px; text-align: left">
                            <h4>填寫標題及說明</h4>
                            <p style="color: darkgray; padding-bottom: 10px; margin-top: -10px; margin-left: -10px;">
                                打造屬於你的動漫清單，並向全世界分享你的收藏。</p>
                            <div class="form-group" style="margin-top: 10px;">
                                <input value="{{ $savelist->title }}"
                                    style="background-color: #333333; color: white; border-color: #333333;" type="text"
                                    class="form-control" name="title" id="title" placeholder="標題" required>
                            </div>
                            <div class="form-group">
                                <textarea
                                    style="background-color: #333333; color: white; border-color: #333333; height: 100%; border-radius: 4px; outline: 0px; padding: 12px; width: 100%;"
                                    id="description" name="description" rows="4"
                                    placeholder="詳細說明 (選填)">{{ $savelist->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <input {{ $savelist->is_private ? 'checked' : '' }} type="checkbox" name="is_private"
                                    value="1" id="is_private">
                                <label class="no-select" for="is_private">私人清單</label>
                            </div>
                        </div>
                        <hr style="border-color: #333333; margin: 0;">
                        <div class="modal-footer">
                            <div class="toggle-playlist-modal" data-dismiss="modal">返回</div>
                            <button id="video-create-playlist-btn" method="POST" class="pull-right btn btn-primary">編輯播放清單</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection