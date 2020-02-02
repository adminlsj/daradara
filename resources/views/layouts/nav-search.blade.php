<nav style="background-color: #e0e0e0 !important; height: 50px; display: none;" id="searchBar" class="">
  <div style="width: 80%; max-width: 1200px; background-color: #e0e0e0 !important;" class="container-fluid responsive-frame">
    <form id="search-form" style="background-color: #e0e0e0 !important;" action="{{ route('video.searchGoogle') }}" method="GET">
      <a id="toggleSearchBar" style="color: #646464 !important; padding: 0px 15px 0px 0px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">arrow_back</i></a>

      <input id="q" name="q" style="vertical-align:middle; margin-bottom: -27px" type="text" placeholder="搜索最新日本綜藝、日劇、動漫！">

      <a id="search-submit-btn" type="submit" style="color: #646464 !important; padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </form>
  </div>
</nav>