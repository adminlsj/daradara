<meta property="og:url" content="{{ route('video.watch') }}?v={{ $current->id }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $current->title }}" />
<meta property="og:description" content="{{ $current->caption }}" />
<meta property="og:image" content="https://i.imgur.com/{{ $current->imgur }}h.png" />

<title>{{ $current->title }} - 娛見日本 LaughSeeJapan</title>
<meta name="title" content="{{ $current->title }} - 娛見日本 LaughSeeJapan">
<meta name="description" content="{{ $current->caption }}">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "VideoObject",
  "name": "{{ $current->title }}",
  "description": "{{ $current->caption == '' ? $current->title : $current->caption}}",
  "thumbnailUrl": [
    "https://i.imgur.com/{{ $current->imgur }}l.png"
   ],
  "uploadDate": "{{ \Carbon\Carbon::parse($current->created_at)->format('Y-m-d\Th:i:s').'+00:00' }}",
  "duration": "{{ $current->durationData() }}",
  @if ($current->outsource)
      "embedUrl": "{!! $current->source() !!}",
  @else
      "contentUrl": "{!! $current->source() !!}",
  @endif
  "interactionStatistic": {
    "@type": "InteractionCounter",
    "interactionType": { "@type": "http://schema.org/WatchAction" },
    "userInteractionCount": {{ $current->views }}
  }
}
</script>