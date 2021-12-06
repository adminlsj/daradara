<meta property="og:url" content="{{ route('comic.showCover', ['comic' => $comic->id]) }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="第{{ $page }}頁 - {{ $comic->title_o_before }} {{ $comic->title_o_pretty }} {{ $comic->title_o_after }}" />
<meta property="og:description" content="第{{ $page }}頁 - {{ $comic->title_o_before }} {{ $comic->title_o_pretty }} {{ $comic->title_o_after }}" />
<meta property="og:image" content="https://t.nhentai.net/galleries/{{ $comic->galleries_id }}/cover.{{ $comic->extension }}" />

<title>第{{ $page }}頁&nbsp;-&nbsp;{{ $comic->title_o_before }} {{ $comic->title_o_pretty }} {{ $comic->title_o_after }}&nbsp;-&nbsp;H動漫/裏番/漫畫/線上看&nbsp;-&nbsp;Hanime1.me</title>
<meta name="title" content="第{{ $page }}頁 - {{ $comic->title_o_before }} {{ $comic->title_o_pretty }} {{ $comic->title_o_after }} - H動漫/裏番/漫畫/線上看 - Hanime1.me">
<meta name="description" content="第{{ $page }}頁 - {{ $comic->title_o_before }} {{ $comic->title_o_pretty }} {{ $comic->title_o_after }}">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "VideoObject",
  "name": "第{{ $page }}頁 - {{ $comic->title_o_before }} {{ $comic->title_o_pretty }} {{ $comic->title_o_after }}",
  "description": "第{{ $page }}頁 - {{ $comic->title_o_before }} {{ $comic->title_o_pretty }} {{ $comic->title_o_after }}",
  "thumbnailUrl": [
    "https://t.nhentai.net/galleries/{{ $comic->galleries_id }}/cover.{{ $comic->extension }}"
   ],
  "uploadDate": "{{ \Carbon\Carbon::parse($comic->created_at)->format('Y-m-d\Th:i:s').'+00:00' }}",
  "author": {
    "@type": "Person",
    "name": "Hanime1.me"
  },
  "contentUrl": "{{ route('comic.showCover', ['comic' => $comic->id]) }}",
  "interactionStatistic": {
    "@type": "InteractionCounter",
    "interactionType": { "@type": "http://schema.org/WatchAction" },
    "userInteractionCount": {{ $comic->views }}
  }
}
</script>