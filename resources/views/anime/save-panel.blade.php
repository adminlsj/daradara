<form id="createSavelistForm{{ $anime->id }}" action="{{ route('anime.save', ['anime' => $anime]) }}" method="POST">
    {{ csrf_field() }}

    <input id="type" name="type" type="hidden" value="anime">
    <input id="is_status" name="is_status" type="hidden" value="false">
    <input id="redirectTo" name="redirectTo" type="hidden" value="{{ $redirectTo }}">

    <div id="createSavelist{{ $anime->id }}" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 3px 3px 0 0 !important; border: none !important;">
                <div class="modal-body" style="padding: 0px; text-align: left; background-color: white; border-radius: 3px 3px 0 0 !important; padding-bottom: 50px;">
                    <div class="photo-banner" style="position: relative;">
                        <img src="https://s4.anilist.co/file/anilistcdn/media/anime/banner/16498-8jpFCOcDmneX.jpg" alt="" style="width: 100%; height: 180px;">
                        <span style="font-size: 18px; position: absolute; right: 18px; top: 18px; color: #909399; font-weight: 400; cursor: pointer;" class="material-icons no-select modal-close-btn" data-dismiss="modal">close</span>
                    </div>
                    <div class="photo-cover flex-row">
                        <img src="{{ $anime->photo_cover }}" alt="">
                        <h3>{{ $anime->getTitle($chinese) }}</h3>
                    </div>
                    <div class="add-to-list-content" style="color: rgba(92,114,138); min-height: 285px;">
                        <div class="row" style="margin-top: 10px; padding-right: 45px;">
                            <div class="filter watching-status col-md-4">
                                <h3>觀看狀態</h3>
                                <div class="custom-select-{{ $anime->id }}-{{ isset($anime_list) ? $anime_list->id : 0 }}" style="width: 100%;">
                                    <select id="status" name="status">
                                        <option value="watching">觀看狀態...</option>
                                        <option value="watching" {{ $status == 'watching' ? 'selected' : '' }}>觀看中</option>
                                        <option value="planning" {{ $status == 'planning' ? 'selected' : '' }}>準備觀看</option>
                                        <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>已觀看</option>
                                        <option value="rewatching" {{ $status == 'rewatching' ? 'selected' : '' }}>重看中</option>
                                        <option value="paused" {{ $status == 'paused' ? 'selected' : '' }}>暫停</option>
                                        <option value="dropped" {{ $status == 'dropped' ? 'selected' : '' }}>棄番</option>
                                    </select>
                                </div>

                                <script>
                                    var x, i, j, l, ll, selElmnt, a, b, c;
                                    /* Look for any elements with the class "custom-select": */
                                    x = document.getElementsByClassName("custom-select-{{ $anime->id }}-{{ isset($anime_list) ? $anime_list->id : 0 }}");
                                    l = x.length;
                                    for (i = 0; i < l; i++) {
                                      selElmnt = x[i].getElementsByTagName("select")[0];
                                      ll = selElmnt.length;
                                      /* For each element, create a new DIV that will act as the selected item: */
                                      a = document.createElement("DIV");
                                      a.setAttribute("class", "select-selected");
                                      a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
                                      x[i].appendChild(a);
                                      /* For each element, create a new DIV that will contain the option list: */
                                      b = document.createElement("DIV");
                                      b.setAttribute("class", "select-items select-hide");
                                      for (j = 1; j < ll; j++) {
                                        /* For each option in the original select element,
                                        create a new DIV that will act as an option item: */
                                        c = document.createElement("DIV");
                                        c.innerHTML = selElmnt.options[j].innerHTML;
                                        c.addEventListener("click", function(e) {
                                            /* When an item is clicked, update the original select box,
                                            and the selected item: */
                                            var y, i, k, s, h, sl, yl;
                                            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                                            sl = s.length;
                                            h = this.parentNode.previousSibling;
                                            for (i = 0; i < sl; i++) {
                                              if (s.options[i].innerHTML == this.innerHTML) {
                                                s.selectedIndex = i;
                                                h.innerHTML = this.innerHTML;
                                                y = this.parentNode.getElementsByClassName("same-as-selected");
                                                yl = y.length;
                                                for (k = 0; k < yl; k++) {
                                                  y[k].removeAttribute("class");
                                                }
                                                this.setAttribute("class", "same-as-selected");
                                                break;
                                              }
                                            }
                                            h.click();
                                        });
                                        b.appendChild(c);
                                      }
                                      x[i].appendChild(b);
                                      a.addEventListener("click", function(e) {
                                        /* When the select box is clicked, close any other select boxes,
                                        and open/close the current select box: */
                                        e.stopPropagation();
                                        closeAllSelect(this);
                                        this.nextSibling.classList.toggle("select-hide");
                                        this.classList.toggle("select-arrow-active");
                                      });
                                    }

                                    function closeAllSelect(elmnt) {
                                      /* A function that will close all select boxes in the document,
                                      except the current select box: */
                                      var x, y, i, xl, yl, arrNo = [];
                                      x = document.getElementsByClassName("select-items");
                                      y = document.getElementsByClassName("select-selected");
                                      xl = x.length;
                                      yl = y.length;
                                      for (i = 0; i < yl; i++) {
                                        if (elmnt == y[i]) {
                                          arrNo.push(i)
                                        } else {
                                          y[i].classList.remove("select-arrow-active");
                                        }
                                      }
                                      for (i = 0; i < xl; i++) {
                                        if (arrNo.indexOf(i)) {
                                          x[i].classList.add("select-hide");
                                        }
                                      }
                                    }

                                    /* If the user clicks anywhere outside the select box,
                                    then close all select boxes: */
                                    document.addEventListener("click", closeAllSelect);
                                </script>
                            </div>

                            <div class="filter episodes-progress col-md-4">
                                <h3>觀看集數</h3>
                                <div class="bar">
                                    <input id="episode_progress" name="episode_progress" type="number"
                                        value="{{ $anime_save ? $anime_save->episode_progress : null }}"
                                        min="0" max="100000000">
                                </div>
                            </div>

                            <div class="filter total-rewatches col-md-4">
                                <h3>觀看次數</h3>
                                <div class="bar">
                                    <input id="total_rewatches" name="total_rewatches" type="number"
                                        value="{{ $anime_save ? $anime_save->total_rewatches : null }}">
                                </div>
                            </div>

                            <div class="filter watch-date col-md-4">
                                <h3>觀看日期</h3>
                                <div class="bar">
                                    <input id="start_date" name="start_date" type="date"
                                        value="{{ $anime_save ? Carbon\Carbon::parse($anime_save->start_date)->format('Y-m-d') : null }}">
                                </div>
                            </div>

                            <div class="filter watch-enddate col-md-4">
                                <h3>完成日期</h3>
                                <div class="bar">
                                    <input id="finish_date" name="finish_date" type="date"
                                        value="{{ $anime_save ? Carbon\Carbon::parse($anime_save->finish_date)->format('Y-m-d') : null }}">
                                </div>
                            </div>

                            <div class="filter notes col-md-4">
                                <h3>備註</h3>
                                <div class="bar">
                                    <textarea style="line-height: 30px;" id="notes" name="notes">{{ $anime_save ? $anime_save->notes : null }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group" style="width: 20%">
                            <h3 style="font-size: 1.3rem; color: rgba(122,133,143, .9); font-weight: 400; margin-top: 30px;">列表</h3>
                
                                @foreach ($anime_lists as $anime_list)
                                    <div style="margin-bottom: 1px;">
                                        <div style="float: left; width: 24px; display: inline-block;">
                                            <input style="filter: brightness(1.5);" type="checkbox" name="animelists[]" value="{{ $anime_list->id }}" id="{{ $anime_list->id }}" {{ in_array($anime_list->id, $saved_lists) ?  'checked' : ''}}>
                                        </div>
                                        <div style="display: inline-block; width: calc(100% - 24px);">
                                            <label style="font-size: 1.2rem; font-weight: 400; margin-top: -1px" class="no-select" for="{{ $anime_list->id }}">{{ $anime_list->title }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            <hr style="margin-top: 9px; margin-bottom: 10px;">
                            <div style="margin-bottom: 1px;">
                                <div style="float: left; width: 24px; display: inline-block; padding-left: 2px; font-weight: 400;">
                                    +
                                </div>
                                <div style="display: inline-block; width: calc(100% - 24px);">
                                    <label style="font-size: 1.2rem; font-weight: 400; margin-top: -1px; cursor: pointer;" class="no-select" for="is_private">新增播放清單</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <hr style="margin: 0;">
                <div class="modal-footer" style="background-color: #EDF1F5; border-radius: 0 0 3px 3px !important;">
                    <div style="color: rgb(92, 114, 138); margin-left: 35px;" class="toggle-playlist-modal" data-dismiss="modal">返回</div>
                    <button id="video-create-playlist-btn" method="POST" style="background-color: #3DB4F2 !important; font-weight: 400; margin-right: 35px;" class="pull-right btn btn-primary">儲存</button>
                </div>
            </div>
        </div>
    </div>
</form>