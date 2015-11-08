<?php
include dirname(__FILE__) . "/notorm/NotORM.php";
$connection = new PDO("mysql:host=localhost;dbname=dbname;port=3306", "dbuser", "dbpass");
$software = new NotORM($connection);
$sonnets = $software->sonnets();
header('Content-Type: application/rss+xml; charset=utf-8');
print '<?xml version="1.0" encoding="utf-8" ?>';
?>
<rss version="2.0" xml:base="http://hafez.apps.rastasoft.ir" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <title>حافظ</title>
    <link>http://hafez.apps.rastasoft.ir/</link>
    <description>فال حافظ</description>
    <language>fa</language>
    <?php foreach ($sonnets as $sonnet): ?>
      <?php $verse = $software->verses("sid", $sonnet['sid'])->and("number", 1); ?>
      <item>
        <title><?php print $verse[0]['hemistich_first'] . ' - ' . $verse[0]['hemistich_second']; ?></title>
        <link><?php print "http://hafez.apps.rastasoft.ir/index.php?sid={$sonnet['sid']}"; ?></link>
        <description><?php print $sonnet['phrase']; ?></description>
      </item>
    <?php endforeach; ?>
  </channel>
</rss>