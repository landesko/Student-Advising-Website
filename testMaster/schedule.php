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
	$studentID = ($_POST['studentID']);
	$major = ($_POST['major']);
		
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
	
	$madeAppt = "SELECT `studentID` FROM `appointments` WHERE `studentID` = '$studentID'";
	$rsIsAppt = $COMMON->executeQuery($madeAppt,$_SERVER["SCRIPT_NAME"]);
	$fetchIsAppt = mysql_fetch_row($rsIsAppt);
	
	if ( $fetchIsAppt != NULL)
	{
		echo("Welcome, $fname $lname, to the Student Advising Web Page.<br>
			You have already made an appointment with ");
			
			$getAppt = "SELECT `apptNum`, `advisorID` FROM `appointments` WHERE `studentID` = '$studentID'";
			$rsGetAppt = $COMMON->executeQuery($getAppt,$_SERVER["SCRIPT_NAME"]);
			$fetchGetAppt = mysql_fetch_row($rsGetAppt);
			
			$getAdvisorName = "SELECT `fname`, `lname` FROM `advisors` WHERE `advisorID` = '$fetchGetAppt[1]'";
			$rsGetAdv = $COMMON->executeQuery($getAdvisorName,$_SERVER["SCRIPT_NAME"]);
			$fetchGetAdv = mysql_fetch_row($rsGetAdv);
			
		echo("$fetchGetAdv[0] $fetchGetAdv[1] on ");
		
			$getApptTime = "SELECT TIME_FORMAT(`time` , '%h:%i %p'),  DATE_FORMAT(  `date` ,  '%W %b. %d, %Y' ) FROM `apptTimes` WHERE `apptNum` = $fetchGetAppt[0]";
			//var_dump($getApptTime);
			$rsGetApptTime = $COMMON->executeQuery($getApptTime,$_SERVER["SCRIPT_NAME"]);
			$fetchGetApptTime = mysql_fetch_row($rsGetApptTime);
		
		echo("$fetchGetApptTime[1] at $fetchGetApptTime[0]. If you need to cancel this appointment please click here.");
	}
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
		  
		echo("Welcome, $fname $lname, to the Student Advising Web Page.<br><br>");
	
	  	echo("<input class='date-picker' type='text' value='$sqlDate' name='date'/>");
	  
	  	echo("<button class='btn btn-sm btn-primary' type='submit' >Go</button></form>");
	  	echo("<br></div>");
	
	
		 //<!--Sign In-->
	  	echo("<div class='container'>
		<table class='table' border='1'>
	   
		<thead>
		  <tr>
			<th class='warning'>Time</th>");
	
		//echo advisor names in th tag here
				
			  $advisorSql = "SELECT * FROM `advisors` WHERE 1";
			  $rs = $COMMON->executeQuery($advisorSql,$_SERVER["SCRIPT_NAME"]);
	
	
			  $advisorInfo;
			  $advisorID;
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
					echo "$name";
					echo "</th>";
				}
	
				//var_dump($advisorInfo);
			
	
			echo("  </tr>
			</thead>
		
			<!--  echo advisor names in th tag here-->
			<tbody>");
		   
	
			
				// date('w',srttotime());
	
			  // time info
			  $apptTimeSql = "SELECT `apptNum`,`date`,TIME_FORMAT(`time`, '%h:%i %p') FROM `apptTimes` WHERE `date` = '$sqlDate'";
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
				  echo "<td>$timeInfo[2]</td>";
	
					// get appt info
				  $apptNum = $timeInfo[0];
				  
				  for($i = 0; $i<count($advisorID); $i++)
				  {
					  $apptSlot = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum' AND `advisorID` = '$advisorID[$i]' AND `open` = 1 AND (`major` IS NULL OR  `major` =  '$major')";
					  $rs = $COMMON->executeQuery($apptSlot,$_SERVER["SCRIPT_NAME"]);
					  $apptAvailable = mysql_fetch_row($rs);
					  
					  $groupOrNot = "SELECT COUNT(`apptNum`) FROM `appointments` WHERE `apptNum` = '$apptNum' AND `advisorID` = '$advisorID[$i]' AND (`major` IS NULL OR  `major` =  '$major')";
					  $rs = $COMMON->executeQuery($apptSlot,$_SERVER["SCRIPT_NAME"]);
					  $isGroup = mysql_fetch_row($rs);
					  //echo "$row";
					  if($apptAvailable[0] >= 1)
					  {
						if($isGroup[0] > 1)
						{
							echo "<td class='advisorSlotOpen'><input id='$advisorID[$i]' type='radio' name='time' value='$advisorID[$i] $apptNum' checked><label for='$advisorID[$i]'>Group - $apptAvailable[0]</label></td>";
						}
						else
						{
							echo "<td class='advisorSlotOpen'><input id='$advisorID[$i]' type='radio' name='time' value='$advisorID[$i] $apptNum' checked><label for='$advisorID[$i]'>Single - Open</label></td>";
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
			
	
	
			
		echo("</tbody></table><button class='btn btn-lg btn-primary' type='submit' >Submit</button></form> <br><br>");
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

</body>
</html>