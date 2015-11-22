<?php

include("PHPAuth/languages/en_GB.php");
include("PHPAuth/Config.php");
include("PHPAuth/Auth.php");

$dbh = new PDO( "mysql:host=localhost;dbname=phpauth", "root", "" );

$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config);

$return = $auth->register( $_POST['email'], $_POST['password'], $_POST['confirmpass'] );
if ( $return['error'] == TRUE ) {
  echo "Sorry, there was a problem with registration.";
}
else {
  echo $return['message'];
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign Up for GroupMe</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
  </head>
  <body>
    <!-- page content -->
  </body>
</html>