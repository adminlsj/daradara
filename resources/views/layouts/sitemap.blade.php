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
  <loc>https://www.laughseejapan.com/</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>1.00</priority>
</url>

<!-- Genre -->
<url>
  <loc>https://www.laughseejapan.com/rank</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>0.60</priority>
</url>
<url>
<<<<<<< HEAD
  <loc>https://www.laughseejapan.com/newest</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>0.60</priority>
=======
  <loc>https://www.laughseejapan.com/variety</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.laughseejapan.com/drama</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.laughseejapan.com/anime</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>0.80</priority>
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
</url>

<!-- Search -->
<url>
  <loc>https://www.laughseejapan.com/search?query={{ rawurlencode('郡司') }}</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>0.80</priority>

  <loc>https://www.laughseejapan.com/search?query={{ rawurlencode('郡司桑') }}</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>0.80</priority>
</url>

<!-- Watches -->
@foreach ($watches as $watch)
  <url>
<<<<<<< HEAD
    <loc>https://www.laughseejapan.com/playlist?list={{ $watch->id }}</loc>
    <lastmod>{{$time}}</lastmod>
    <priority>0.90</priority>
    <image:image>
       <image:loc>https://i.imgur.com/{{ $watch->videos()->first()->imgur }}.jpg</image:loc>
       <image:title>{{ $watch->title }}</image:title>
       <image:caption>{{ $watch->description }}</image:caption>
     </image:image>
=======
    <loc>https://www.laughseejapan.com/{{$watch->genre}}/{{ rawurlencode($watch->titleToURL()) }}</loc>
    <lastmod>{{$time}}</lastmod>
    <priority>0.90</priority>
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
  </url>
@endforeach

<!-- Videos -->
@foreach ($videos as $video)
  <url>
    <loc>https://www.laughseejapan.com/watch?v={{$video->id}}</loc>
    <lastmod>{{$time}}</lastmod>
    <priority>0.90</priority>
    <video:video>
<<<<<<< HEAD
       <video:thumbnail_loc>https://i.imgur.com/{{ $video->imgur }}.jpg</video:thumbnail_loc>
       <video:title>{{ $video->title }}</video:title>
       <video:description>{{ $video->caption }}</video:description>
       @if ($video->outsource)
         <video:player_loc>{{ $video->outsource() }}</video:player_loc>
       @else
         <video:content_loc>{{ $video->source() }}</video:content_loc>
       @endif
=======
       <video:thumbnail_loc>https://i.imgur.com/{{ $video->imgur }}l.png</video:thumbnail_loc>
       <video:title>{{ $video->title }}</video:title>
       <video:description>{{ $video->caption }}</video:description>
       @if ($video->outsource)
         <video:player_loc>{{ $video->source() }}</video:player_loc>
       @else
         <video:content_loc>{{ $video->source() }}</video:content_loc>
       @endif
       <video:duration>{{ $video->duration }}</video:duration>
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
       <video:view_count>{{ $video->views }}</video:view_count>
       <video:publication_date>{{ \Carbon\Carbon::parse($video->created_at)->format('Y-m-d\Th:i:s').'+00:00' }}</video:publication_date>
       <video:family_friendly>yes</video:family_friendly>
       <video:live>no</video:live>
       @foreach ($video->tags() as $tag)
         <video:tag>{{ $tag }}</video:tag>
       @endforeach
<<<<<<< HEAD
     </video:video>
     <image:image>
       <image:loc>https://i.imgur.com/{{ $video->imgur }}.jpg</image:loc>
=======
       <video:category>{{ $video->genre }}</video:category>
     </video:video>
     <image:image>
       <image:loc>https://i.imgur.com/{{ $video->imgur }}l.png</image:loc>
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
       <image:title>{{ $video->title }}</image:title>
       <image:caption>{{ $video->caption }}</image:caption>
     </image:image>
  </url>
@endforeach

</urlset>