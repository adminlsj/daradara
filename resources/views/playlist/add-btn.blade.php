<button class="no-select playlist-show-btn playlist-show-add-btn" type="submit" style="margin-right: 3px;">
    <span id="playlist-show-add-icon" style="vertical-align: middle; font-size: 24px; margin-right: 5px; cursor: pointer;" class="material-icons">{{ $exists ? 'playlist_add_check' : 'playlist_add' }}</span><span id="playlist-show-add-text">{{ $exists ? '已儲存' : '儲存清單' }}</span>
</button>