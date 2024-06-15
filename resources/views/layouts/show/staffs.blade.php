<div id="staffs" class="tabcontent">
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

    <div class="staff-list">
        <div class="staff">
            <a href=""><img src="https://i.meee.com.tw/88xIE41.png" alt=""></a>
            <a href="" class="name">曉夏目</a>
            <p>原作</p>
        </div>

        <div class="staff">
            <a href=""><img src="https://i.meee.com.tw/r8n4MdU.png" alt=""></a>
            <a href="" class="name">金崎貴臣</a>
            <p>導演</p>
        </div>

        <div class="staff">
            <a href=""><img src="https://i.meee.com.tw/zt1Hgvd.png" alt=""></a>
            <a href="" class="name">三嶋黑音</a>
            <p>人物原案</p>
        </div>
    </div>

</div>