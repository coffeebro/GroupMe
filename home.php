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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>GroupMe Home</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/userhome.css">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
  </head>
  <body>
    <!-- page content -->
    <div id="topRowHome">
      <img src="images/join_group.png" class="ui-button" title="Join Group" height="100" width="100" onclick="window.location.href='joingroup.php'">
      &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
      <img src="images/create_group.png" class="ui-button" title="Create Group" height="100" width="100" onclick="window.location.href='creategroup.php'">
      &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
      <img src="images/leave_group.png" class="ui-button" title="Leave Group" height="100" width="100" onclick="window.location.href='leavegroup.php'">
    </div>

    <div class="separator">
    </div>

    <div id="bottomRowHome">
      <img src="images/group_alert.jpg" class="ui-button" title="Group Alerts" height="100" width="100" onclick="window.location.href='groupalerts.php'">
      &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
      <img src="images/group_files.jpg" class="ui-button" title="Group Files" height="100" width="100" onclick="window.location.href='groupfiles.php'">
      &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
      <img src="images/group_messages.jpg" class="ui-button" title="Group Messages" height="100" width="100" onclick="window.location.href='groupmessages.php'">
    </div>

    <div class="separator">
    </div>

    <div>
      <button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" onclick="window.location.href='logout.php'"><span class="ui-button-text">Log Out</span></button>
        <select name="groupList" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
          <option value="0">My Groups...</option>
          <?php foreach ( $groupme->query("SELECT gid, groupname FROM users WHERE name = '".$name."'") as $row ) { echo '<option value="'.$row['gid'].'">'.$row['groupname'].'</option>'; } ?>
        </select>
    </div>
  </body>
</html>