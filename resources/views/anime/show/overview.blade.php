<div id='overview' class="tabcontent" style="display:block;">
    <div class="description">
        <h2>劇情簡介</h2>
        <div class="description-content">
            <p> {{ $anime->description }} </p>
        </div>
    </div>

    <div class="relations">
        <h2>關聯作品</h2>
        <div class="grid-wrap">
            @foreach ($related_animes as $related_anime)
                <div class="media-preview-card">
                    <a href="{{ route('anime.show', ['anime' => $related_anime, 'title' => $related_anime->getTitle($chinese)]) }}"><img src="{{ $related_anime->photo_cover }}" alt=""></a>
                    <div class="relations-content">
                        <p class="source">{{ $related_anime->getRelation($related_anime->pivot->relation) }}</p>
                        <a href="{{ route('anime.show', ['anime' => $related_anime, 'title' => $related_anime->getTitle($chinese)]) }}"><p style="font-size:14px; color:#acacac;">{{ $related_anime->getTitle($chinese) }}</p></a>
                        <p class="status">{{ $related_anime->category }} · {{ $related_anime->airing_status }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="trailer">
        <h2>宣傳片</h2>
        <iframe width="380" height="245" src="{{ $anime->trailer }}"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
    <div class="recommendations">
        <div class="recommendations-heading">
            <h2>為您推薦</h2>
            <div class="view-all">
                <button>+ 添加</button>
                <button>查看全部</button>
            </div>
        </div>
        <div class="recommendations-warp">
            <div class="recommendations-card">
                <a href=""><img src="https://i.meee.com.tw/tXI61LZ.jpg" alt=""></a>
                <a href="">銀魂</a>
            </div>
            <div class="recommendations-card">
                <a href=""><img src="https://i.meee.com.tw/CwT5WII.webp" alt=""></a>
                <a href="">七大罪</a>
            </div>
            <div class="recommendations-card">
                <a href=""><img src="https://i.meee.com.tw/PRr5kKS.jpeg" alt=""></a>
                <a href="">這個勇者明明超強卻過分慎重</a>
            </div>
            <div class="recommendations-card">
                <a href=""><img src="https://i.meee.com.tw/Qya6Ki8.png" alt=""></a>
                <a href="">不死不運</a>
            </div>
            <div class="recommendations-card">
                <a href=""><img src="https://i.meee.com.tw/GTeSnSY.jpeg" alt=""></a>
                <a href="">只有神知道的世界</a>
            </div>
        </div>
    </div>
    <div class="threads">
        <div class="threads-heading">
            <h2>討論版</h2>
            <a href="">發表意見</a>
        </div>
        <div class="threads-wrap">
            <div class="threads-card">
                <div class="title">
                    <a href="">雨宮天超棒！</a>
                    <div class="traffic">
                        <p>👁️&nbsp;739&nbsp;&nbsp;💬&nbsp;12</p>
                    </div>
                </div>
                <div class="threads-content">
                    <div class="user">
                        <img src="https://i.meee.com.tw/txMDYEy.png" alt="">
                        <p><a href="">用戶1</a> &nbsp;3小時前 </p>
                    </div>
                    <a href="" class="category">新聞</a>
                </div>
            </div>
            <div class="threads-card">
                <div class="title">
                    <a href="">完結撒花~~~~</a>
                    <div class="traffic">
                        <p>👁️&nbsp;738&nbsp;&nbsp;💬&nbsp;10</p>
                    </div>
                </div>
                <div class="threads-content">
                    <div class="user">
                        <img src="https://i.meee.com.tw/KZB44Eh.png" alt="">
                        <p><a href="">用戶2</a> &nbsp;1小時前 </p>
                    </div>
                    <a href="" class="category">動畫</a>
                </div>
            </div>
        </div>
    </div>
</div>