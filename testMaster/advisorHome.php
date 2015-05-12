<?php

session_start();

?>

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


<head>
<title>COEIT Advisor Home Page</title>
<!-- ============================================================== -->
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="description" content="UMBC Advising" />
<meta name="keywords" content="UMBC, Advising" />
<!-- ============================================================== -->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">


    <!-- -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/oneyoung/jquery-calendar/master/css/style.css" />
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/oneyoung/jquery-calendar/master/js/calendar.js"></script>
    
    <!-- Custom style for sign in -->
  <link href="css/signin.css" rel="stylesheet">

   <!-- Main Style -->
  <link href="css/main.css" rel="stylesheet">

   <!-- Timetable Style -->
  <link href="css/timetable.css" rel="stylesheet">
    
  <link rel="icon" type="image/png" href="icon.png" />
    
   
</head>


<body>

  <!--Navigation Bar-->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <img class="navbar-brand"  src="res/logo.png" >      
        </div>
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="advisorSetAvail.php">Add Availability</a></li>
            <li class="divider"></li>
            <li><a href="advisorChangeAvail.php">Edit Availability</a></li>
            <li class="divider"></li>
            <li><a href="advisorHome.php">Home</a></li>
            <li class="divider"></li>
            <li><a href="advisorIndex.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
      <div class="titleBar">
             <h2>COEIT Advisor Home Page</h2>
      </div>
       
    </div>
  </nav>

<?php


	echo("<div class='container'>");
	
	$debug = false;
	include('CommonMethods.php');
	$COMMON = new Common($debug); // common methods
	
	if($_POST['date'] != NULL)
	{
		$date = ($_POST['date']);
		$_SESSION['date'] = $date;
	}
	else if ($_SESSION['date'] != NULL)
	{
		$date = $_SESSION['date'];
		$_SESSION['date'] = $date;	
	}
	else
	{
		$date = "2015-03-02";
		$_SESSION['date'] = $date;
	}
	
	$advisingArray = array();
	
	$advFname = ($_POST['advFname']);
	$advLname = ($_POST['advLname']);
	$advisorID = strtoupper(($_POST['advisorID']));
	
	if ( $advFname == NULL)
	{
		$date = ($_SESSION['date']);
		$advFname = ($_SESSION['advFname']);
		$advLname = ($_SESSION['advLname']);
		$advisorID = ($_SESSION['advisorID']);
	}
	
	
	$_SESSION['advisorID'] = $advisorID;
	$_SESSION['advFname'] = $advFname;
	$_SESSION['advLname'] = $advLname;
	$_SESSION['date'] = $date;

    $sqlDate = $date;
	
	
		
		  
		echo("Welcome advisor, <b>$advFname $advLname</b>, to the Advisor Home Page.<br><br>");
		
		//displays range that you must choose dates from
		$sqlIsWeekDay = "SELECT DATE_FORMAT(  `date` ,  '%W, %b. %d, %Y' ) FROM `dates` WHERE `date` = '$sqlDate' LIMIT 1";
		$getIsWeekDay = $COMMON->executeQuery($sqlIsWeekDay,$_SERVER["SCRIPT_NAME"]);
		$fetchDay = mysql_fetch_row($getIsWeekDay);
		
		$sqlRange = "SELECT MAX(  DATE_FORMAT(  `date` ,  '%b. %d, %Y' ) ) FROM  `dates` WHERE 1 GROUP BY  `date`";
		$rsGetRange = $COMMON->executeQuery($sqlRange,$_SERVER["SCRIPT_NAME"]);
		$fetchRange = mysql_fetch_row($rsGetRange);
		
		$startDay = $fetchRange[0];
		$endDay = "";
		
		while ($fetchRange = mysql_fetch_row($rsGetRange))
		{
			$endDay = $fetchRange[0];	
		}
		
		
		echo("To set appointment availabilities or to remove exisiting appointment times from your availability please select Menu in the upper right hand corner and select which option you would like to configure.<br><br>");
		
		echo("<div class='theContainer'><div class='leftContainer'>");
		
		echo("To quickly view the current week's schedule for an advisor please select from the options below and click Show Schedule.");
	
	//WEEK AT A GLANCE	
		echo("<div class='dropdown'>");
	echo("<form action='advisorShowSchedule.php' method='post' target='_blank' name='advAvail'>");
	echo("<button class='btn btn-sm btn-primary' type='submit' >Week At A Glance</button>");
	echo(" for: ");
	echo("<select name='advisor'>");
	echo("<option value=all>All Advisors</option>");
	
	$sqlGetAdvName = "SELECT * FROM `advisors` ";
	$rsGetAdvName = $COMMON->executeQuery($sqlGetAdvName, $_SERVER["SCRIPT_NAME"]);
	$advName;
	$space = " ";
	$advFullName;
	$advFName;
	$advLName;
	$advName;
	
	while($rowAdv = mysql_fetch_row($rsGetAdvName))
	{
		 $advFullName=$rowAdv[1].$space.$rowAdv[2];
		 $advName=$rowAdv[1] . " " . $rowAdv[2];
		 echo("<option value='");
		 echo("$advName'");
		 echo(">" . $advName . "</option>");
	}
	echo("</select>");
	echo("</form>");
	echo("</div>");
	
	echo("</div><div class='rightContainer'>");
	
		//SEARCH FOR STUDENT ID
		echo("To look up info on a student and / or delete their appointment please enter a valid student ID. (<a href='advisorHome.php'>Refresh</a> page after deletions.)<br>");
		
		echo("<form class='form-inline' action = 'studentInfo.php' target='_blank' method ='post'>
        <label for='inputStudentID' class='sr-only'>Search For Student</label>
        <input type='text' name = 'studentID' class='form-control' placeholder='Search For Student'  autofocus>
		<button class='btn btn-sm btn-primary' type='submit' >Search</button>
      </form>");
	  
	echo("</div></div></div><div class='container'>");
	  

	  //SELECT DAY BY CALENDAR ACTION
	  echo("<form action='advisorHome.php' method='post' name='Form5'>");
		
		echo("Otherwise please select a day to show appointments by choosing a weekday between $startDay and $endDay. Switch days by using the calendar below.<br>");
	
	  	echo("<input class='date-picker' type='text' value='$sqlDate' name='date'/>");
	  
	  	echo("<button class='btn btn-sm btn-primary' type='submit' >Go</button></form>");
		
		if ($fetchDay[0] == NULL)
		{
			echo("<b><font color='red'>You have not chosen a day when appointments are available.</font></b><br> ");	
		}
		else
		{
		echo("If you would like to print schedule information for an advisor on a chosen day please select the advisor at the top of the schedule table and click Print Schedule at the bottom of the page.");
		}
	  	echo("<br></div></div>");
	
		if ($fetchDay[0] != NULL)
		{
		$sqlReturnDate = "SELECT DATE_FORMAT(  `date` ,  '%b. %d, %Y' ) FROM `dates` WHERE `date` = '$sqlDate' LIMIT 1";
		$getDate = $COMMON->executeQuery($sqlReturnDate,$_SERVER["SCRIPT_NAME"]);
		$fetchDate = mysql_fetch_row($getDate);
	
		 //<!--Sign In-->
	  	echo("<div class='container'>
		<h4>$fetchDate[0]</h4>
		<table class='table' border='1'>
	   
		<thead>
		  <tr>
			<th class='warning'>Time</th>");
	
		//echo advisor names in th tag here
				
			  $advisorSql = "SELECT * FROM `advisors` WHERE 1";
			  $rs = $COMMON->executeQuery($advisorSql,$_SERVER["SCRIPT_NAME"]);
	
	echo("<form class='formm-signin' action='advisorDaySchedule.php' target='_blank' method='post' name='Form2'>"); 
	
	//echo("<button class='btn btn-lg btn-primary' type='submit' >Print Schedule</button><br><br>");
	
			   $advisorInfo = array();
			  $advisorID = array();
			  $count = 0;
			  while($row = mysql_fetch_row($rs)){
				$advisorInfo[$count] = $row;
				$count++;
			  }
				// advisor names
				for ($i= 0; $i < $count; $i++) { 
					echo "<th  class='advisorSlotOpen' class='warning'>";
					//echo advisor name
					$advName=$advisorInfo[$i][1] . " " . $advisorInfo[$i][2];
					$advisorID[$i] = $advisorInfo[$i][0];
					echo("<input id='$advisorID[$i]' type='radio' name='advName' value='$advName $sqlDate' checked><label for='$advisorID[$i]'>");
					$name = $advisorInfo[$i][2];
					//var_dump($advisorInfo[$i][0]);
					echo "<u>$name</u>";
					echo "</label></th>";
				}
			
	
			echo("  </tr>
			</thead>
		
			<!--  echo advisor names in th tag here-->
			<tbody>");
	
			  // time info
			  $apptTimeSql = "SELECT TIME_FORMAT(`time`, '%h:%i %p'), `time` FROM `times` WHERE 1";
			  $rs = $COMMON->executeQuery($apptTimeSql,$_SERVER["SCRIPT_NAME"]);
			  $apptTimeInfo;
			  $count = 0;
			  while($row = mysql_fetch_row($rs)){
				$apptTimeInfo[$count] = $row;
				$count++;
			  }
			  
			  $rowColor = 0; 
			  
				foreach ($apptTimeInfo as $timeInfo) {
	
				  // time
				  if($rowColor % 3 == 0)
				  {
				  echo "<tr class='info'>";
				  }
				  else if($rowColor % 3 == 1)
				  {
				  echo "<tr class='danger'>";
				  }
				   else if($rowColor % 3 == 2)
				  {
				  echo "<tr class='success'>";
				  }
				   echo "<td>$timeInfo[0]</td>";
	
					// get appt info
				  $time = $timeInfo[1];
				  
				  for($i = 0; $i<count($advisorID); $i++)
				  {
					  $getStudentIDs = "SELECT `studentID` FROM `appointments` WHERE `time` = '$time' AND `date` = '$sqlDate' and `advisorID` = '$advisorID[$i]'";
					  $rs = $COMMON->executeQuery($getStudentIDs,$_SERVER["SCRIPT_NAME"]);
					  
					  $group = 0;
					  $numNull = 0;
					  
					  echo"<td>";
					  while ($fetchStudentIDs = mysql_fetch_row($rs))
					  {
						 if ($fetchStudentIDs[0] != NULL)
						 {
						 $getStudentNames = "Select `fname`, `lname` FROM `students` WHERE `studentID` = '$fetchStudentIDs[0]'";
						 $getName = $COMMON->executeQuery($getStudentNames,$_SERVER["SCRIPT_NAME"]);
						 //displays student IDS and names
						 $fetchStudentNames = mysql_fetch_row($getName);
						  echo("$fetchStudentIDs[0] - $fetchStudentNames[0] $fetchStudentNames[1]<br>");
						 }
						  $group++;
						  if($fetchStudentIDs[0] == NULL)
						  {
							$numNull++;  
						  }
					  }
					  
					  $getMajor = "SELECT `major` FROM `appointments` WHERE `time` = '$time' AND `date` = '$sqlDate' and `advisorID` = '$advisorID[$i]' LIMIT 1";
					  $majorRs = $COMMON->executeQuery($getMajor,$_SERVER["SCRIPT_NAME"]);
					  	$fetchMajor = mysql_fetch_row($majorRs);
					  
					  //displays addtl appt. info
					  if ($group > 1)
					  {
						echo("Group Appt<br>Slots Open = $numNull of $group<br>");
						
						if($fetchMajor[0] == NULL)
						{
						echo("Major = ANY");
						}
						else
						{
						echo("Major = $fetchMajor[0]");	
						}
						  
					  }
					  else if($group == 1)
					  {
						echo("Single Appt<br>"); 
						
						if($fetchMajor[0] == NULL)
						{
						echo("Major = ANY");
						}
						else
						{
						echo("Major = $fetchMajor[0]");	
						}
						 
					  }
					  echo"</td>";
					  
				  }
					$rowColor++;
					echo "</tr>"; 
				}
			
	
	
			
		echo("</tbody></table><button class='btn btn-lg btn-primary' type='submit' >Print Schedule</button></form> <br><br>");
		}
	
	echo("</div>");

?>

<!-- Load javascript required for Bootstrap animation-->
<script src="https://code.jquery.com/jquery.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
		$(".advisorSlotOpen").click(function(){
			console.log("clicked");
		});
});
</script>

<script type = "text/javascript" >
    history.pushState(null, null, 'advisorHome.php');
    window.addEventListener('popstate', function(event) {
    	history.pushState(null, null, 'advisorHome.php');
    });
	window.onpopstate=function()
	{
	  alert("Use of the back button has been disabled, please navigate the website using the links on the page.");
	}
</script>

</body>
</html>
