<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Welcome to GroupMe!</title>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
  </head>
  <body>

    <!--Sign Up Form-->
    <form action="signup.php" method="POST">
      Email: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <input type="text" name="email">
      <br>
      Password: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <input type="password" name="password">
      <br>
      Confirm password: <input type="password" name="confirmpass">
      <br>
      <input type="submit" value="Sign Up" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover ui-state-active"role="button"><span class="ui-button-text"></span>
    </form>

    <br>
    <br>
    <br>

    <!--Log In Form-->
    <form action="login.php" method="POST">
      Username: <input type="text" name="username">
      <br>
      Password: &nbsp<input type="password" name="password">
      <br>
      <input type="submit" value="Log In" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover ui-state-active"role="button"><span class="ui-button-text"></span>
    </form>
    
  </body>
</html>