<?php require "project_functions.php";?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="p1style.css">
        <link href="https://fonts.googleapis.com/css?family=Handlee|Titillium+Web&display=swap" rel="stylesheet">
        <title>Add New Assignment</title>
        <style> ::placeholder {color: aliceblue; opacity: .8; font-size: 1em;} </style>
    </head>
    <?php include 'appTitle.php';?>
    <body>
        <h1>Add a New Assignment</h1>
        <p><?php addNewAssig();?></p><br><br>
        <a href="assigList.php">Back to Assignment List Page</a>
    </body>
</html>