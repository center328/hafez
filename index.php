<?php
$sid = isset($_GET['sid']) ? (int) $_GET['sid'] : 0;
if ($sid <= 0 || $sid > 495) {
  $sid = rand(1, 495);
}
$next = ($sid + 1) % 495;
$prev = ($prev = $sid - 1) ? $prev : 495;
include dirname(__FILE__) . "/notorm/NotORM.php";
$connection = new PDO("mysql:host=localhost;dbname=dbname;port=3306", "dbuser", "dbpass");
$software = new NotORM($connection);
$sonnet = $software->sonnets("sid", $sid);
$verses = $software->verses("sid", $sid)->order("number");
?>
<html>
  <head>
    <title>
      فال حافظ
      |
      <?php print $verses[0]['hemistich_first'] ?>
    </title>
    <meta name="description" content="<?php print $sonnet[0]['phrase']; ?>"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="publisher" href="https://plus.google.com/100862670780242731884"/>
    <link rel="alternate" type="application/rss+xml" title="RSS" href="http://hafez.apps.rastasoft.ir/rss.php" />
    <link rel="index" title="Hafez" href="http://hafez.apps.rastasoft.ir/list.php" />
    <link rel="alternate" href="http://hafez.apps.rastasoft.ir" hreflang="fa-ir" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" >
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="btn-group pull-left">
          <a class="btn btn-sm btn-primary" href="index.php?sid=<?php print $next; ?>"><i class="glyphicon glyphicon-chevron-left"></i></a>
          <a class="btn btn-sm btn-info" href="index.php?sid=<?php print $sid; ?>"><?php print $sid; ?></a>
          <a class="btn btn-sm btn-primary" href="index.php?sid=<?php print $prev; ?>"><i class="glyphicon glyphicon-chevron-right"></i></a>
          <a target="_blank" class="btn btn-sm btn-primary" href="images/<?php print $sid; ?>.png"><i class="glyphicon glyphicon-picture"></i></a>
          <a target="_blank" class="btn btn-sm btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=<?php print urlencode("http://hafez.apps.rastasoft.ir/index.php?sid=$sid"); ?>"><i class="glyphicon glyphicon-share-alt"></i></a>
        </div>
        <a class="btn btn-sm btn-success new-sonnet" href="index.php?time=<?php print time(); ?>"><i class="glyphicon glyphicon-refresh pull-right"></i></a>
      </div>
    </nav>

    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="sonnet">
        <?php foreach ($verses as $verse): ?>
          <div class="hemistich">
            <span class="first"><?php print $verse['hemistich_first']; ?></span>
            <span class="second"><?php print $verse['hemistich_second']; ?></span>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="well well-lg">
        <?php print $sonnet[0]['phrase']; ?>
      </div><!-- /container -->
      <a class="btn btn-lg btn-danger sonnets-list" style="width: 100%;" href="list.php">
        بازگشت به لیست غزلیات حافظ
      </a>
    </div>
    <footer class="footer">
      <div class="container">
        <audio src="sounds/<?php print $sid; ?>.mp3" preload="auto"></audio>
      </div>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="assets/audiojs/audiojs/audio.min.js"></script>
    <script>
      audiojs.events.ready(function () {
        audiojs.createAll();
      });
    </script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <!-- Start Alexa Certify Javascript -->
    <script type="text/javascript">
        _atrk_opts = {atrk_acct: "f6kRj1a8wt00w0", domain: "rastasoft.ir", dynamic: true};
        (function () {
          var as = document.createElement('script');
          as.type = 'text/javascript';
          as.async = true;
          as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js";
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(as, s);
        })();
    </script>
    <noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=f6kRj1a8wt00w0" style="display:none" height="1" width="1" alt="" /></noscript>
    <!-- End Alexa Certify Javascript -->
  </body>
</html>
