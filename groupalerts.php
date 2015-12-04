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
    <title>Group Alerts</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.watermark.js"></script>
    <script>
    	$(document).ready(function () {
    		$('#fbtext').hide();
    		$('#twittertext').hide();
    		$('#smstext').hide();

    		$( '#twitterinput' ).watermark( '@coolcat87' );
    		$( '#smsinput' ).watermark( '555-867-5309' );

     		$('#fb').click(function () {
         		var $this = $(this);
         		if ($this.is(':checked')) {
             		$('#fbtext').show();
         		} else {
             		$('#fbtext').hide();
         		}
     		});

     		$('#twitter').click(function () {
         		var $this = $(this);
         		if ($this.is(':checked')) {
             		$('#twittertext').show();
         		} else {
             		$('#twittertext').hide();
         		}
     		});

     		$('#sms').click(function () {
         		var $this = $(this);
         		if ($this.is(':checked')) {
             		$('#smstext').show();
         		} else {
             		$('#smstext').hide();
         		}
     		});
 		});
 	</script>
  </head>
  <body>
    <!-- page content -->

    <p>How would you like to recieve updates?</p>
    <form action="groupmgmt.php" method="POST">
    	<input type="checkbox" id="fb" name="fb">Facebook messaging

    	<div id="fbtext">
    		Facebook e-mail address: <input type="text" id="fbinput" name="fbinput">
    	</div>
    	</br>

    	<input type="checkbox" id="twitter" name="twitter">Twitter DM

    	<div id="twittertext">
    		Twitter handle: <input type="text" id="twitterinput" name="twitterinput">
    	</div>
    	</br>

    	<input type="checkbox" id="sms" name="sms">Text message (SMS)

    	<div id="smstext">
    		Phone number: <input type="text" id="smsinput" name="smsinput">
    	</div>
    	</br>

    	<input type="hidden" name="origin" value="alert">
    	</br>

    	<input type="submit" value="Set Alert Preferences" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover ui-state-active"role="button"><span class="ui-button-text"></span>
    </form>

    <button id="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" onclick="window.location.href='home.php'"><span class="ui-button-text">Home</span></button>

  </body>
</html>