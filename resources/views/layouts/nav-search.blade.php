<nav style="z-index: 1000; background-color: #e9e9e9; height: 50px; {{ request('q') != '' ? '' : 'display: none'}}" id="searchBar" class="hidden-md hidden-lg">
  <div style="background-color: #e9e9e9;">

    <form id="search-form" style="background-color: #e9e9e9;" action="{{ route('video.searchGoogle') }}" method="GET">
      <a id="toggleSearchBar" style="color: #646464 !important; padding: 0px 15px 0px 0px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -24px" class="material-icons">arrow_back</i></a>

      <input id="q" name="q" style="vertical-align:middle; margin-bottom: -28px; background-color: #e9e9e9; box-shadow: none; border-bottom: none;" type="text" value="{{ request('q') }}" placeholder="搜索">

      <a class="search-submit-btn" type="submit" style="color: #646464 !important; position: absolute; top: 9px; right: 21px; cursor: pointer;"><i style="font-size: 27px;" class="material-icons">search</i></a>
    </form>
  </div>
</nav>