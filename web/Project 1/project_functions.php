<?php
//Function conexion

function conexion(){
try
    {
    $dbUrl = getenv('DATABASE_URL');
    $dbOpts = parse_url($dbUrl);
    $dbHost = $dbOpts["host"];
    $dbPort = $dbOpts["port"];
    $dbUser = $dbOpts["user"];
    $dbPassword = $dbOpts["pass"];
    $dbName = ltrim($dbOpts["path"],'/');
    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch (PDOException $ex)
    {
    echo 'Error!: ' . $ex->getMessage();
    die();
    }
    return $db;
}

//BRING UP ALL ASSIGNMENT DATA

function getAllAssignments(){
$db = conexion();
$stmt = $db->query('SELECT * FROM assignment a, course c WHERE a.courseid = c.courseid');
    
    $thead .= "<th>Course</th>"."<th>Name</th>";

    echo "<table border= 2 style='width:50%'>";
    echo $thead;
    
    while ($row = $stmt->fetch(PDO::FETCH_OBJ))
            {
            $tableRow .= "<tr>".
            "<td>$row->course_name</td>".
            "<td><a href='assigDetails.php?assigId=$row->assigid'>$row->name</a></td>".
            "</tr>";
            }
    echo $tableRow;
    echo "</table>";
    
}

//SHOW EACH ASSIGNMENT DETAILS
function assignmentDetails(){
if (!isset($_GET['assigId']))
{
	die("Error, assignment id not specified...");
}
$assig_id = htmlspecialchars($_GET['assigId']);
$db = conexion();
$stmt = $db->query("SELECT * FROM assignment a, course c WHERE a.courseid = c.courseid AND assigid = '$assig_id'");
while ($row = $stmt->fetch(PDO::FETCH_OBJ))
    { 
    echo "<h2>Name: $row->name <br> Course: $row->course_name</h2>";
    
	$details .= "<h2>"."<li>Week: $row->week</li>"."<li>Due-Date: $row->due_date</li>"."<li>It's done?: $row->done</li>"."<li>It's alive?: $row->alive</li>"."<li>Points: $row->points</li>"."<li>Description: $row->description</li>"."<li>Personal Notes: $row->personal_notes</li>"."<li>Instructor Agreement: $row->instructor_agreement</li>"."</h2>";
    }
        
    echo $details;
}

//SEARCH BY ASSIGNMENT
function searchByAssigName(){
$db = conexion();
$searchBy = htmlspecialchars(strtoupper($_GET['courseName']));
$stmt = $db->query("SELECT * FROM assignment a, course c WHERE a.courseid = c.courseid AND c.course_name LIKE '%$searchBy%'");
    
    $thead .= "<th>Course</th>"."<th>Name</th>";

    echo "<table border= 2 style='width:50%'>";
    echo $thead;
    
    while ($row = $stmt->fetch(PDO::FETCH_OBJ))
            {
            $tableRow .= "<tr>".
            "<td>$row->course_name</td>".
            "<td><a href='assigDetails.php?assigId=$row->assigid'>$row->name</a></td>".
            "</tr>";
            }
    echo $tableRow;
    echo "</table>";
    
if(!$tableRow){echo "<h4>Type a course, e.g.: CIT 230.</h4>";}
}

//ADD A NEW ASSIGNMENT
function addNewAssig(){
    echo $inputs .=  
        "<form method='POST'>".
            "Course name:<br>".
            "<input type='text' name='courseName' placeholder='e.g.: CIT 230'><br><br>".
            "Assignment name:<br>".
            "<input type='text' name='name' placeholder='e.g.: 02 Quiz'><br><br>".
            "Week:<br>".
            "<input type='number' name='week' min='1' max='14' placeholder='e.g.: 12'><br><br>".
            "Due-date:<br>".
            "<input type='date' name='dueDate' min='2019-01-06' max='2019-12-31' placeholder='e.g.: 2019-03-06'><br><br>".
            "It's done?:<br>".
            "<input type='radio' name='done' value='Y'> Yes<br>".
            "<input type='radio' name='done' value='N' checked> No<br><br>".
            "It's alive?:<br>".
            "<input type='radio' name='alive' value='Y' checked> Yes<br>".
            "<input type='radio' name='alive' value='N'> No<br><br>".
            "Points:<br>".
            "<input type='number' name='points' min='10' max='100' step='10' value='10' placeholder='e.g.: 50'><br><br>".
            "Description:<br>".
            "<textarea rows='5' cols='50' name='description' placeholder='type the Assignment description here'></textarea><br><br>".
            "Personal Notes:<br>".
            "<textarea rows='5' cols='50' name='personalNotes' placeholder='type the Assignment Personal Notes here'></textarea><br><br>".
            "Instructor Agreement:<br>".
            "<textarea rows='5' cols='50' name='instructorAgreement' placeholder='type the Instructor Agreement if this assignment is a backlog'></textarea><br><br>".
            "<input type='submit' value='Add Assignment'><br><br>".
            "<input type='reset' value='Reset form'>".
        "</form><br>";
    echo "<a href='assigList.php'>Previous Page</a>";
    
    //VARIABLES COMMING FROM THE FORM BY POST METHOD
    $courseName = htmlspecialchars(strtoupper($_POST['courseName']));
    $week = htmlspecialchars($_POST['week']);
    $points = htmlspecialchars($_POST['points']);
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $personal_notes = htmlspecialchars($_POST['personalNotes']);
    $instructor_agreement = htmlspecialchars($_POST['instructorAgreement']);
    $due_date = htmlspecialchars($_POST['dueDate']);
    $done = htmlspecialchars($_POST['done']);
    $alive = htmlspecialchars($_POST['alive']);
        
    $db = conexion();
    $stmt = $db->query("INSERT INTO assignment ( 
    courseID, 
    week,
    points,
    name,
    description,
    personal_notes,
    instructor_agreement,
    due_date,
    done,
    alive) 
    
    VALUES
        (
    (SELECT courseid from course WHERE course_name='$courseName'),
    '$week',
    '$points',
    '$name',
    '$description',
    '$personal_notes',
    '$instructor_agreement',
    '$due_date',
    '$done',
    '$alive')");
    
    if(!$stmt){echo "<h4>Oh no! We've got an error! XP</h4>";}
}
?>