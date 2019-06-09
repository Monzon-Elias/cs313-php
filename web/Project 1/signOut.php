<?php
// SIGN OUT
function signOut(){
session_start();
unset($_SESSION['user_name']);
header('Location: signIn.php');
die();
}
signOut();
?>