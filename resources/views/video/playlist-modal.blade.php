<div id="playlistModal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">將影片儲存至...</h4>
      </div>
      <div class="modal-body" style="padding: 0;">
        <form id="video-save-form" style="padding: 10px 0px" action="{{ route('video.save') }}">
          {{ csrf_field() }}

          <input id="playlist-video-id" name="playlist-video-id" type="hidden" value="{{ $current->id }}">

          <span id="playlist-save-checkbox">
            @include('video.playlist-checkbox', ['first' => true, 'checked' => $saved, 'id' => 'save', 'title' => '稍後觀看', 'private' => true])
          </span>

          @foreach ($playlists as $playlist)
            @include('video.playlist-checkbox', ['first' => false, 'checked' => $listed->where('playlist_id', $playlist->id) != '[]', 'id' => $playlist->id, 'title' => $playlist->title, 'private' => false])
          @endforeach

        </form>

      </div>

      <hr style="border-color: #333333; margin: 0;">

      <div id="create-playlist-btn" data-toggle="modal" data-target="#createPlaylistModal" class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0px 9px 0px 0px; cursor: pointer;" data-dismiss="modal">
        <div style="color: white; font-weight: bold; line-height: 46px; font-size: 15px; margin: 0;">
          <span class="material-icons" style="vertical-align: middle; font-size: 24px; margin-top: -4px; margin-right: 10px;">add</span>建立新的播放清單
        </div>
      </div>

    </div>
  </div>
</div>

<form id="video-create-playlist-form" action="{{ route('playlist.create') }}">
  {{ csrf_field() }}

  <input id="create-playlist-video-id" name="create-playlist-video-id" type="hidden" value="{{ $current->id }}">

  <div id="createPlaylistModal" class="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white">
        <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
          <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
          <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">建立新的播放清單</h4>
        </div>
        <div class="modal-body" style="padding: 15px 19px 25px 19px;">
          <h4>名稱</h4>
          <input id="playlist-title" name="playlist-title" style="margin-top: 5px; width: 100%; height: 40px !important; border-top-left-radius: 2px; border-bottom-left-radius: 2px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; background-color: #1e1e1e; border-color: #333333 !important; line-height: 40px !important; padding-left: 8px; font-size: 15px; vertical-align: middle;" class="search-nav-bar" type="text" placeholder="輸入播放清單名稱..." required>
        </div>
        <hr style="border-color: #333333; margin: 0;">
        <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
          <div class="toggle-playlist-modal" style="display: inline-block; width: 50%; float: left; line-height: 46px; color: darkgray; cursor: pointer;" data-dismiss="modal">返回</div>
          <button style="border: none; color: white; background-color: #b08fff; border-radius: 0; height: 100%; width: 50%; font-weight: bold; line-height: 34px;" method="POST" class="pull-right btn btn-primary">建立</button>
        </div>
      </div>
    </div>
  </div>
</form>