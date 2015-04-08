<?php

session_start();

?>
<!-- ^^ starts a php session for data to be passed between pages -->

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
//Allows us to connect to the database
include('../CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

//Accepts data from form on index.php
$fname = ($_POST['fname']);
$lname = ($_POST['lname']);
$studentID = strtoupper(($_POST['studentID']));
$major = ($_POST['major']);

//Creates session variables to be passed between pages
$_SESSION['studentID'] = $studentID;
$_SESSION['fname'] = $fname;
$_SESSION['lname'] = $lname;
$_SESSION['major'] = $major;


echo ("Welcome, " . $fname . " " . $lname . ", to student advising.<br>");

//These variables are used to check if a student already has an appointment and will accept advisor name
$letsSee = 0;
$advisorName = "";
$realName= "";

//MUST EDIT THIS TO ADD ANY NEW ADVISOR NAMES
$advisorArray = array("jAbrams", "aArey", "eStephens", "gAdvising");

//This is a loop to check each database to see if a student has already signed up for an advising appt.
//CHECKS EVERY ADVISOR TABLE, MUST ADD ADVISOR TO ARRAY IF YOU ADD ANOTHER ADVISOR
for ($i = 0; $i < count($advisorArray); $i++ )
{
	//This counts each instance student ID shows up
	$sql =  "SELECT count(*), '$advisorArray[$i]' as `$advisorArray[$i]` FROM `$advisorArray[$i]` WHERE `studentID` = '$studentID'";

	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$isThere = mysql_fetch_row($rs);
	
	//If there is an instance it gets added to $letsSee and the advisor name gets instantiated
	if ($isThere[0] > 0)
	{
	$letsSee += $isThere[0];
	$advisorName = $isThere[1];
	}
}

//If the student already has an existing appointment
if ($letsSee > 0)
{
	//We query the database the get the information about the appointment
	$sql =  "SELECT  TIME_FORMAT(`time` , '%h:%i %p') ,  DATE_FORMAT(  `date` ,  '%b. %d %Y' )
FROM  `$advisorName` 
WHERE `studentID` = '$studentID'";
	
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$apptTime = mysql_fetch_row($rs);
	echo("<p>You have an existing advising appointment on: <br> $apptTime[1] at $apptTime[0] with");
	
	//MUST EDIT THIS TO ADD ANY NEW ADVISOR NAMES
	//This is formattting for the advisor name
	if($advisorName == "gAdvising"){
		$realName = "Group Advising";
	}
	else if ($advisorName == "jAbrams"){
		$realName = "Josh Abrams";
	}
	else if ($advisorName == "eStephens"){
		$realName = "Emily Stephens";
	}
	else if ($advisorName == "aArey"){
		$realName = "Anne Arey";
	}
	
	$_SESSION['advisorName'] = $advisorName;
	
	echo(" $realName.<br>
			If this is an error or you would like to remove yourself click <a href='remove.php'>here</a>.<br> 
			<b>CLICKING WILL AUTOMATICALLY REMOVE YOUR APPOINTMENT!</b><br><br>
			Otherwise <a href='index.php'>logout</a>.<br>"); 
}
else
{
	echo("Please select which advisor you would like to meet with or choose group advising.");
	
	//Radio buttons to select which advisor the student wants to see
	//MUST EDIT TO ADD ANY NEW ADVISOR NAMES TO THE LIST
	echo("<form action='dates.php' method='post' name='Form1'>
<input type='radio' name='advisor' value='Josh Abrams' checked>Josh Abrams
<br>
<input type='radio' name='advisor' value='Anne Arey'>Anne Arey
<br>
<input type='radio' name='advisor' value='Emily Stephens'>Emily Stephens
<br>
<input type='radio' name='advisor' value='Group Advising'>Group Advising
<br> <br />
<input type='submit' name='submit' value='Submit'>
</form>");
}
?>
<br /> <br />

<!-- MUST EDIT THIS TO ADD ANY NEW ADVISOR NAMES -->
<!-- Radio buttons to select which advisor the student wants to see 
<form action="dates.php" method="post" name="Form1">
<input type="radio" name="advisor" value="Josh Abrams" checked>Josh Abrams
<br>
<input type="radio" name="advisor" value="Anne Arey">Anne Arey
<br>
<input type="radio" name="advisor" value="Emily Stephens">Emily Stephens
<br>
<input type="radio" name="advisor" value="Group Advising">Group Advising
<br> <br />
<input type="submit" name="submit" value="Submit">
</form> -->


</p>

</div>
</div>

</body>
</html>
