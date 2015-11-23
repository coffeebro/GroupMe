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
else {
	echo 'There was a problem logging out..';
}
?>