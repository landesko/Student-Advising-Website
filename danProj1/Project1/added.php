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
//Stage1

//$var_dump($_POST); 

//Stage2

include('../CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

//Accepts session and posted data
$time = ($_POST['time']);
$date = ($_SESSION['date']);
$fname = ($_SESSION['fname']);
$lname = ($_SESSION['lname']);
$studentID = ($_SESSION['studentID']);
$major = ($_SESSION['major']);
$advisor = ($_SESSION['advisor']);
$sqlAdvisor = ($_SESSION['sqlAdvisor']);
$sqlDate = ($_SESSION['sqlDate']);

//Recreates instance of session data
$_SESSION['studentID'] = $studentID;
$_SESSION['fname'] = $fname;
$_SESSION['lname'] = $lname;
$_SESSION['major'] = $major;
$_SESSION['date'] = $date;
$_SESSION['advisor'] = $advisor;

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
			If this an error please remove yourself by clicking <a href='remove.php'>here</a>. 
			<b>CLICKING WILL AUTOMATICALLY REMOVE YOUR APPOINTMENT!</b><br><br>
			Otherwise <a href='index.php'>logout</a>.<br>"); 
}
//If a student doesn't have an existing appointment and they chose group advising
else if ($sqlAdvisor == "gAdvising")
{
	//Finds the first available appointment slot for group advising
	$sql = "SELECT  `apptNum` 
FROM  `gAdvising` 
WHERE  `available` =  '1'
AND  `time` =  '$time'
AND  `date` =  '$sqlDate'
LIMIT 1";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$apptNum = mysql_fetch_row($rs);
	
	//Update the appointment as necessary
	$sql = "UPDATE  `dale2`.`$sqlAdvisor` SET  `studentID` =  '$studentID',
`fname` =  '$fname',
`lname` =  '$lname',
`major` =  '$major',
`available` =  '0' WHERE `apptNum` = '$apptNum[0]'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	//Requeries the database to pull all the information about the appointment
	$sql = "SELECT TIME_FORMAT(`time` , '%h:%i %p') ,  DATE_FORMAT(  `date` ,  '%b. %d %Y' )
	FROM `$sqlAdvisor`
	WHERE `apptNum` = '$apptNum[0]'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$apptTime = mysql_fetch_row($rs);
	
	//Reiterates the chosen appointment time to the student then asks them to logout
	echo("You have successfully created an appointment on:<br>
		$apptTime[1] at $apptTime[0] with Group Advising. <br>
		 Please <a href='index.php'>logout</a>.");
	
}
//If the student chose any other advisor besides group advising
else
{
	//We update the correct appointment time
	$sql =  "UPDATE  `dale2`.`$sqlAdvisor` SET  `studentID` =  '$studentID',
`fname` =  '$fname',
`lname` =  '$lname',
`major` =  '$major',
`available` =  '0' WHERE `time` ='$time' AND `date` = '$sqlDate'";
	
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
	//Requery the database to get the appointment information
	$sql = "SELECT TIME_FORMAT(`time` , '%h:%i %p') ,  DATE_FORMAT(  `date` ,  '%b. %d %Y' )
	FROM `$sqlAdvisor` 
	WHERE `time` ='$time' AND `date` = '$sqlDate'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$apptTime = mysql_fetch_row($rs);
	
	//Reiterate the appointment information back to the student to make sure all is well
	echo("You have successfully created an advising appointment on:  <br> $apptTime[1] at $apptTime[0] with");
	
	//MUST EDIT THIS TO ADD ANY NEW ADVISOR NAMES
	if($sqlAdvisor == "gAdvising"){
		$realName = "Group Advising";
	}
	else if ($sqlAdvisor == "jAbrams"){
		$realName = "Josh Abrams";
	}
	else if ($sqlAdvisor == "eStephens"){
		$realName = "Emily Stephens";
	}
	else if ($sqlAdvisor == "aArey"){
		$realName = "Anne Arey";
	} 
	echo(" $realName.<br>Please <a href='index.php'>logout</a>."); 	
}

?>



</p>

</div>
</div>

</body>
</html>