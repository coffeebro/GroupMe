<?php
include("PHPAuth/languages/en_GB.php");
include("PHPAuth/Config.php");
include("PHPAuth/Auth.php");

$dbh = new PDO( "mysql:host=localhost;dbname=phpauth", "root", "" );

$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config);

$logout = $auth->logout($_COOKIE[$config->cookie_name]);

if ($logout) {
	header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>GroupMe Logout Portal</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
  </head>
  <body>
    <!-- page content -->

    <div>
      <?php
        echo $logout['message'];
        echo '<br>';
        echo '<button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" onclick="window.location.href=\'index.php\'"><span class="ui-button-text">Main Page</span></button>';
      ?>
    </div>

  </body>
</html>