<nav style="background-color: white; margin-top: 50px;" class="nav-sub-width hidden-md hidden-lg">
  <div style="background-color: white" class="container-fluid">
    <div class="nav-tab-container" style="background-color: white;">
      <a class="nav-home-btn" href="/">
        <h4 class="{{ !Request::has('g') ? 'nav-tab-active' : '' }}"><span>&nbsp;熱門&nbsp;</span></h4>
      </a>
      <a class="nav-home-btn" href="?g=newest">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'newest' ? 'nav-tab-active' : '' }}"><span>&nbsp;最新&nbsp;</span></h4>
      </a>
      <a class="nav-home-btn" href="?g=variety">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'variety' ? 'nav-tab-active' : '' }}"><span>&nbsp;綜藝&nbsp;</span></h4>
      </a>
      <a class="nav-home-btn" href="?g=drama">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'drama' ? 'nav-tab-active' : '' }}"><span>&nbsp;日劇&nbsp;</span></h4>
      </a>
      <a class="nav-home-btn" href="?g=anime">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'anime' ? 'nav-tab-active' : '' }}"><span>&nbsp;動漫&nbsp;</span></h4>
      </a>
    </div>
  </div>
</nav>