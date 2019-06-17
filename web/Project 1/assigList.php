<?php require "project_functions.php";
$searchBy = $_GET['courseName'];?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="p1style.css">
        <link href="https://fonts.googleapis.com/css?family=Handlee|Titillium+Web&display=swap" rel="stylesheet">
        <title>Project 1 - Week 5</title>
        <style> ::placeholder {color: aliceblue; opacity: .8; font-size: 1em;} </style>
    </head>
    <?php include 'appTitle.php';?>

    <body>
        <h1>Assignments List</h1>
        <form method="GET">
            <input type="text" name="courseName" placeholder="e.g.: CIT 230">
            <button type="submit">Submit</button>
             <a href="assigList.php">Show all</a>
        </form>
        <div class="assigTable"><?php isset($searchBy) ? searchByAssigName() : getAllAssignments();?></div><br><br>
        <a href="addNewAssig.php">Add New Assignment Page</a>
    </body>
</html>
