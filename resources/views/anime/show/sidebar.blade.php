<div class="sidebar">
    <div class="ranking">
        <a style=""><img style="width: 13px; margin-top: 2px; float: left;" src="https://images2.imgbox.com/e6/6b/Ni0QCdRt_o.png">{{ $anime->started_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $anime->started_at)->year : '????' }}年 季度排名 #1</a>
    </div>
    <div class="ranking">
        <a href=""><img style="width: 13px; margin-top: 3px; float: left;" src="https://images2.imgbox.com/79/ba/VaBUdsqz_o.png">{{ $anime->started_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $anime->started_at)->year : '????' }}年 動畫總排名 #31</a>
    </div>
    <div class="data">
        <div class="data-set">
            <div class="type">動畫類別</div>
            <div class="format">{{ $anime->category }}</div>
        </div>
        <div class="data-set">
            <div class="type">集數</div>
            <div class="format">{{ $anime->episodes_count }}</div>
        </div>
        <div class="data-set">
            <div class="type">集數總長</div>
            <div class="format">{{ $anime->episodes_length }}分鐘</div>
        </div>
        <div class="data-set">
            <div class="type">播放狀態</div>
            <div class="format">{{ $anime->airing_status }}</div>
        </div>
        <div class="data-set">
            <div class="type">首播日期</div>
            <div class="format">{{ $anime->started_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $anime->started_at)->format('Y年m月d日') : 'Not available yet' }}</div>
        </div>
        <div class="data-set">
            <div class="type">完播日期</div>
            <div class="format">{{ $anime->ended_at ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $anime->ended_at)->format('Y年m月d日') : 'Not available yet' }}</div>
        </div>
        <div class="data-set">
            <div class="type">季番</div>
            <div class="format">{{ $anime->season ? $anime->season : 'Not available yet' }}</div>
        </div>
        <div class="data-set">
            <div class="type">更新時間</div>
            <div class="format">{{ $anime->updated_at }}</div>
        </div>
        <div class="data-set">
            <div class="type">動畫社</div>
            @foreach ($anime->studios as $studio)
                <div class="format"><a href="{{ route('company.show', ['company' => $studio, 'title'=> $studio->getName($chinese)]) }}">{{ $studio->getName($chinese) == 'add some' ? 'Unknown' : $studio->getName($chinese) }}</a></div>
            @endforeach
        </div>
        <div class="data-set">
            <div class="type">類別</div>
            @foreach ($anime->genres as $genre)
                <div class="format"> <a href="">{{ $genre }}</a> </div>
            @endforeach
        </div>
        <div class="data-set">
            <div class="type">簡譯</div>
            <div class="format"> {{ $anime->title_zhs }} </div>
        </div>
        <div class="data-set">
            <div class="type">日譯</div>
            <div class="format"> {{ $anime->title_jp }} </div>
        </div>
        <div class="data-set">
            <div class="type">英譯</div>
            <div class="format"> {{ $anime->title_en ? $anime->title_en : $anime->title_ro }} </div>
        </div>
        <div class="data-set">
            <div class="type">羅馬譯</div>
            <div class="format"> {{ $anime->title_ro }} </div>
        </div>
    </div>
    <div class="tags">
        <h3>標籤</h3>
        <div class="tag">
            <a href="">搞笑</a>
            <div class="rank">97%</div>
        </div>
        <div class="tag">
            <a href="">戀愛</a>
            <div class="rank">95%</div>
        </div>
        <div class="tag">
            <a href="">日常</a>
            <div class="rank">93%</div>
        </div>
        <div class="tag">
            <a href="">異世界</a>
            <div class="rank">90%</div>
        </div>
    </div>
</div>