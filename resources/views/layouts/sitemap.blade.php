<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

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
</url>

<!-- Search -->
<url>
  <loc>https://www.laughseejapan.com/search?query=%E9%83%A1%E5%8F%B8</loc>
  <lastmod>{{$time}}</lastmod>
  <priority>0.80</priority>
</url>

<!-- Watches -->
@foreach ($watches as $watch)
  <url>
    <loc>https://www.laughseejapan.com/{{$watch->genre}}/{{$watch->titleToURL()}}</loc>
    <lastmod>{{$time}}</lastmod>
    <priority>0.90</priority>
  </url>
@endforeach

<!-- Videos -->
@foreach ($videos as $video)
  <url>
    <loc>https://www.laughseejapan.com/watch?v={{$video->id}}</loc>
    <lastmod>{{$time}}</lastmod>
    <priority>0.90</priority>
  </url>
@endforeach

</urlset>