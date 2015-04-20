<?php

session_start();
?>

<html>
<head>
    <title>UMBC Advisor Console</title>

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
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <img class="navbar-brand"  src="res/logo.png" >
                
        </div>
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Menu <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Home</a></li>
            <li><a href="MySchedule.php">My Schedule</a></li>
            <li class="divider"></li>
            <li><a href="index.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
      <div class="titleBar">
             <h2>CMEE Student Advising Web Page</h2>
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
	$apptNum = $apptInfo[1];
	
	$sqlAddAppt = "UPDATE `appointments` SET `open` = 0 , `studentID` = '$studentID' WHERE `apptNum` = 1 AND `advisorID` = '$advisorID' LIMIT 1";
	$rs1 = $COMMON->executeQuery($sqlAddAppt,$_SERVER["SCRIPT_NAME"]);
	
	$sqlAdvisorName = "SELECT `fname`, `lname` FROM `advisors` WHERE `advisorID` = '$advisorID'";
	$rs2 = $COMMON->executeQuery($sqlAdvisorName,$_SERVER["SCRIPT_NAME"]);
	$fetchAdvisorName = mysql_fetch_row($rs2);
	
	$sqlAddStudent = "INSERT INTO `students`(`studentID`, `fname`, `lname`, `major`) VALUES ('$studentID','$fname','$lname','$major')";
	$rs3 = $COMMON->executeQuery($sqlAddStudent,$_SERVER["SCRIPT_NAME"]);
	
	echo("Thank you, $fname $lname, for using the Student Advising Web Page. You have successfully made an appointment with $fetchAdvisorName[0] $fetchAdvisorName[1].");

  
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

</body>
</html>