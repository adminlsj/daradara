<div class="form-check playlist-checkbox-wrapper" style="{{ $first ? '' : '' }}">
  <label class="playlist-checkbox-container">
    <span style="font-size: 15px;">{{ $title }}</span>
    <input id="{{ $id }}" class="playlist-checkbox" type="checkbox" {{ $checked ? 'checked' : '' }}>
    <span class="playlist-checkmark"></span>
  </label>
</div>