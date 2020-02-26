<nav style="background-color: white; margin-top: 50px; max-height: 20px; line-height: 20px" class="nav-sub-width">
  <div style="background-color: white" class="container-fluid">
    <div class="nav-tab-container" style="background-color: white; line-height: 10px; height: 10px">
      <a class="nav-rank-btn" href="{{ route('video.rank') }}">
        <h4 class="{{ !Request::has('g') ? 'nav-tab-active' : '' }}"><span>&nbsp;全部&nbsp;</span></h4>
      </a>
      <a class="nav-rank-btn" href="{{ route('video.rank') }}?g=variety">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'variety' ? 'nav-tab-active' : '' }}"><span>&nbsp;綜藝&nbsp;</span></h4>
      </a>
      <a class="nav-rank-btn" href="{{ route('video.rank') }}?g=drama">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'drama' ? 'nav-tab-active' : '' }}"><span>&nbsp;日劇&nbsp;</span></h4>
      </a>
      <a class="nav-rank-btn" href="{{ route('video.rank') }}?g=anime">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'anime' ? 'nav-tab-active' : '' }}"><span>&nbsp;動漫&nbsp;</span></h4>
      </a>
    </div>
  </div>
</nav>