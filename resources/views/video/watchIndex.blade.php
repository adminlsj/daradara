@extends('layouts.app')

@section('content')

<div class="watch-index">
	<div style="margin: 0px 10px; padding-top: {{ Request::is('*drama*') || Request::is('*anime*') ? '45px' : '10px' }}" class="row">
		@foreach ($videos as $watch => $video)
			<div class="{{ $genre == 'variety' ? 'watch-variety' : 'watch-single' }}">
			    <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $genre == 'variety' ? $video->last()->id : $video->first()->id }}">
				    <img src="{{ App\Watch::find($watch)->imgur }}" style="width: 100%; height: 100%; border-radius: 4px;" alt="{{ App\Watch::find($watch)->title }}">
				    <div style="height: 50px">
					    <div style="margin-top: -27px;float: right; margin-right: 3px"><span style="background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px;">更新至第{{ $video->count() }}集</span></div>
						<h4 style="color:white; margin-top:5px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ App\Watch::find($watch)->title }}</h4>
						<p style="color: #e5e5e5; margin-top:1px; margin-bottom: 0px; font-size: 0.85em;">更新 {{ Carbon\Carbon::parse($video->last()->created_at)->format('Y.m.d') }} </p>
					</div>
				</a>
			</div>
		@endforeach
	</div>
</div>

<script>
  var x, i, j, selElmnt, a, b, c;
  /*look for any elements with the class "custom-select":*/
  x = document.getElementsByClassName("custom-select");
  for (i = 0; i < x.length; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < selElmnt.length; j++) {
      /*for each option in the original select element,
      create a new DIV that will act as an option item:*/
      c = document.createElement("DIV");
      c.innerHTML = selElmnt.options[j].innerHTML;
      c.addEventListener("click", function(e) {
          /*when an item is clicked, update the original select box,
          and the selected item:*/
          var y, i, k, s, h;
          s = this.parentNode.parentNode.getElementsByTagName("select")[0];
          h = this.parentNode.previousSibling;
          for (i = 0; i < s.length; i++) {
            if (s.options[i].innerHTML == this.innerHTML) {
              s.selectedIndex = i;
              h.innerHTML = this.innerHTML;
              y = this.parentNode.getElementsByClassName("same-as-selected");
              for (k = 0; k < y.length; k++) {
                y[k].removeAttribute("class");
              }
              this.setAttribute("class", "same-as-selected");
              break;
            }
          }
          h.click();
          window.location.href = "{{ Request::path() }}?y=" + s.options[i].value;
      });
      b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
  }
  function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
    except the current select box:*/
    var x, y, i, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    for (i = 0; i < y.length; i++) {
      if (elmnt == y[i]) {
        arrNo.push(i)
      } else {
        y[i].classList.remove("select-arrow-active");
      }
    }
    for (i = 0; i < x.length; i++) {
      if (arrNo.indexOf(i)) {
        x[i].classList.add("select-hide");
      }
    }
  }
  /*if the user clicks anywhere outside the select box,
  then close all select boxes:*/
  document.addEventListener("click", closeAllSelect);
</script>
@endsection