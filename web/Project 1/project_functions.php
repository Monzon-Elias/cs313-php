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
    
    $thead .= "<th>Course</th>"."<th>Name</th>"."<th>Update</th>"."<th>Delete</th>";

    echo "<table>";
    echo $thead;
    
    while ($row = $stmt->fetch(PDO::FETCH_OBJ))
            {
            $tableRow .= "<tr>".
            "<td>$row->course_name</td>".
            "<td><a href='assigDetails.php?assigId=$row->assigid'>$row->name</a></td>".
            "<td><a href='updateAssig.php?assigId=$row->assigid'>Update</a></td>".
            "<td><a href='assigDeletedConfirPage.php?assigId=$row->assigid'>Delete</a></td>".
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
	$details .="<ul>".
        "<li><label>Name:</label> $row->name</li>".
        "<li><label>Course:</label> $row->course_name</li>".
        "<li><label>Week:</label> $row->week</li>".
        "<li><label>Due-Date:</label> $row->due_date</li>".
        "<li><label>It's done?:</label> $row->done</li>".
        "<li><label>It's alive?:</label> $row->alive</li>".
        "<li><label>Points:</label> $row->points</li>".
        "<li><label>Description:</label> $row->description</li>".
        "<li><label>Personal Notes:</label> $row->personal_notes</li>".
        "<li><label>Instructor Agreement:</label> $row->instructor_agreement</li>"
        ."</ul>";
    }
    echo $details;
}

//SEARCH BY ASSIGNMENT
function searchByAssigName(){
$db = conexion();
$searchBy = htmlspecialchars(strtoupper($_GET['courseName']));
$stmt = $db->query("SELECT * FROM assignment a, course c WHERE a.courseid = c.courseid AND c.course_name LIKE '%$searchBy%'");
    
    $thead .= "<th>Course</th>"."<th>Name</th>";
    
    while ($row = $stmt->fetch(PDO::FETCH_OBJ))
            {
            echo "<table>";
            echo $thead;
            $tableRow .= "<tr>".
            "<td>$row->course_name</td>".
            "<td><a href='assigDetails.php?assigId=$row->assigid'>$row->name</a></td>".
            "</tr>";
            }
    echo $tableRow;
    echo "</table>";
    
if(!$tableRow){echo "<h4>It seems that there's no $searchBy course!</h4>";}
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
            "<input type='number' name='week' min='1' max='14' placeholder='e.g.: 6 '><br><br>".
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
            "<textarea rows='5' cols='50' name='description' placeholder='type the Assignment description and topics here'></textarea><br><br>".
            "Personal Notes:<br>".
            "<textarea rows='5' cols='50' name='personalNotes' placeholder='type the Assignment Personal Notes here'></textarea><br><br>".
            "Instructor Agreement:<br>".
            "<textarea rows='5' cols='50' name='instructorAgreement' placeholder='type the Instructor Agreement if this assignment is a backlog'></textarea><br><br>".
            "<button type='submit'>Add Assignment</button><br><br>".
            "<button type='reset'>Reset form</button>".
        "</form><br>";
    echo "<a href='assigList.php'>Back to Assignment List Page</a>";
    
    //VARIABLES COMING FROM THE FORM BY POST METHOD 
    $courseName = htmlspecialchars(strtoupper($_POST['courseName']));
    $week = htmlspecialchars($_POST['week']);
    $points = htmlspecialchars($_POST['points']);
    $name = htmlspecialchars(ucfirst($_POST['name']));
    $description = htmlspecialchars(ucfirst($_POST['description']));
    $personal_notes = htmlspecialchars(ucfirst($_POST['personalNotes']));
    $instructor_agreement = htmlspecialchars(ucfirst($_POST['instructorAgreement']));
    $due_date = htmlspecialchars($_POST['dueDate']);
    $done = htmlspecialchars(strtoupper($_POST['done']));
    $alive = htmlspecialchars(strtoupper($_POST['alive']));
        
    //ADD THE ASSIG NAME TO THE GLOBAL VARIABLE FOR DISPLAYING IN THE CONFIRMATION PAGE
    session_start();
    $_SESSION["assigName"] = $name;
    
    $db = conexion();
    //ADD COURSE IF COURSE DOES NOT EXISTS
    $stmt = $db->query("SELECT * from course WHERE course_name='$courseName'");
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    session_start();
    if($row->course_name !== $courseName) 
    {
    $stmt = $db->query("INSERT INTO course (instructor, semester, course_name) VALUES (NULL, NULL, '$courseName')"); $_SESSION["newCourse"] = "new course added!";//FOR DISPLAYING IN THE CONFIG PAGE
    }
    //INSERT INTO ASSIGNMENT TABLE
    $stmt = $db->query("INSERT INTO assignment ( 
    courseid, 
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
    
    if(($stmt)){header('Location: assigAddedConfirPage.php'); die();} else{echo "<h4>Oh no! We've got an error! XP</h4>";}
}

//SEARCH BY ASSIGNMENT
function deleteAssignment(){
if (!isset($_GET['assigId']))
{
	die("Error, assignment id not specified...");
}
$assig_id = htmlspecialchars($_GET['assigId']);
$db = conexion();
$stmt = $db->query("SELECT name FROM assignment WHERE assigid = '$assig_id'");
$row = $stmt->fetch(PDO::FETCH_OBJ);
session_start();
$_SESSION["assigName"] = $row->name;
$stmt = $db->query("DELETE FROM assignment WHERE assigid = '$assig_id'");
if((!$stmt)){echo "<h4>Oh no! We've got an error deleting this assignment! XP</h4>";}
}

//UPDATE ASSIGNMENTS
function updateAssignment(){
    if (!isset($_GET['assigId']))
{
	die("Error, assignment id not specified...");
}
    $assig_id = htmlspecialchars($_GET['assigId']);
    $db = conexion();
    $stmt = $db->query("SELECT * FROM assignment a, course c WHERE a.courseid = c.courseid AND assigid = '$assig_id'");
    while ($row = $stmt->fetch(PDO::FETCH_OBJ))
    { 
    //SHOWING THE ASSIGNMENT DETAILS INSIDE INPUTS FOR FURTHER UPDATING  
	$details .= "<form method='POST'>".
        "<li>Name: <input type='text' name='name' value='$row->name'></li>".
        "<li>Course: <input type='text' name='courseName' value='$row->course_name'></li>".
        "<li>Week: <input type='number' name='week' min='1' max='14' value='$row->week'></li>".
        "<li>Due-Date: <input type='date' name='dueDate' min='2019-01-06' max='2019-12-31' value='$row->due_date'></li>".
        "<li>It's done?: <input type='text' name='done' maxlength='1' value='$row->done'>"."<span style='color:red; font-size: 14px'> Only type 'Y' or 'N'</span>"."</li>".
        "<li>It's alive?: <input type='text' name='alive' maxlength='1' value='$row->alive'><span style='color:red; font-size: 14px'> Only type 'Y' or 'N'</span></li>".
        "<li>Points: <input type='number' name='points' min='10' max='100' step='10' value='$row->points'></li>".
        "<li>Description: <br>"."<textarea rows='5' cols='50' name='description'>$row->description</textarea>"."</li>".
        "<li>Personal Notes: <br>"."<textarea rows='5' cols='50' name='personalNotes'>$row->personal_notes</textarea>"."</li>".
        "<li>Instructor Agreement: <br>"."<textarea rows='5' cols='50' name='instructorAgreement'>$row->instructor_agreement</textarea>"."</li>".
        "<input type='submit' value='Update Assignment'>".
        "</form><br>";
    }
    echo $details;
    
    //VARIABLES COMING FROM THE FORM BY POST METHOD 
    $courseName = htmlspecialchars(strtoupper($_POST['courseName']));
    $week = htmlspecialchars($_POST['week']);
    $points = htmlspecialchars($_POST['points']);
    $name = htmlspecialchars(ucfirst($_POST['name']));
    $description = htmlspecialchars(ucfirst($_POST['description']));
    $personal_notes = htmlspecialchars(ucfirst($_POST['personalNotes']));
    $instructor_agreement = htmlspecialchars(ucfirst($_POST['instructorAgreement']));
    $due_date = htmlspecialchars($_POST['dueDate']);
    $done = htmlspecialchars(strtoupper($_POST['done']));
    $alive = htmlspecialchars(strtoupper($_POST['alive']));
    
    //ADD COURSE IF COURSE DOES NOT EXISTS
    $stmt = $db->query("SELECT * from course WHERE course_name='$courseName'");
    $row = $stmt->fetch(PDO::FETCH_OBJ);
    
    //ADD THE ASSIG NAME TO THE GLOBAL VARIABLE FOR DISPLAYING IN THE CONFIRMATION PAGE
    session_start();
    $_SESSION["assigName"] = $name;
    
    if($row->course_name !== $courseName) 
    {
    $stmt = $db->query("INSERT INTO course (instructor, semester, course_name) VALUES (NULL, NULL, '$courseName')"); $_SESSION["newCourse"] = "new course added!";
    }
    
    //UPDATE INTO ASSIGNMENT TABLE
    $stmt = $db->query("UPDATE assignment 
    SET 
    courseid = (SELECT courseid from course WHERE course_name='$courseName'),
    week = '$week',
    points = '$points',
    name = '$name',
    description = '$description',
    personal_notes = '$personal_notes',
    instructor_agreement = '$instructor_agreement',
    due_date = '$due_date',
    done = '$done',
    alive = '$alive'
    WHERE assigid = '$assig_id';");
    
    if(($stmt)){header('Location: assigUpdatedConfirPage.php'); die();} else{echo "<h4>Oh no! We've got an error! XP</h4>";}
    echo "<a href='assigList.php'>Previous Page</a>";
}

//CREATING AN ACCOUNT USER
function accountCreate(){
// get the data from the POST
$username = $_POST['user_name'];
$password = $_POST['user_password'];
if (!isset($username) || $username == ""
	|| !isset($password) || $password == "")
{
	header('Location: signUp.html');
	die(); // we always include a die after redirects.
}
// Let's not allow HTML in our usernames. It would be best to also detect this before
// submitting the form and preven the submission.
$username = htmlspecialchars($username);
// Get the hashed password.
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
// Connect to the database
$db = conexion();
$query = ('INSERT INTO app_user(user_name, user_password) VALUES(:user_name, :user_password)');
$statement = $db->prepare($query);
$statement->bindValue(':user_name', $username);
// **********************************************
// NOTICE: We are submitting the hashed password!
// **********************************************
$statement->bindValue(':user_password', $hashedPassword);
$statement->execute();
// finally, redirect them to the sign in page
header('Location: signIn.php');
die();
}

//SIGN IN FUNCTION
function signIn(){
session_start();
$badLogin = false;
// First check to see if we have post variables, if not, just
// continue on as always.
if (isset($_POST['user_name']) && isset($_POST['user_password']))
{
	// they have submitted a username and password for us to check
	$username = $_POST['user_name'];
	$password = $_POST['user_password'];
	// Connect to the DB
	$db = conexion();
	$query = ('SELECT user_password FROM app_user WHERE user_name = :user_name');
	$statement = $db->prepare($query);
	$statement->bindValue(':user_name', $username);
	$result = $statement->execute();
	if ($result)
	{
		$row = $statement->fetch();
		$hashedPasswordFromDB = $row['user_password'];
		// now check to see if the hashed password matches
		if (password_verify($password, $hashedPasswordFromDB))
		{
			// password was correct, put the user on the session, and redirect to home
			$_SESSION['user_name'] = $username;
			header('Location: welcome.php');
			die(); // we always include a die after redirects.
		}
		else
		{
			$badLogin = true;
		}
	}
	else
	{
		$badLogin = true;
	}
  }
}
// SIGN OUT
function signOut(){
session_start();
unset($_SESSION['user_name']);
header('Location: signIn.php');
die();
}
?>