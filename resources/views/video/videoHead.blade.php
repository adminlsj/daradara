<meta property="og:url" content="{{ route('video.watch') }}?v={{ $video->id }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $video->translations['JP'] }}" />
<meta property="og:description" content="{{ $video->caption }}" />
<meta property="og:image" content="https://i.imgur.com/{{ $video->imgur }}h.png" />

<title>{{ $video->translations['JP'] }}&nbsp;-&nbsp;H動漫線上看&nbsp;-&nbsp;Hanime1.me</title>
<meta name="title" content="{{ $video->translations['JP'] }} - H動漫線上看 - Hanime1.me">
<meta name="description" content="{{ $video->caption }}">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "VideoObject",
  "name": "{{ $video->translations['JP'] }}",
  "description": "{{ $video->caption == '' ? $video->translations['JP'] : $video->caption}}",
  "thumbnailUrl": [
    "https://i.imgur.com/{{ $video->imgur }}l.png"
   ],
  "uploadDate": "{{ \Carbon\Carbon::parse($video->created_at)->format('Y-m-d\Th:i:s').'+00:00' }}",
  "author": {
    "@type": "Person",
    "name": "{{ $video->user->name }}"
  },
  "contentUrl": "{!! $video->sd !!}",
  "interactionStatistic": {
    "@type": "InteractionCounter",
    "interactionType": { "@type": "http://schema.org/WatchAction" },
    "userInteractionCount": {{ $video->views }}
  }
}
</script>