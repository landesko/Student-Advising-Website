<?php

session_start();

// COEIT
?>

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


<head>
<title>COEIT Advising Sign Up</title>
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
            <li><a href="http://coeit.umbc.edu/undergraduate-student-services-engineering-and-computer-science-majors">Advising Info</a></li>
            <li class="divider"></li>
            <li><a href="studentIndex.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
      <div class="titleBar">
             <h2>COEIT Student Advising Web Page</h2>
      </div>
       
    </div>
  </nav>
  
  
  <?php
  
  	echo("<div class='container'>");
  
  	include('CommonMethods.php');
	$debug = false;
	
	$COMMON = new Common($debug);

    $date = ($_POST['date']);
	$_SESSION['date'] = $date;
	
	$advisingArray = array();
	
	$fname = ($_POST['fname']);
	$lname = ($_POST['lname']);
	$studentID = strtoupper(($_POST['studentID']));
	$major = strtoupper(($_POST['major']));
		
	if ( $fname == NULL)
	{
		$date = ($_SESSION['date']);
		$fname = ($_SESSION['fname']);
		$lname = ($_SESSION['lname']);
		$studentID = ($_SESSION['studentID']);
		$major = ($_SESSION['major']);
	}
	
	
	$_SESSION['studentID'] = $studentID;
	$_SESSION['fname'] = $fname;
	$_SESSION['lname'] = $lname;
	$_SESSION['major'] = $major;
	$_SESSION['date'] = $date;

    $sqlDate;
	
	//checks to see if student already made an appointment
	$madeAppt = "SELECT `studentID` FROM `appointments` WHERE `studentID` = '$studentID'";
	$rsIsAppt = $COMMON->executeQuery($madeAppt,$_SERVER["SCRIPT_NAME"]);
	$fetchIsAppt = mysql_fetch_row($rsIsAppt);
	
	//if student made the appointment a message is displayed detailing appt info
	if ( $fetchIsAppt != NULL)
	{
		echo("Welcome, <b>$fname $lname</b>, to the Student Advising Web Page.<br>
			You have already made an appointment with ");
			
			$getAppt = "SELECT TIME_FORMAT(`time` , '%h:%i %p'),  DATE_FORMAT(  `date` ,  '%W %b. %d, %Y' ), `advisorID` FROM `appointments` WHERE `studentID` = '$studentID'";
			$rsGetAppt = $COMMON->executeQuery($getAppt,$_SERVER["SCRIPT_NAME"]);
			$fetchGetAppt = mysql_fetch_row($rsGetAppt);
			
			$getAdvisorName = "SELECT `fname`, `lname` FROM `advisors` WHERE `advisorID` = '$fetchGetAppt[2]'";
			$rsGetAdv = $COMMON->executeQuery($getAdvisorName,$_SERVER["SCRIPT_NAME"]);
			$fetchGetAdv = mysql_fetch_row($rsGetAdv);
			
		echo("<b>$fetchGetAdv[0] $fetchGetAdv[1] on ");
		
		
		//Link to delete appt - TOBEADDED
		echo("$fetchGetAppt[1] at $fetchGetAppt[0]</b>. If you need to cancel this appointment please click the remove button below.<br> <br>");
		
		echo("<form action='removeStudent.php' method='post' name='Form2'>");
		echo("<button class='btn btn-lg btn-danger' type='submit' >Remove Appt.</button></form>");
		
		echo("<br><br>Otherwise log out by clicking menu in the top right corner and then by clicking log out. Thank you.");
	}
	
	//otherwise the main table to choose an appt is displayed
	else
	{
		
		echo("<form action='schedule.php' method='post' name='Form1'>");

		if ($date == NULL)
		  {
			$sqlDate = "2015-03-02";
		  }
		else
		  {
			$sqlDate = $date;
		  }
		  
		echo("Welcome, <b>$fname $lname</b>, to the Student Advising Web Page.<br><br>");
		
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
		
		echo("Please select an appointment by choosing a weekday between $startDay and $endDay. Switch days by using the calendar below.<br>");
	
	  	echo("<input class='date-picker' type='text' value='$sqlDate' name='date'/>");
	  
	  	echo("<button class='btn btn-sm btn-primary' type='submit' >Go</button></form><br>");
		
		if ($fetchDay[0] == NULL)
		{
			echo("<b><font color='red'>You have not chosen a day when appointments are available.</font></b><br><br> ");	
		}
		else
		{
		echo("Once you have chosen a day please select an available appointment and then click Submit to make the appointment.<br>");
		}
	  	echo("<br></div>");
	
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
	
	
			  $advisorInfo = array();
			  $advisorID = array();
			  $count = 0;
			  while($row = mysql_fetch_row($rs)){
				$advisorInfo[$count] = $row;
				$count++;
			  }
				// advisor names
				for ($i= 0; $i < $count; $i++) { 
					echo "<th class='warning'>";
					//echo advisor name
					$name = $advisorInfo[$i][2];
					$advisorID[$i] = $advisorInfo[$i][0];
					echo "<u>$name</u>";
					echo "</th>";
				}
	
				//var_dump($advisorInfo);
			
	
			echo("  </tr>
			</thead>
		
			<!--  echo advisor names in th tag here-->
			<tbody>");
		   
	
			
				// date('w',srttotime());
	
			  // time info
			  $apptTimeSql = "SELECT TIME_FORMAT(`time`, '%h:%i %p'), `time` FROM `times` WHERE 1";
			  $rs = $COMMON->executeQuery($apptTimeSql,$_SERVER["SCRIPT_NAME"]);
			  $apptTimeInfo;
			  $count = 0;
			  while($row = mysql_fetch_row($rs)){
				$apptTimeInfo[$count] = $row;
				$count++;
			  }
	
	
	
			  //var_dump($apptTimeInfo);
			  //var_dump($apptTimeInfo[1][2]);
			  
			  echo("<form class='formm-signin' action='added.php' method='post' name='Form2'>"); 
			  
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
					  $apptSlot = "SELECT COUNT(`open`) FROM `appointments` WHERE `time` = '$time' AND `date` = '$sqlDate' AND `advisorID` = '$advisorID[$i]' AND `open` = 1 AND (`major` IS NULL OR  `major` =  '$major')";
					  $rs = $COMMON->executeQuery($apptSlot,$_SERVER["SCRIPT_NAME"]);
					  $apptAvailable = mysql_fetch_row($rs);
					  
					  $outOf = "SELECT COUNT(`open`) FROM `appointments` WHERE `time` = '$time' AND `date` = '$sqlDate' AND `advisorID` = '$advisorID[$i]' AND (`major` IS NULL OR  `major` =  '$major')";
					  $rsOutOf = $COMMON->executeQuery($outOf,$_SERVER["SCRIPT_NAME"]);
					  $total = mysql_fetch_row($rsOutOf);
					  
					  $groupOrNot = "SELECT COUNT(`time`) FROM `appointments` WHERE `time` = '$time' AND `date` = '$sqlDate' AND `advisorID` = '$advisorID[$i]' AND (`major` IS NULL OR  `major` =  '$major')";
					  $rsGroup = $COMMON->executeQuery($groupOrNot,$_SERVER["SCRIPT_NAME"]);
					  $isGroup = mysql_fetch_row($rsGroup);
					  //echo "$row";
					  if($apptAvailable[0] >= 1)
					  {
						if($isGroup[0] > 1)
						{
							echo "<td class='advisorSlotOpen'><input id='$advisorID[$i]$time' type='radio' name='time' value='$advisorID[$i] $time $sqlDate' checked><label for='$advisorID[$i]$time'>Group Appt <br>Slots Open = $apptAvailable[0] of $total[0]</label></td>";
						}
						else
						{
							echo "<td class='advisorSlotOpen'><input id='$advisorID[$i]$time' type='radio' name='time' value='$advisorID[$i] $time $sqlDate' checked><label for='$advisorID[$i]$time'>Single</label></td>";
						}
					  }
					  else
					  {
						echo"<td></td>";
					  }
					  
				  }
					$rowColor++;
					echo "</tr>"; 
				}
			
	
	
			
		echo("</tbody></table><button class='btn btn-lg btn-primary' type='submit' >Sign Up For Appt.</button></form> <br><br>");
		}
	}
	  ?>
	</div>

 <!-- /container -->


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
    history.pushState(null, null, 'schedule.php');
    window.addEventListener('popstate', function(event) {
    	history.pushState(null, null, 'schedule.php');
    });
	window.onpopstate=function()
	{
	  alert("Use of the back button has been disabled, please navigate the website using the links on the page.");
	}
</script>

</body>
</html>