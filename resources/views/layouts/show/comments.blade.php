<div id="comments" class="tabcontent">
<div class="description">
        <div class="ranking-seasonal">
            <strong>⭐ <a href="">季度排名 #1</a></strong>
        </div>
        <div class="ranking-yearly">
            <strong>⭐ <a href="">年度排名 #1</a></strong>
        </div>
        <div class="ranking-all">
            <strong>🏆 <a href="">動畫總排名 #31</a></strong>
        </div>
        <div class="ranking-following">
            <strong>❤️ <a href="">喜愛總數 #23</a></strong>
        </div>
        <div class="long-des">
            <pre>
<h3>資訊</h3>
<strong>動畫類別</strong>
<a href="">{{ $anime->category }}</a>

<strong>集數</strong>
{{ $anime->episodes }}

<strong>集數總長</strong>
{{ $anime->episodes_length }}分鐘

<strong>播放狀態</strong>
<a href="">{{ $anime->airing_status }}</a>

<strong>首播日期</strong>
{{ $anime->started_at }}

<strong>完播日期</strong>
{{ $anime->ended_at }}

<strong>季番</strong>
<a href="">{{ $anime->season }}</a>

<strong>更新時間</strong>
<a href="">週三</a> 23:30

<strong>動畫社</strong>
<a href="">{{ $anime->animation_studio }}</a>

<strong>類別</strong>
<a href="">搞笑</a>
<a href="">戀愛</a>
<a href="">日常</a>
<a href="">異世界</a>

<h3>評分</h3>
daradara    {{ $anime->rating }}/100
MyAnimeList {{ $anime->rating_mal }}/10
AniList     {{ $anime->rating_al }}/100
bangumi     4.5/5

<h3>副標題</h3>
<strong>繁體:</strong> {{ $anime->title_zht }}
<strong>簡體:</strong> {{ $anime->title_zhs }}
<strong>English:</strong> {{ $anime->title_en }}
<strong>日文:</strong> {{ $anime->title_jp }}
<strong>羅馬字:</strong> {{ $anime->title_ro }}
</pre>
        </div>
    </div>

    <div class="comment-list">
        <div class="filter">
            <div class="filter-date">
                <button onclick="myFunction()" class="dropbtn">
                    熱門 &#9660
                </button>
                <div id="myDropdown" class="dropdown-content">
                    <a href="">熱門</a>
                    <a href="">最舊到最新</a>
                    <a href="">最新到最舊</a>
                </div>
            </div>
            <div class="filter-forum">
                <button onclick="myFunction()" class="dropbtn">
                    全部 &#9660
                </button>
                <div id="myDropdown" class="dropdown-content">
                    <a href="">全部</a>
                    <a href="">MyAnimeList</a>
                    <a href="">AniList</a>
                </div>
            </div>
        </div>

        <div class="comment">
            <div class="user-comment">
                <img src="https://i.meee.com.tw/IdhSQKL.jpeg" alt="">
                <div class="user">
                    <h5>User1 - 評分: 9/10</h5>
                    <p>超好看！</p>
                    <div class="user-review">
                        <p style="color:gray">23小時前</p>
                        <button>👍</button>
                        <p>5</p>
                    </div>
                </div>
            </div>
            <div class="comment-forum">
                <h5>-來自 Anilist</h5>
                <img src="https://i.meee.com.tw/pXbmY47.png" alt="">
            </div>
        </div>

        <div class="comment">
            <div class="user-comment">
                <img src="https://i.meee.com.tw/IdhSQKL.jpeg" alt="">
                <div class="user">
                    <h5>User2 - 評分: 🌟🌟🌟🌟🌟</h5>
                    <p>好好笑！雨宮天配音好棒！神番！</p>
                    <div class="user-review">
                        <p style="color:gray">2分鐘前</p>
                        <button>👍</button>
                        <p>500000</p>
                    </div>
                </div>
            </div>
            <div class="comment-forum">
                <h5>-來自MyAnimeList</h5>
                <img src="https://i.meee.com.tw/abjx4TG.png" alt="">
            </div>
        </div>
    </div>
</div>