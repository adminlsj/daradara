<nav style="background-color: {{ $backgroundColor }}" class="scroll-hide-nav" >
  <div style="width: 80%; max-width: 1200px; background-color: {{ $backgroundColor }}" class="container-fluid responsive-frame">
    <div style="background-color: {{ $backgroundColor }}">
      <a href="{{ route('blog.index') }}">
          <img src="{{ $logoImage }}" style="margin-top: -6px;" height="30" alt="娛見日本 LaughSeeJapan">
      </a>

      <a style="font-size: 25px; line-height: 50px;" href="/"> </a>

      <a class="pull-right" style="color: {{ $itemsColor }}; padding: 0px 0px 0px 15px;" href="/"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">account_circle</i></a>
      <a id="toggleSearchBar" class="pull-right" style="color: {{ $itemsColor }}; padding: 0px 0px 15px 15px; cursor: pointer;"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">search</i></a>
    </div>
  </div>
</nav>

@include('layouts.nav-search')