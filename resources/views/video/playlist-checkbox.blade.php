<div class="form-check" style="{{ $last ? 'margin-bottom: 1px;' : 'margin-bottom: 15px;' }}">
  <input style="cursor: pointer; transform: scale(1.6);" class="form-check-input playlist-checkbox" type="checkbox" id="{{ $id }}" {{ $checked ? 'checked' : '' }}>
  <label style="cursor: pointer; font-size: 15px; padding-left: 15px" class="form-check-label no-select" for="{{ $id }}">
    {{ $title }}
  </label>
</div>