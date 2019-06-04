<?php require "project_functions.php";
$searchBy = $_GET['courseName'];?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Project 1 - Week 5</title>
    </head>
    
    <body>
        <h1>Assignments List</h1>
        <form method="GET">
            <input type="text" name="courseName" placeholder="type a course, e.g.: CIT 230">
            <button type="submit">Submit</button>
            <button type="submit">Show all</button>
        </form>
        <p><?php isset($searchBy) ? searchByAssigName() : getAllAssignments();?></p>
        <a href="addNewAssig.php">Add New Assignment Page</a>
    </body>
</html>