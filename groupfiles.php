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
    <title>Group Files</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#upload').hide();
        $('#separator').hide();
      });

      function showFiles(grp) {

        if (grp == "0") {
          document.getElementById("files").innerHTML = "";
          $('#upload').hide();
          $('#separator').hide();
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
                document.getElementById("files").innerHTML = xmlhttp.responseText;
            }
          };

          xmlhttp.open("POST","retFiles.php",true);
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send("gid="+grp);

          $('#upload').show();
          $('#separator').show();
        }
      }
    </script>
  </head>
  <body>
    <!-- page content -->
    <div id="groupSelect">
      <select name="groupList" id="groupList" onchange="showFiles(this.value)" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
          <option value="0">My Groups...</option>
          <?php foreach ( $groupme->query("SELECT gid, groupname FROM users WHERE name = '".$name."'") as $row ) { echo '<option value="'.$row['gid'].'">'.$row['groupname'].'</option>'; } ?>
      </select>
    </div>

    <div id="separator">
      <br>
      <br>
    </div>

    <div id="files">
    </div>

    <div id="separator">
      <br>
      <br>
    </div>

    <div id="upload">
      <form action="upload.php" method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
      </form>
    </div>

    <div id="navigation">
        <button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" onclick="window.location.href='home.php'"><span class="ui-button-text">Home</span></button>
    </div>
  </body>
</html>