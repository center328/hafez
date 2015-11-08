<?php

include dirname(__FILE__) . "/config.php";
include dirname(__FILE__) . "/notorm/NotORM.php";
$connection = new PDO("mysql:host={$config['host']};dbname={$config['name']};port={$config['port']}", $config['user'], $config['pass']);

$software = new NotORM($connection);

$sid = (int) $_GET['sid'];
$url = "http://www.1doost.com/hafez/phrase/$sid.htm";
$html = file_get_contents($url);
libxml_use_internal_errors(true); // Yeah if you are so worried about using @ with warnings
$doc = new DomDocument();
$doc->loadHTML($html);
$xpath = new DOMXPath($doc);
$verses = $xpath->query('//*/div[@class="hfzpsBoxHolder"]/div');
$number = 1;
foreach ($verses as $verse) {
  $parts = $verse->getElementsByTagName('div');
  $hemistich_first = $parts->item(0)->nodeValue;
  $hemistich_second = $parts->item(1)->nodeValue;
  $software->verses()->insert(array("sid" => $sid, "number" => $number++, "hemistich_first" => $hemistich_first, "hemistich_second" => $hemistich_second));
}
$phrase = $xpath->query('//*/div[@class="hzPoeamPhraseHolder"]/p')->item(0)->nodeValue;
$software->sonnets()->insert_update(array("sid" => $sid), array("phrase" => $phrase));

$sound = file_get_contents("http://hafez.pichak.net/mp3/$sid.mp3");
file_put_contents("sounds/$sid.mp3", $sound);
$sid3 = strlen($sid) == 3 ? $sid : (strlen($sid) == 2 ? "0$sid" : "00$sid");
$image = file_get_contents("http://www.1doost.com/Files/Hafez/png/$sid3.png");
file_put_contents("images/$sid.png", $image);
print 'done';
