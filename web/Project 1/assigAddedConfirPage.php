<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="p1style.css">
        <link href="https://fonts.googleapis.com/css?family=Handlee|Titillium+Web&display=swap" rel="stylesheet">
	    <title>Assignments Added Confirmation Page</title>
</head>
<?php include 'appTitle.php';?>
<body>

	<h1>ASSIGNMENT <?php echo $_SESSION["assigName"];?> SUCCESSFULLY ADDED!</h1>
	<p><?php echo $_SESSION["newCourse"];?></p><br>
	<a href="assigList.php">Back to Assignment List Page</a><br><br>
	<a href="addNewAssig.php">Add New Assignment Page</a>

</body>
</html>