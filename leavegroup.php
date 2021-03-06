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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Leave Group</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
  </head>
  <body>
    <!-- page content -->

    <form action="groupmgmt.php" method="POST">

      <div id="list">
        <select name="groupList" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
          <?php foreach ( $groupme->query("SELECT gid, groupname FROM users WHERE name = '".$name."'") as $row ) { echo '<option value="'.$row['gid'].'">'.$row['groupname'].'</option>'; } ?>
        </select>
      </div>
      <input type="hidden" name="origin" value="leave">
      <input type="submit" value="Leave Group" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover ui-state-active"role="button"><span class="ui-button-text"></span>
    </form>
      <div id="selection">
        <button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" onclick="window.location.href='home.php'"><span class="ui-button-text">Home</span></button>
      </div>

     

  </body>
</html>