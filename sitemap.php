<?php
include dirname(__FILE__) . "/notorm/NotORM.php";
$connection = new PDO("mysql:host=localhost;dbname=dbname;port=3306", "dbuser", "dbpass");
$software = new NotORM($connection);
$sonnets = $software->sonnets();
header('Content-Type: application/rss+xml; charset=utf-8');
print '<?xml version="1.0" encoding="utf-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url><loc>http://www.rastasoft.ir/list.php</loc><changefreq>yearly</changefreq><priority>1.0</priority></url>
  <url><loc>http://www.rastasoft.ir/index.php</loc><changefreq>daily</changefreq><priority>1.0</priority></url>
  <url><loc>http://www.rastasoft.ir/rss.php</loc><changefreq>yearly</changefreq><priority>1.0</priority></url>
  <?php foreach ($sonnets as $sonnet): ?>
    <?php $verse = $software->verses("sid", $sonnet['sid'])->and("number", 1); ?>
    <url><loc><?php print "http://hafez.apps.rastasoft.ir/index.php?sid={$sonnet['sid']}"; ?></loc><changefreq>yearly</changefreq><priority>0.9</priority></url>
  <?php endforeach; ?>
</urlset>