<?php

session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


<head>
<title>Advising Sign Up</title>
<!-- ============================================================== -->
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="description" content="UMBC Advising" />
<meta name="keywords" content="UMBC, Advising" />
<!-- ============================================================== -->

<base target="_top" />
<link rel="stylesheet" type="text/css" href="styler.css" />

<base target="_top" />
<link rel="stylesheet" type="text/css" href="template.css" />
<link rel="icon" type="image/png" href="icon.png" />
</head>

<body>

<div class="topContainer">
  <div class="leftTopContainer">
    
  	<img src="umbcLogo.png" width="261" height="72" alt="umbcLogo" />
  	<b>Student Advising</b>
  
  	</div>
    
  <div class="rightTopContainer">
  		<div class="rightTopContent">
        <a href="index.php">Logout</a>	
        </div>
  
    </div>
</div>

<div class="container">
<div class="inner-container">

<p>

<?php

include('../CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

//Accepts session data
$fname = ($_SESSION['fname']);
$lname = ($_SESSION['lname']);
$studentID = ($_SESSION['studentID']);
$major = ($_SESSION['major']);

//Recreate session variables although this is not needed at this point
$_SESSION['studentID'] = $studentID;
$_SESSION['fname'] = $fname;
$_SESSION['lname'] = $lname;
$_SESSION['major'] = $major;

//Recreates the advising array
//MUST BE EDITTED IF MORE ADVISORS ARE TO BE ADDED!!!
$advisorArray = array("jAbrams", "aArey", "eStephens", "gAdvising");

//Much like when we are checking for an existing appointment
//We find if there has already been an appointment created
for ($i = 0; $i < count($advisorArray); $i++ )
{
	$sql =  "SELECT count(*), '$advisorArray[$i]' as `$advisorArray[$i]` FROM `$advisorArray[$i]` WHERE `studentID` = '$studentID'";

	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$isThere = mysql_fetch_row($rs);
	//If there is we set $letsSee to 1 and set the advisor name.
	if ($isThere[0] > 0)
	{
	$letsSee += $isThere[0];
	$advisorName = $isThere[1];
	}
}

//If $letsSee is greater than 0 the previous appointment gets deleted
if ($letsSee > 0)
{
	//Updates database to remove student information from appt slot
	$sql =  "UPDATE  `dale2`.`$advisorName` SET  `studentID` =  NULL,
`fname` =  NULL,
`lname` =  NULL,
`major` =  NULL,
`available` =  '1' WHERE `studentID` ='$studentID'";
	
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	//Displays message that removal was successful
	echo("You have successfully removed yourself from your existing appointment time. <br>Please <a href='index.php'>logout</a>.");	
}
//Otherwise the student did not have an appointment to remove
else
{
	echo("You did not have an existing advising appointment. <br>Please <a href='index.php'>logout</a>.");	
}



?>

</p>

</div>
</div>

</body>
</html>
