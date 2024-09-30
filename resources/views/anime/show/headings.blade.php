<div class="headings flex-row">
    <div class="cover flex-column">
        <img src="{{ $anime->photo_cover }}" alt="">
        <div class="button-groups flex-row">
            <div class="list btn-group">
                <button class="add btn btn-secondary"
                    onclick="document.getElementById('addToList').style.display='flex'">{{ $anime_save ? App\Savelist::$statuslists[$status] : '添加至列表' }}
                </button>

                <div id="addToList" class="modal">
                    <form class="modal-content animate" action="{{ route('anime.save', ['anime' => $anime]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="container flex-column">
                            <button class="cancel-button" type="button"
                                onclick="document.getElementById('addToList').style.display='none'">X</button>
                            <img src="{{ $anime->photo_banner }}" alt="為美好世界獻上祝福">
                            <div class="add-to-list-cover flex-row">
                                <div class="title flex-row">
                                    <img src="{{ $anime->photo_cover }}" alt="">
                                    <h3> {{ $anime->title_ro }} </h3>
                                </div>
                                <div class="button-groups">
                                    <button class="favorite" type="button">♥</button>
                                    <button type="submit" class="add">儲存</button>
                                </div>
                            </div>

                            <div class="add-to-list-content flex-row">
                                <div class="filters">
                                    <div class="filter watching-status">
                                        <h3>觀看狀態</h3>
                                        <div class="bar form-control">
                                            <!-- <input type="search" placeholder="觀看狀態..."
                                                onclick="document.getElementById('option-watching-status').style.display='block'">
                                            <div style="position: relative; z-index: 1000000 !important;" class="scroll-wrap" id="option-watching-status">
                                                <div class="option-group">
                                                    <option value="觀看中">觀看中</option>
                                                    <option value="準備觀看">準備觀看</option>
                                                    <option value="完成觀看">完成觀看</option>
                                                    <option value="重看中">重看中</option>
                                                </div>
                                            </div> -->
                                            <select id="status" name="status" onclick="document.getElementById('option-watching-status').style.display='block'">
                                                <div class="scroll-wrap" id="option-watching-status">
                                                    <div class="option-group">
                                                        <option value="watching">觀看狀態...</option>
                                                        <option value="watching" {{ $status == 'watching' ? 'selected' : '' }}>觀看中</option>
                                                        <option value="planning" {{ $status == 'planning' ? 'selected' : '' }}>準備觀看</option>
                                                        <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>已觀看</option>
                                                        <option value="rewatching" {{ $status == 'rewatching' ? 'selected' : '' }}>重看中</option>
                                                        <option value="paused" {{ $status == 'paused' ? 'selected' : '' }}>暫停</option>
                                                        <option value="dropped" {{ $status == 'dropped' ? 'selected' : '' }}>棄番</option>
                                                    </div>
                                                </div>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="filter episodes-progress">
                                        <h3>觀看進度</h3>
                                        <div class="bar">
                                            <input id="episode_progress" name="episode_progress" type="number" value="{{ $anime_save ? $anime_save->episode_progress : null }}" min="0" max="100000000">
                                        </div>
                                    </div>

                                    <div class="filter total-rewatches">
                                        <h3>觀看次數</h3>
                                        <div class="bar">
                                            <input id="total_rewatches" name="total_rewatches" type="number" value="{{ $anime_save ? $anime_save->total_rewatches : null }}">
                                        </div>
                                    </div>

                                    <div class="filter watch-date">
                                        <h3>觀看日期</h3>
                                        <div class="bar">
                                            <input id="start_date" name="start_date" type="date" value="{{ $anime_save ? Carbon\Carbon::parse($anime_save->start_date)->format('Y-m-d') : null }}">
                                        </div>
                                    </div>

                                    <div class="filter watch-enddate">
                                        <h3>完成日期</h3>
                                        <div class="bar">
                                            <input id="finish_date" name="finish_date" type="date" value="{{ $anime_save ? Carbon\Carbon::parse($anime_save->finish_date)->format('Y-m-d') : null }}">
                                        </div>
                                    </div>

                                    <div class="filter notes">
                                        <h3>備註</h3>
                                        <div class="bar">
                                            <textarea id="notes" name="notes" name="">{{ $anime_save ? $anime_save->notes : null }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-to-list-options filter flex-column">
                                    <h3>動漫清單</h3>
                                    <div class="user-lists">
                                        @foreach ($anime_lists as $anime_list)
                                            <input type="checkbox" name="animelists[]" value="{{ $anime_list->id }}" id="{{ $anime_list->id }}" {{ in_array($anime_list->id, $saved_lists) ? 'checked' : '' }}>
                                            <label for="{{ $anime_list->id }}">{{ $anime_list->title }}</label>
                                            <br>
                                        @endforeach
                                    </div>
                                    <hr>
                                    <div class="bar">
                                        <input type="checkbox" name="is_hidden_from_status_lists" value="1" id="is_hidden_from_status_lists" {{ $anime_save ? $anime_save->is_hidden_from_status_lists ? "checked" : '' : null }}>
                                        <label for="is_hidden_from_status_lists">Hide from status lists</label>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <button class="down btn btn-secondary dropdown-toggle dropdown" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    onclick="document.getElementById('dropdownMenu').style.display='flex'">
                    <i class="fa fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu flex-column" id="dropdownMenu" aria-labelledby="dropdownMenuButton" style="display:none;">
                    <a class="dropdown-item" href="#">添加至觀看中</a>
                    <a class="dropdown-item" href="#">添加至準備觀看</a>
                    <a class="dropdown-item" href="#">列表編輯器</a>
                </div>
            </div>
            <button class="favorite">♥</button>
        </div>
    </div>
    <div class="heading-content flex-column">
        <h3> {{ $anime->title_ro }} </h3>
        <p> {{ $anime->description }} </p>
        <div class="navtabs flex-row">
            <button class="tablinks" onclick="activeTab(event, 'overview')">簡介</button>
            <button class="tablinks" onclick="activeTab(event, 'episodes')">集數列表</button>
            <button class="tablinks" onclick="activeTab(event, 'characters')">登場人物</button>
            <button class="tablinks" onclick="activeTab(event, 'themes')">主題曲</button>
            <button class="tablinks" onclick="activeTab(event, 'staffs')">製作人員</button>
            <button class="tablinks" onclick="activeTab(event, 'comments')">討論版</button>
        </div>
    </div>
</div>

<script>
    window.addEventListener('mouseup', function (event) {
        var dropdownMenu = document.getElementById('dropdownMenu');
        if (event.target != dropdownMenu && event.target.parentNode != dropdownMenu) {
            dropdownMenu.style.display = 'none';
        }
    });  
</script>

<script>
    var modal = document.getElementById('addToList');

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<script>
    function activeTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

<script>
    window.addEventListener('mouseup', function (event) {
        var optionWatchingStatus = document.getElementById('option-watching-status');
        var optionListPrivacy = document.getElementById('option-list-privacy');

        if (event.target === optionWatchingStatus) {
            optionWatchingStatus.style.display = 'block';
        }
        else if (event.target === optionListPrivacy) {
            optionListPrivacy.style.display = 'block';
        }

        optionWatchingStatus.style.display = 'none';
        optionListPrivacy.style.display = 'none';
    });  
</script>