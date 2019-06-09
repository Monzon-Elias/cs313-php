<?php
include 'project_functions.php';
//GET USER

// Check if input is empty and set variables
if(isset($_POST['user_password'])){
  $user_password = $_POST['user_password'];
}
if(isset($_POST['user_name'])){
  $user_name = pg_escape_string($_POST['user_name']);
}
$db = conexion();
// prepare and make statement
$stmt = $db->prepare("SELECT * FROM app_user WHERE user_name = '$user_name'");
$stmt->execute();

// get results
if($result = $stmt->fetchAll(PDO::FETCH_ASSOC)){
  foreach ($result as $row) { 
    $userid = $row[userid];
    $hash_pswd = $row[user_password];
    $user_name = $row[user_name];
  }

  // if matches redirect
  if(password_verify($user_password, $hash_pswd)){
    header('Location: welcome.php?userid=' . $userid);
    // password was correct, put the user on the session
    session_start();
	$_SESSION['user_name'] = $user_name;
	header('Location: welcome.php');
	die();
  // invalid password
  else {
    header('Location: signIn.php?message=Invalid Password');
    die();
  }
}
// invalid user
else{
  header('Location: signIn.php?message=User Not Found');
  die();
    }
?>