<div class="filter format flex-row preview-button-groups" style="position: relative; justify-content:flex-end; gap:15px;">
    <a href="{{ route('preview.airing') }}">
        <div class="extra-filter-wrap no-select" style="background-color: transparent;">
            <div class="flex-column" id="preview-filter-more-btn">
                <i class="fa fa-calendar"></i>
                <h6>今週播放</h6>
            </div>
        </div>
    </a>
    <a href="{{ route('preview.index') }}">
        <div class="extra-filter-wrap no-select" style="background-color: transparent;">
            <div class="flex-column" id="preview-filter-more-btn">
                <i class="fa fa-bars"></i>
                <h6>新番表</h6>
            </div>
        </div>
    </a>
</div>