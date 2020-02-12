<nav style="background-color: #282828; margin-top: 49px; {{ Request::is('drama') || Request::is('anime') ? '' : 'display:none;' }}" class="nav-sub-width" >
  <div style="background-color: #282828" class="container-fluid">
    <div class="nav-tab-container-watch" style="background-color: white;">
      <a class="watch-year-nav">
        <h4>
          <div class="custom-select">
            <select id="watch-year-select">
              <option {{ Request::has('y') && Request::get('y') == '2020' ? 'selected' : '' }} value="2020">2020年</option>
              <option value="2020">2020年</option>
              <option {{ Request::has('y') && Request::get('y') == '2019' ? 'selected' : '' }} value="2019">2019年</option>
              <option {{ Request::has('y') && Request::get('y') == '2018' ? 'selected' : '' }} value="2018">2018年</option>
              <option {{ Request::has('y') && Request::get('y') == '2017' ? 'selected' : '' }} value="2017">2017年</option>
              <option {{ Request::has('y') && Request::get('y') == '2016' ? 'selected' : '' }} value="2016">2016年</option>
              <option {{ Request::has('y') && Request::get('y') == '2015' ? 'selected' : '' }} value="2015">2015年</option>
              <option {{ Request::has('y') && Request::get('y') == '2012' ? 'selected' : '' }} value="2012">2012年</option>
              <option {{ Request::has('y') && Request::get('y') == '2011' ? 'selected' : '' }} value="2011">2011年</option>
              <option {{ Request::has('y') && Request::get('y') == '2000' ? 'selected' : '' }} value="2000">2000年</option>
            </select>
          </div>
        </h4>
      </a>
      <a class="watch-month-nav" href="{{ Request::path() }}?y={{ Request::get('y') }}&m=1">
        <h4 class="{{ Request::has('m') && Request::get('m') == '1' ? 'nav-tab-active' : '' }}"><span>&nbsp;1月&nbsp;</span></h4>
      </a>
      <a class="watch-month-nav" href="{{ Request::path() }}?y={{ Request::get('y') }}&m=4">
        <h4 class="{{ Request::has('m') && Request::get('m') == '4' ? 'nav-tab-active' : '' }}"><span>&nbsp;4月&nbsp;</span></h4>
      </a>
      <a class="watch-month-nav" href="{{ Request::path() }}?y={{ Request::get('y') }}&m=7">
        <h4 class="{{ Request::has('m') && Request::get('m') == '7' ? 'nav-tab-active' : '' }}"><span>&nbsp;7月&nbsp;</span></h4>
      </a>
      <a class="watch-month-nav" href="{{ Request::path() }}?y={{ Request::get('y') }}&m=10">
        <h4 class="{{ Request::has('m') && Request::get('m') == '10' ? 'nav-tab-active' : '' }}"><span>&nbsp;10月&nbsp;</span></h4>
      </a>
    </div>
  </div>
</nav>

@section('script')
  @parent
  <script src="{{ mix('js/customSelect.js') }}"></script>
@endsection