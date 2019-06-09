<!DOCTYPE html>
<html lang="en-us">
<head>
<title> Project Sign In Page Week06 </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta charset="UTF-8"/>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
  <h2>Please Sign In</h2>

  <?php
    // for user feedback from getUser
    if(isset($_GET['message'])){
      echo "<h4>$_GET[message]</h4>";
    } 
  ?>

    <form method="POST" action="getUser.php">
      <strong>Username</strong><br>
      <input type="text" name="user_name" placeholder="Username"><br><br>
      <strong>Password</strong><br>
      <input type="password" name="user_password" placeholder="Password"><br><br>
      <input type="submit" name="Submit" value="Submit">
    </form><br><br>

Or <a href="signUp.html">Sign up</a> for a new account.<br><br>
  <a href="welcome.php">Welcome Page</a><br/>
</body>
</html>