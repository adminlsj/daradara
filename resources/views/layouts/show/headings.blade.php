<div class="headings">
    <div class="cover">
        <img src="{{ $anime->photo_cover }}" alt="">
        <div class="button-groups">
            <div class="list btn-group">
                <button class="add btn btn-secondary"
                    onclick="document.getElementById('addToList').style.display='flex'">添加至列表
                </button>

                <div id="addToList" class="modal">
                    <form class="modal-content animate" action="/action_page.php" method="post">
                        <div class="container">
                            <button class="cancel-button" type="button"
                                onclick="document.getElementById('addToList').style.display='none'">X</button>
                            <img src=" {{ $anime->photo_banner }}" alt="為美好世界獻上祝福">
                            <div class="add-to-list-cover">
                                <div class="title">
                                    <img src="{{ $anime->photo_cover }}" alt="">
                                    <h3> {{ $anime->title_ro }} </h3>
                                </div>
                                <div class="button-groups">
                                    <button class="favorite" type="button">♥</button>
                                    <button class="add">儲存</button>
                                </div>
                            </div>

                            <div class="add-to-list-content">
                                <div class="filters">
                                    <div class="filter watching-status">
                                        <h3>觀看狀態</h3>
                                        <div class="bar">
                                            <input type="search" placeholder="觀看狀態..."
                                                onclick="document.getElementById('option-watching-status').style.display='block'">
                                            <div class="scroll-wrap" id="option-watching-status">
                                                <div class="option-group">
                                                    <option value="觀看中">觀看中</option>
                                                    <option value="準備觀看">準備觀看</option>
                                                    <option value="完成觀看">完成觀看</option>
                                                    <option value="重看中">重看中</option>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="filter review-score">
                                        <h3>評分</h3>
                                        <div class="bar">
                                            <input type="number" value="0" min="0" max="10">
                                        </div>
                                    </div>

                                    <div class="filter episodes-progress">
                                        <h3>觀看進度</h3>
                                        <div class="bar">
                                            <input type="number" value="1" min="1" max="{{ $anime->episodes }}">
                                        </div>
                                    </div>

                                    <div class="filter watch-date">
                                        <h3>觀看日期</h3>
                                        <div class="bar">
                                            <input type="date">
                                        </div>
                                    </div>

                                    <div class="filter watch-enddate">
                                        <h3>完成日期</h3>
                                        <div class="bar">
                                            <input type="date">
                                        </div>
                                    </div>

                                    <div class="filter total-rewatches">
                                        <h3>觀看次數</h3>
                                        <div class="bar">
                                            <input type="number">
                                        </div>
                                    </div>

                                    <div class="filter notes">
                                        <h3>備註</h3>
                                        <div class="bar">
                                            <textarea name="" id=""></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-to-list-options filter">
                                    <h3>動漫清單</h3>
                                    <div class="user-lists">
                                        <input type="checkbox" name="雨宮天" value="雨宮天" id="雨宮天">
                                        <label for="雨宮天">雨宮天</label>
                                        <br>
                                        <input type="checkbox" name="2023神番" value="2023神番" id="2023神番">
                                        <label for="2023神番">2023神番</label>
                                        <br>
                                    </div>
                                    <div class="bar">
                                            <input type="search" placeholder="公開設定..."
                                                onclick="document.getElementById('option-list-privacy').style.display='block'">
                                            <div class="scroll-wrap" id="option-list-privacy">
                                                <div class="option-group">
                                                    <option value="公開">公開</option>
                                                    <option value="私人">私人</option>
                                                </div>
                                            </div>
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
                <div class="dropdown-menu" id="dropdownMenu" aria-labelledby="dropdownMenuButton" style="display:none;">
                    <a class="dropdown-item" href="#">添加至觀看中</a>
                    <a class="dropdown-item" href="#">添加至準備觀看</a>
                    <a class="dropdown-item" href="#">列表編輯器</a>
                </div>
            </div>
            <button class="favorite">♥</button>
        </div>
    </div>
    <div class="heading-content">
        <h3> {{ $anime->title_ro }} </h3>
        <p> {{ $anime->description }} </p>
        <div class="navtabs">
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