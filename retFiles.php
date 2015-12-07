<?php

  include("PHPAuth/Config.php");
  include("PHPAuth/Auth.php");

  $dbh = new PDO("mysql:host=localhost;dbname=phpauth", "root", "");
  $groupme = new PDO("mysql:host=localhost;dbname=groupme", "root", "");

  $config = new PHPAuth\Config($dbh);
  $auth   = new PHPAuth\Auth($dbh, $config);

  if (!$auth->isLogged()) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden";

    exit();
  }

  $uid = $auth->getSessionUID( $_COOKIE[$config->cookie_name] );
  $data = $auth->getUser( $uid );
  $name = $data['email'];

  echo "<table>";
  echo "<tr><th>Files</th></tr>";

  $sql = "SELECT * FROM files WHERE gid = ".$_POST['gid'];
  
  foreach ($groupme->query($sql) as $row) {
    echo "<tr><td>".$row['name']."</td></tr>";
  }
?>