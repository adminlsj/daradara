<nav style="background-color: #e9e9e9; height: 50px; {{ request('query') != '' ? '' : 'display: none'}}" id="searchBar" class="">
  <div style="background-color: #e9e9e9;">

    <form style="background-color: #e9e9e9;" action="{{ route('video.search') }}" method="GET">
      <a id="toggleSearchBar" style="color: #646464 !important; padding: 0px 15px 0px 0px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">arrow_back</i></a>

      <input id="query" name="query" style="vertical-align:middle; margin-bottom: -27px; background-color: #e9e9e9; box-shadow: none; border-bottom: none;" type="text" value="{{ request('query') }}" placeholder="搜索最新日本綜藝、日劇、動漫！">

      <a id="search-submit-btn" type="submit" style="color: #646464 !important; padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </form>
  </div>
</nav>