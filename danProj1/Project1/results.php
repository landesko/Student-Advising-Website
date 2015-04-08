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

//We include this so we can log into our database
include('../CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

//Create variables to accept session and posted data
$date = ($_POST['date']);
$fname = ($_SESSION['fname']);
$lname = ($_SESSION['lname']);
$studentID = ($_SESSION['studentID']);
$major = ($_SESSION['major']);
$advisor = ($_SESSION['advisor']);

//Recreate session variables to send to the next page
$_SESSION['studentID'] = $studentID;
$_SESSION['fname'] = $fname;
$_SESSION['lname'] = $lname;
$_SESSION['major'] = $major;
$_SESSION['date'] = $date;
$_SESSION['advisor'] = $advisor;


//Algorithm to assign $sqlAdvisor a string based on which advisor the student previously chose
//This allows us to properly query our data base
//THIS MUST EDITTED TO ADD ANY NEW ADVISORS
if ($advisor == "Josh Abrams")
{
	$sqlAdvisor = "jAbrams";	
}
else if ($advisor == "Anne Arey")
{
	$sqlAdvisor = "aArey";	
}
else if ($advisor == "Emily Stephens")
{
	$sqlAdvisor = "eStephens";	
}
else if ($advisor == "Group Advising")
{
	$sqlAdvisor = "gAdvising";	
}

//creates session variable of $sqlAdvisor for later use
$_SESSION['sqlAdvisor'] = $sqlAdvisor;

//Assigns chose dates to an $sqlDate so we can properly query our database
//MUST BE EDITTED TO ADD ANY NEW DATES
if ($date == "3/23")
{
	$sqlDate = "2015-03-23";	
}
else if ($date == "3/24")
{
	$sqlDate = "2015-03-24";	
}
else if ($date == "3/25")
{
	$sqlDate = "2015-03-25";	
}
else if ($date == "3/26")
{
	$sqlDate = "2015-03-26";	
}
else if ($date == "3/27")
{
	$sqlDate = "2015-03-27";	
}

//creates session variable of $sqlDate for later use
$_SESSION['sqlDate'] = $sqlDate;

//Reiterates name who who student chose
echo($fname . " " . $lname . " is logged in."); 
echo("<br \n> <br \n>");

echo ("You chose " . $advisor . ".");
echo ("<br><br>");
echo ("<h3>Availability for " . $advisor . "</h3>");
echo ("<p>Please Select A Meeting Time</p>");


//If the student chose group advising
if ($sqlAdvisor == "gAdvising")
{
	//This returns only one instance of each time in the database
		$sql = "SELECT  `date` , MAX(  `time` ) 
	FROM  `gAdvising`
	WHERE  `date` =  '$sqlDate'
	GROUP BY  `time`";
	
	//This formats the time so it is easy for our user to understand
		$sqlFormat =  "SELECT  DATE_FORMAT(  `date` ,  '%b. %d %Y' ) , MAX(TIME_FORMAT(`time` , '%h:%i %p')) 
	FROM  `gAdvising`
	WHERE  `date` =  '$sqlDate'
	GROUP BY  `time`";
	
	//Calls to the database
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$rsFormat = $COMMON->executeQuery($sqlFormat, $_SERVER["SCRIPT_NAME"]);
	
	//Tables setup
	echo ("<table style='width:95%'> 
			<tr> <th>Available</th>
				<th>Time</th>		
				<th>Day</th>
			  </tr>");
	  
	echo("<form action='added.php' method='post' name='Form1'>");
	while (($row = mysql_fetch_row($rs)) && ($rowFormat = mysql_fetch_row($rsFormat)))
	{
		
		echo("<tr>");
		
		//This counts the number of available slots for the group advising appointments
		$sql2 = "SELECT COUNT(  `available` ) 
		FROM  `gAdvising` 
		WHERE  `time` =  '$row[1]'
		AND  `date` =  '$row[0]' AND `available` = 1";
	
		//Calls to the data base
		$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
		$row2 = mysql_fetch_row($rs2);
	
		//Row formatting, if there is an available slot, put a radio button for the table
		if ($row2[0] > 0)
		{
			echo("<th><input type='radio' name='time' value='$row[1]' checked>".$row2[0]."</th>");
		}
		else
		{
			echo("<th>".$row2[0]."</th>");
		}
		echo("<th>".$rowFormat[1]."</th>");
		echo("<th>".$rowFormat[0]."</th>");
	
		
		echo("</tr>");
	}
	 
	echo("</table><br>");
	echo("<input type='submit' name='submit' value='Submit'>");
	echo("</form> <br><br>");

}
//If the student chose anything else except group advising
else
{
	//This queries for the properly formatted time and date
	$sqlFormat = "SELECT  `available` ,  TIME_FORMAT(`time` , '%h:%i %p') ,  DATE_FORMAT(  `date` ,  '%b.		 %d %Y' ) 
	FROM  `$sqlAdvisor` 
	WHERE `date` = '$sqlDate'";
	
	//Regular query
	$sqlTime = "SELECT  `available` , `time` ,  `date`
	FROM  `$sqlAdvisor` 
	WHERE `date` = '$sqlDate'";
	
	//Call to the database
	$rsFormat = $COMMON->executeQuery($sqlFormat, $_SERVER["SCRIPT_NAME"]);
	$rsTime = $COMMON->executeQuery($sqlTime, $_SERVER["SCRIPT_NAME"]);
	
	//Table setup
	echo ("<table style='width:95%'> 
	<tr> <th>Available</th>
		<th>Time</th>		
		<th>Day</th>
	  </tr>");
	 
	 //Form setup 
	echo("<form action='added.php' method='post' name='Form1'>");  
	while (($rowFormat = mysql_fetch_row($rsFormat)) && ($rowTime = mysql_fetch_row($rsTime)))
	{
		echo("<tr>");
		
		//More formatting for the table, puts a yes or no if available
		for ($i = 0; $i<count($rowFormat); $i++)
		{
			if ($rowFormat[0] == 1)
			{
				$rowFormat[0] = "YES";	
			}
			else if ($rowFormat[0] == 0)
			{
				$rowFormat[0] = "NO";	
			}
			//If a slot is available make the option to choose the slot
			if ($i == 0)
			{
				if ($rowFormat[0] == "YES")
				{
					echo("<th><input type='radio' name='time' value='$rowTime[1]' checked>".$rowFormat[$i]."</th>");
				}
				else
				{
					echo("<th>".$rowFormat[$i]."</th>");
				}
			}
			else
			{
			echo("<th>".$rowFormat[$i]."</th>");
			}
			
		}
		echo("</tr>");
	}  
	echo("</table><br>");
	echo("<input type='submit' name='submit' value='Submit'>");
	echo("</form> <br><br>");

}

//Allow the user to pick a different date if they would like
//MUST BE EDITTED IF MORE DATES ARE TO BE ADDED!!!!
echo ("Would you like to view another date for $advisor? <br>");
echo("
<form action='results.php' method='post' name='Form1'>
<input type='radio' name='date' value='3/23' checked>March 23, 2015
<br>
<input type='radio' name='date' value='3/24'>March 24, 2015
<br>
<input type='radio' name='date' value='3/25'>March 25, 2015
<br>
<input type='radio' name='date' value='3/26'>March 26, 2015
<br>
<input type='radio' name='date' value='3/27'>March 27, 2015
<br> <br />
<input type='submit' name='submit' value='Submit'>
</form> <br>");

//Links back to llst of advisors
echo ("Would you like to view another advisor? <br>");
echo("<a href='readvisors.php'>List of Advisors</a>");
 
 ?>
 
</p>

</div>
</div>

</body>
</html>
