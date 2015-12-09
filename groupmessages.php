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

  //get names for sending to other group members
  $inboxQuery = "SELECT * FROM messages WHERE user = '".$name."'";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>GroupMe Message Center</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/userhome.css">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#inbox').hide();
        $('#messaging').hide();
        $('#messageGroupSelect').hide();
        $('#groupMembers').hide();
      });

      function showInbox() {
        if ($('#inbox').is(':visible')) 
          $('#inbox').hide();
        else
          $('#inbox').show();
      }

      function showMessaging() {
        if ($('#messaging').is(':visible')) {
          $('#messaging').hide();
          $('#messageGroupSelect').hide();
        }
        else {
          $('#messaging').show();
          $('#messageGroupSelect').show();
        }
      }

      function showUsers(grp) {

        if (grp == "0") {
          document.getElementById("groupMembers").innerHTML = "";
          $('#groupMembers').hide();
          return;
        } else {

          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }

          xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("groupMembers").innerHTML = xmlhttp.responseText;
            }
          };

          xmlhttp.open("POST","retMembers.php",true);
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send("gid="+grp);

          $('#groupMembers').show();
        }
      }
    </script>
  </head>
  <body>

    <div id="navigation">
      <button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" onclick="window.location.href='home.php'"><span class="ui-button-text">Home</span></button> <button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" onclick="showInbox()"><span class="ui-button-text">Inbox</span></button> <button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" onclick="showMessaging()"><span class="ui-button-text">Messaging</span></button>
    </div>

    <br>

    <div id="inbox">
       <?php foreach( $groupme->query($inboxQuery) as $row ) { echo 'Group: '.$row['groupname'].'<br>From: '.$row['fromuser'].'<br>Message: '.$row['message'].'<br><br>'; } ?>
    </div>

    <br>

    <div id="messaging">
      <div id="messageGroupSelect">
        <select name="groupList" onchange="showUsers(this.value)" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
          <option value="0">Select a group...</option>
          <?php foreach ( $groupme->query("SELECT gid, groupname FROM users WHERE name = '".$name."'") as $row ) { echo '<option value="'.$row['gid'].'">'.$row['groupname'].'</option>'; } ?>
        </select>
      </div>

      <div id="groupMembers">
      </div>
    </div>

  </body>
</html>