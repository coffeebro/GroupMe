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

  $sql = "SELECT * FROM users WHERE gid = ".$_POST['gid'];
  $i = 1;
  echo '<br>';
  
  foreach ($groupme->query($sql) as $row) {
    echo "<input type='checkbox' name='member".$i."'>".$row['name']."<br>";
    $i++;
  }

  echo '<input type="checkbox" name="all">All<br>';

  //we want the number of potential options
  //subtract 1 from i to get total number of users in a group
  $i--;

  //give number of potential users as hidden value
  echo '<input type="hidden" name="numMembers" value="'.$i.'">';
?>