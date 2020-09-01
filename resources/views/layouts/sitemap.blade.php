<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
      xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
      xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

<!-- Home -->
<url>
  <loc>https://hanime1.me/</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>1.00</priority>
</url>

<!-- Videos -->
@foreach ($videos as $video)
  <url>
    <loc>https://hanime1.me/watch?v={{$video->id}}</loc>
    <lastmod>{{$time}}</lastmod>
    <priority>0.90</priority>
    <video:video>
       <video:thumbnail_loc>https://i.imgur.com/{{ $video->imgur }}.jpg</video:thumbnail_loc>
       <video:title>{{ $video->title }}</video:title>
       <video:description>{{ $video->caption }}</video:description>
       @if ($video->outsource)
         <video:player_loc>{{ $video->sd }}</video:player_loc>
       @else
         <video:content_loc>{{ $video->sd }}</video:content_loc>
       @endif
       <video:view_count>{{ $video->views }}</video:view_count>
       <video:publication_date>{{ \Carbon\Carbon::parse($video->created_at)->format('Y-m-d\Th:i:s').'+00:00' }}</video:publication_date>
       <video:family_friendly>yes</video:family_friendly>
       <video:live>no</video:live>
       @foreach ($video->tags() as $tag)
         <video:tag>{{ $tag }}</video:tag>
       @endforeach
     </video:video>
     <image:image>
       <image:loc>https://i.imgur.com/{{ $video->imgur }}.jpg</image:loc>
       <image:title>{{ $video->title }}</image:title>
       <image:caption>{{ $video->caption }}</image:caption>
     </image:image>
  </url>
@endforeach

</urlset>