<?php require "project_functions.php"; 
session_start();?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="p1style.css">
        <link href="https://fonts.googleapis.com/css?family=Handlee|Titillium+Web&display=swap" rel="stylesheet">
        <title>ASSIGNMENT SUCCESSFULLY DELETED></title>
    </head>
    <?php include 'appTitle.php';?>
    <body>
        <h1>ASSIGNMENT SUCCESSFULLY DELETED!</h1>
        <h4><?php deleteAssignment(); echo "You deleted ".$_SESSION["assigName"]." assignment!"; session_unset()?></h4>
        <a href="assigList.php">Back to Assignment List</a><br><br>
	    <a href="addNewAssig.php">Add New Assignment Page</a>
    </body>
</html>