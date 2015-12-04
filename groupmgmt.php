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
  $inUse = 0;

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
    $query = $groupme->query($sql);

    if ($query != FALSE) {
      header('Location: home.php');
    }
  }

  if ($_POST['origin'] == "create") {
    $sql = "SELECT * FROM groups";

    foreach ( $groupme->query($sql) as $grouplist ) {
      $input = strtolower( $_POST['groupName'] );
      $check = strtolower( $grouplist['name'] );

      if ( strcmp($input, $check) == 0 ) {
        $inUse = 1;
      }
    }

    if ( $inUse == 0 ) {
      $sql = "INSERT INTO `groups` (`name`, `creator`) VALUES ('".$_POST['groupName']."', '".$name."')";
      $query = $groupme->query($sql);

      if ($query != FALSE) {

        $sql = "SELECT gid FROM groups WHERE name = '".$_POST['groupName']."'";
        foreach ( $groupme->query($sql) as $row );

        $gid = $row['gid'];

        $sql = "INSERT INTO `users`( `name`, `gid`, `groupname` ) VALUES ('".$name."', ".$gid.", '".$_POST['groupName']."')";
        $query = $groupme->query($sql);

        if ($query != FALSE) {
          header('Location: home.php');
        }
      }
    }
  }

  if ($_POST['origin'] == "leave") {
    $sql = "DELETE FROM users WHERE name = '".$name."' AND gid = ".$_POST['groupList'];
    $query = $groupme->query($sql);

    if ($query != FALSE) {
      header('Location: home.php');
    }
  }

  if ($_POST['origin'] == "alert") {
    if (isset($_POST['fb'])) {
      $sql = "UPDATE notifications SET `facebook`='".$_POST['fbinput']."' WHERE `user`='".$name."'";
      $query = $groupme->query($sql);

      if ($query != FALSE) {
        header('Location: home.php');
      }
    }

    if (isset($_POST['twitter'])) {  
      $sql = "UPDATE notifications SET `twitter`='".$_POST['twitterinput']."' WHERE `user`='".$name."'";
      $query = $groupme->query($sql);

      if ($query != FALSE) {
        header('Location: home.php');
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Create Group</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
  </head>
  <body>
    <!-- page content -->

    <h1>Sorry, there was an error with your request.</h1>
    <button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" onclick="window.location.href='home.php'"><span class="ui-button-text">Home</span></button>

  </body>
</html>