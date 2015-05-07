<?php

session_start();
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
  
  <div class="container">
  
  <?php
  
  	include('CommonMethods.php');
    $debug = false;

    $COMMON = new Common($debug);
  
  	$apptStuff = ($_POST['time']);
  	$date = ($_SESSION['date']);
	$fname = ($_SESSION['fname']);
	$lname = ($_SESSION['lname']);
	$studentID = ($_SESSION['studentID']);
	$major = ($_SESSION['major']);
  
  	$_SESSION['studentID'] = $studentID;
	$_SESSION['fname'] = $fname;
	$_SESSION['lname'] = $lname;
	$_SESSION['major'] = $major;
	$_SESSION['date'] = $date;
	$_SESSION['advisor'] = $advisor;
	
	$apptInfo = explode(" ", $apptStuff);
	
	$advisorID = $apptInfo[0];
	$time = $apptInfo[1];
	$advDate = $apptInfo[2];
	
	//update `appointments` table
	$sqlAddAppt = "UPDATE `appointments` SET `open` = 0 , `studentID` = '$studentID' WHERE `time` = '$time' AND `date` = '$advDate' AND `advisorID` = '$advisorID' AND `open` = 1 LIMIT 1";
	$rs1 = $COMMON->executeQuery($sqlAddAppt,$_SERVER["SCRIPT_NAME"]);
	
	//pull advisor name from `advisor` table
	$sqlAdvisorName = "SELECT `fname`, `lname` FROM `advisors` WHERE `advisorID` = '$advisorID'";
	$rs2 = $COMMON->executeQuery($sqlAdvisorName,$_SERVER["SCRIPT_NAME"]);
	$fetchAdvisorName = mysql_fetch_row($rs2);
	
	//insert student into `students` table
	$sqlAddStudent = "INSERT INTO `students`(`studentID`, `fname`, `lname`, `major`) VALUES ('$studentID','$fname','$lname','$major')";
	$rs3 = $COMMON->executeQuery($sqlAddStudent,$_SERVER["SCRIPT_NAME"]);
	
	echo("Thank you, $fname $lname, for using the Student Advising Web Page. You have successfully made an appointment with $fetchAdvisorName[0] $fetchAdvisorName[1] on ");
	
	//pull information about the appointment from `appointments`
	$getAppt = "SELECT TIME_FORMAT(`time` , '%h:%i %p'),  DATE_FORMAT(  `date` ,  '%W %b. %d, %Y' ), `advisorID` FROM `appointments` WHERE `studentID` = '$studentID'";
			$rsGetAppt = $COMMON->executeQuery($getAppt,$_SERVER["SCRIPT_NAME"]);
			$fetchGetAppt = mysql_fetch_row($rsGetAppt);

	echo("$fetchGetAppt[1] at $fetchGetAppt[0]. If you made a mistake and need to cancel this appointment please click the remove button below.<br><br>");
	
	echo("<form action='removeStudent.php' method='post' name='Form2'>");
		echo("<button class='btn btn-lg btn-danger' type='submit' >Remove Appt.</button></form>");
		
	echo("<br><br>Otherwise log out by clicking menu in the top right corner and then by clicking log out. Thank you.");
  
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
    history.pushState(null, null, 'added.php');
    window.addEventListener('popstate', function(event) {
    	history.pushState(null, null, 'added.php');
    });
	window.onpopstate=function()
	{
	  alert("Use of the back button has been disabled, please navigate the website using the links on the page.");
	}
</script>

</body>
</html>