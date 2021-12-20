<meta property="og:url" content="{{ route('video.watch') }}?v={{ $video->id }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $video->translations['JP'] }}[中文字幕]" />
<meta property="og:description" content="{{ $video->title }} {{ $video->caption }}" />
<meta property="og:image" content="https://i.imgur.com/{{ $video->imgur }}h.png" />

<title>{{ $video->translations['JP'] }}&nbsp;-&nbsp;H動漫/裏番/線上看&nbsp;-&nbsp;Hanime1.me</title>
<meta name="title" content="{{ $video->translations['JP'] }} - H動漫/裏番/線上看 - Hanime1.me">
<meta name="description" content="{{ $video->title }} {{ $video->caption }}">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "VideoObject",
  "name": "{{ $video->translations['JP'] }}",
  "description": "{{ $video->title }} {{ $video->caption }}",
  "thumbnailUrl": [
    "https://i.imgur.com/{{ $video->imgur }}l.png"
   ],
  "uploadDate": "{{ \Carbon\Carbon::parse($video->uploaded_at)->format('Y-m-d\Th:i:s').'+00:00' }}",
  "author": {
    "@type": "Person",
    "name": "Hanime1.me"
  },
  "contentUrl": "{!! $video->sd !!}",
  "interactionStatistic": {
    "@type": "InteractionCounter",
    "interactionType": { "@type": "http://schema.org/WatchAction" },
    "userInteractionCount": {{ $video->views }}
  }
}
</script>