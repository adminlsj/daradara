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

          <div id="create-playlist-btn" data-toggle="modal" data-target="#createPlaylistModal" class="form-check playlist-checkbox-wrapper" data-dismiss="modal">
            <label class="playlist-checkbox-container" style="position: relative; padding-left: 15px; line-height: 46px;">
              <span style="vertical-align: middle; margin-left: -4px; margin-right: 4px; margin-top: -1px;" class="plus alt"></span>
              <span style="font-size: 16px; font-weight: normal; color: #3EA6FF;">新增播放清單</span>
            </label>
          </div>

          <span id="playlist-save-checkbox">
            @include('video.playlist-checkbox', ['first' => true, 'checked' => $saved, 'id' => 'save', 'title' => '稍後觀看', 'private' => true])
          </span>

          @foreach ($playlists as $playlist)
            @include('video.playlist-checkbox', ['first' => false, 'checked' => $listed->where('playlist_id', $playlist->id) != '[]', 'id' => $playlist->id, 'title' => $playlist->title, 'private' => false])
          @endforeach

        </form>

      </div>

      <hr style="border-color: #333333; margin: 0;">

      <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
        <div style="display: inline-block; width: 50%; float: left; line-height: 46px; color: darkgray; cursor: pointer;" data-dismiss="modal">返回</div>
        <button style="border: none; color: white; background-color: #b08fff; border-radius: 0; height: 100%; width: 50%; font-weight: bold; line-height: 34px; outline: 0;" class="pull-right btn btn-primary" data-dismiss="modal">完成</button>
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
          <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">建立播放清單</h4>
        </div>
        <div class="modal-body" style="padding: 15px 20px 5px 20px;">
          <h4>填寫標題及說明</h4>
          <p id="hentai-tags-text" style="color: darkgray; padding-bottom: 10px">打造屬於你的播放清單，並向全世界分享你的收藏。</p>
          <div class="form-group" style="margin-top: 10px;">
            <input style="background-color: #333333; color: white; border-color: #333333;" type="text" class="form-control" name="playlist-title" id="playlist-title" placeholder="標題" required>
          </div>
          <div class="form-group">
            <textarea style="background-color: #333333; color: white; border-color: #333333; height: 100%; border-radius: 4px; outline: 0px; padding: 12px;" id="playlist-description" name="playlist-description" rows="4" placeholder="詳細說明 (選填)"></textarea>
          </div>
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