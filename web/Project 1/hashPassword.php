<?php
//HASH PASSWORD
include 'project_functions.php';
// check if input is valid & set local variable
if(isset($_POST['user_password'])){
  $user_password = pg_escape_string($_POST['user_password']);
}
if(isset($_POST['user_name'])){
  $user_name = pg_escape_string($_POST['user_name']);
}

// hash password
$password_hash = password_hash($user_password, PASSWORD_BCRYPT);

$db = conexion();
// prepare statement
$stmt = $db->prepare('INSERT INTO app_user (user_name, user_password)
VALUES(:user_name, :user_password');

// set parameters
$stmt->bindParam(':user_name', $user_name);
$stmt->bindParam(':user_password', $password_hash);

// execute statement
$stmt->execute();

// redirect user
if($result = $stmt->fetchAll(PDO::FETCH_ASSOC)){
  foreach ($result as $row) { 
    header('Location: welcome.php?userid=' . $row['userid']);
  }
 }
?>