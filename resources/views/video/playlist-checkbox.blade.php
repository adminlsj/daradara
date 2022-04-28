<div class="form-check playlist-checkbox-wrapper" style="{{ $first ? '' : '' }}">
  <label class="playlist-checkbox-container" style="position: relative;">
    <span style="font-size: 16px; font-weight: normal; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{ $title }}</span>
    <input id="{{ $id }}" class="playlist-checkbox" type="checkbox" {{ $checked ? 'checked' : '' }}>
    <span class="playlist-checkmark"></span>
    <img style="position: absolute; height: 20px; top: 14px; {{ $private ? 'right: 20px;' : 'right: 18px;' }}" src="{{ $private ? 'https://i.imgur.com/JI7zhee.png' : 'https://i.imgur.com/I8xTV0b.png' }}">
  </label>
</div>