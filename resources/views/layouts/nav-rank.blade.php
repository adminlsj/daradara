<nav style="background-color: white; margin-top: 49px;" class="scroll-hide-nav" >
  <div style="width: 80%; max-width: 1200px; background-color: white" class="container-fluid responsive-frame">
    <div class="nav-tab-container" style="background-color: white;">
      <a href="{{ route('video.rank') }}" style="width: 25%; float:left; text-align: center; text-decoration: none;">
        <h4 class="{{ !Request::has('g') ? 'nav-tab-active' : '' }}"><span>&nbsp;全部&nbsp;</span></h4>
      </a>
      <a href="{{ route('video.rank') }}?g=variety" style="width: 25%; float:left; text-align: center; text-decoration: none;">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'variety' ? 'nav-tab-active' : '' }}"><span>&nbsp;綜藝&nbsp;</span></h4>
      </a>
      <a href="{{ route('video.rank') }}?g=drama" style="width: 25%; float:left; text-align: center; text-decoration: none;">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'drama' ? 'nav-tab-active' : '' }}"><span>&nbsp;日劇&nbsp;</span></h4>
      </a>
      <a href="{{ route('video.rank') }}?g=anime" style="width: 25%; float:left; text-align: center; text-decoration: none;">
        <h4 class="{{ Request::has('g') && Request::get('g') == 'anime' ? 'nav-tab-active' : '' }}"><span>&nbsp;動漫&nbsp;</span></h4>
      </a>
    </div>
  </div>
</nav>