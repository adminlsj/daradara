<form id="playlistEditForm" action="{{ route('playlist.update', ['playlist' => $playlist]) }}" method="POST">
  {{ method_field('PUT') }}
  {{ csrf_field() }}

  <div id="playlistEditModal" class="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white">
        <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
          <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
          <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">編輯播放清單</h4>
        </div>
        <div class="modal-body" style="padding-bottom: 20px;">
          <h4>編輯標題及說明</h4>
          <p id="hentai-tags-text" style="color: darkgray; padding-bottom: 10px">打造屬於你的播放清單，並向全世界分享你的收藏。</p>
          <div class="form-group" style="margin-top: 10px;">
            <input style="background-color: #333333; color: white; border-color: #333333;" type="text" class="form-control" name="playlist-title" id="playlist-title" placeholder="標題" value="{{ $playlist->title }}" required>
          </div>
          <div class="form-group">
            <textarea style="background-color: #333333; color: white; border-color: #333333; height: 100%; border-radius: 4px; outline: 0px; padding: 12px;" id="playlist-description" name="playlist-description" rows="4" placeholder="詳細說明 (選填)">{{ $playlist->description }}</textarea>
          </div>

          <div class="form-check playlist-checkbox-wrapper" style="background-color: transparent; width: 120px; margin-top: -5px;">
            <label class="playlist-checkbox-container" style="position: relative; padding-left: 29px; height: 29px; line-height: 28px;">
              <span style="font-size: 14px; font-weight: normal; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; color: #e9e9e9;">刪除播放清單</span>
              <input id="playlist-delete" name="playlist-delete" class="playlist-checkbox" type="checkbox">
              <span class="playlist-checkmark" style="top: 4px; left: 1px; transform: scale(0.76);"></span>
            </label>
          </div>

        </div>
        <hr style="border-color: #333333; margin: 0; margin-top: 0px;">
        <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
          <div style="display: inline-block; width: 50%; float: left; line-height: 46px; color: darkgray; cursor: pointer;" data-dismiss="modal">返回</div>
          <button style="border: none; color: white; background-color: #b08fff; border-radius: 0; height: 100%; width: 50%; font-weight: bold; line-height: 34px;" class="pull-right btn btn-primary" type="submit">確定</button>
        </div>
      </div>
    </div>
  </div>
</form>