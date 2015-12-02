<?php

  include("PHPAuth/Config.php");
  include("PHPAuth/Auth.php");

  $dbh = new PDO("mysql:host=localhost;dbname=phpauth", "root", "");
  $groupme = new PDO("mysql:host=localhost;dbname=groupme", "root", "");

  $config = new PHPAuth\Config($dbh);
  $auth   = new PHPAuth\Auth($dbh, $config);

  $uid = $auth->getSessionUID( $_COOKIE[$config->cookie_name] );
  $data = $auth->getUser( $uid );

  $name = $data['email'];

  if (!$auth->isLogged()) {
    header('HTTP/1.0 403 Forbidden');
    echo "Forbidden";

    exit();
  }

  if ($_POST['origin'] == "join") {
    $sql = "SELECT name FROM groups WHERE gid = ".$_POST['groupList'];
    foreach ( $groupme->query($sql) as $row );

    $groupname = $row['name'];

    $sql = "INSERT INTO `users`( `name`, `gid`, `groupname` ) VALUES ('".$name."', ".$_POST['groupList'].", '".$groupname."')";
    echo $sql;
    $query = $groupme->query($sql);

    if ($query != FALSE) {
      header('Location: home.php');
    }
  }

  if ($_POST['origin'] == "leave") {
    $sql = "DELETE FROM users WHERE name = '".$name."' AND gid = ".$_POST['groupList'];
    echo $sql;
    $query = $groupme->query($sql);

    if ($query != FALSE) {
      header('Location: home.php');
    }
  }
?>