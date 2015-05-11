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

<div class="container">
<div class="tableBar">








<?php

echo("<html><head><title></title>Edit Appointments For:</head><body>");

$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods

if(isset($_POST['advisor'])){
	//keeping these to make the name and dates sticky when page redrawn when view button hit
	$stickStartDate = ($_POST['startdate']);
	$stickEndDate = ($_POST['enddate']);
	$stickAdvName = ($_POST['advisor']);
}

$advName;
$advFullName;
$advFName;
$advLName;
$space=' ';
$maj;
$num=0;

$Tsql = "SELECT time_format(`time`,'%h:%i %p'), `time` FROM `times` WHERE 1;";
$Trs = $COMMON->executeQuery($Tsql, $_SERVER["SCRIPT_NAME"]);
$array = array();
$count = 0;
while ($trow = mysql_fetch_row($Trs)){
	$array[$count]=$trow;
	$count++;
}

echo("<form action='advisorChangeAvail.php' method='post' name='form1'>");
echo("<select name='advisor'>");

$sql = "select fName, lName from advisors";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
while($row = mysql_fetch_row($rs))
{
     $advFullName=$row[0].$space.$row[1];
     $advName=$row[0] . " " . $row[1];
	 if($stickAdvName == $advName){
		echo("<option value='");
		echo("$advName' selected");
	}
	else{
		echo("<option value='");
		echo("$advName'");
	}
     echo(">" . $advName . "</option>");
}
echo("</select>");
echo("<br>");
echo(" Between: ");
$sql = "select date from dates";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
echo("<select name='startdate'>");
while($row = mysql_fetch_row($rs)){
	if($stickStartDate == $row[0]){
		echo("<option value='");
		echo("$row[0]' selected");
	}
	else{
		echo("<option value='");
		echo("$row[0]'");
	}
	echo(">" . $row[0] . "</option>");
}
echo("</select>");
echo(" And: ");
$sql = "select date from dates";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
echo("<select name='enddate'>");
while($row = mysql_fetch_row($rs)){
	if($stickEndDate == $row[0]){
		echo("<option value='");
		echo("$row[0]' selected");
	}
	else{
		echo("<option value='");
		echo("$row[0]'");
	}
	echo(">" . $row[0] . "</option>");
}
echo("</select>");
echo("<button class='btn btn-sm btn-primary' type='submit' >View</button>");
echo("</form>");



if(isset($_POST['advisor'])){
	//echo("<br><br>dump<br><br>");
	//var_dump($_POST);
	//echo("<br><br>end dump<br><br>");

	$startingDate = ($_POST['startdate']);
	$endingDate = ($_POST['enddate']);
	if($startingDate > $endingDate){
		$temp = $startingDate;
		$startingDate = $endingDate;
		$endingDate = $temp;
	}

	$advisorFullName = ($_POST['advisor']);
	$advisorIdNumber;
	$sql = "select * from advisors";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	while($row = mysql_fetch_row($rs))
	{
		$advName=$row[1] . " " . $row[2];
		if ($advName == $advisorFullName){
			$advisorIdNumber = $row[0];
		}	
	}
	$currentDate;
	$currentTime;
	$currentCapacity;
	$currentMajor;
	$currentStudents = array();
	$majorsArry = array();
	$sql_dates = "SELECT * FROM `dates` WHERE `date` BETWEEN '$startingDate' AND '$endingDate'";
	//$sql_dates = "select * from dates where date between $startingDate and $endingDate;";
	$rs_dates = $COMMON->executeQuery($sql_dates, $_SERVER["SCRIPT_NAME"]);

	echo("<form action='modifyAdvisorAvail.php' method='post' name='form2'>");
	$num=0;
	while($row_dates = mysql_fetch_row($rs_dates)){
		$currentDate = $row_dates[0];
		echo("current appointments for " . $advisorFullName . " on " . $currentDate . " ");
		echo("<table width='100%'><tr><th>Start Time</th><th>Set Capacity</th><th>Major</th></tr>");
		$sql_times = "select * from times where 1;";
		$rs_times = $COMMON->executeQuery($sql_times, $_SERVER["SCRIPT_NAME"]);
		while($row_times = mysql_fetch_row($rs_times)){
			$currentTime = $row_times[0];
			echo("<tr>");
			echo("<td>".$currentTime."</td>");
			echo("<input type='hidden' name='date[$num]' value='$currentDate'>");
			echo("<input type='hidden' name='time[$num]' value='$currentTime'>");
			//SELECT *FROM `appointments`WHERE `date` = '2015-04-20'AND `time` = '08:00:00'AND `advisorID` = 'AA12345'
			//$sql_capacity = "SELECT COUNT(*) as foo FROM `appointments` WHERE `date` = '$currentDate' AND `time` = '$currentTime' AND `advisorID` = '$advisorIdNumber'";
			//$sql_capacity = "select count(`key`) from `appointments` where `date` = $currentDate and `time` = $currentTime and `advisorID` = $advisorIdNumber";
			$sql_capacity = "SELECT * FROM `appointments` WHERE `date` = '$currentDate' AND `time` = '$currentTime' AND `advisorID` = '$advisorIdNumber'";
			$rs_capacity = $COMMON->executeQuery($sql_capacity, $_SERVER["SCRIPT_NAME"]);
			$currentCapacity=0;
			$currentMajor=NULL;
			while($row_capacity = mysql_fetch_row($rs_capacity)){
				$currentStudents[$currentCapacity]=$row_capacity[3];
				$currentMajor=$row_capacity[5];
				$currentCapacity++;
			}
			echo("<td>");
			echo("<select name='cap[$num]'>");
			$i=0;
			while($i<11){
				if($i == $currentCapacity){
					echo("<option value='");
					echo("$i' selected");
				}
				else{
					echo("<option value='");
					echo("$i'");
				}
				if($i == 0){
					echo(">" . $i . " / NOT SET</option>");
				}
				else if($i == 1){
					echo(">" . $i . " - Single Appt.</option>");
				}
				else{
					echo(">" . $i . " - Group Appt.</option>");	
				}
				$i=$i+1;
			}
			echo("</select>");
			echo("</td><td>");
			
			$sql_majors = "SELECT * FROM `majors`";
			$rs_majors = $COMMON->executeQuery($sql_majors, $_SERVER["SCRIPT_NAME"]);
			echo("<select name='major[$num]'><option value=any>any</option>");
			while($row_maj = mysql_fetch_row($rs_majors)){
				$maj=$row_maj[0];
				if($maj == $currentMajor){
					echo("<option value='");
					echo("$maj' selected");
					echo(">" . $maj . "</option>");
				}
				else{
					echo("<option value='");
					echo("$maj'");
					echo(">" . $maj . "</option>");
				}
			}
			echo("</select>");
			echo("</td></tr>");
			
			
			$num++;
		}//end time
		echo("</table>");
	}//end date
	
echo("<input type='hidden' name='startdate' value='$startingDate'>");
echo("<input type='hidden' name='enddate' value='$endingDate'>");
echo("<input type='hidden' name='advisorID' value='$advisorIdNumber'>");
echo("<input type='hidden' name='numOfUpdates' value='$num'>");

echo("<button class='btn btn-m btn-warning' type='submit' >Update Availability</button>");
echo("</form>");
}//endif

echo("-OR-<br><br>");
echo("<form action='advisorHome.php' method='post' name='form3'>");
echo("<button class='btn btn-m btn-primary' type='submit' >Make No Changes</button>");
echo("</form>")

?>

</div>
</div>

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
    history.pushState(null, null, 'advisorChangeAvail.php');
    window.addEventListener('popstate', function(event) {
    	history.pushState(null, null, 'advisorChangeAvail.php');
    });
	window.onpopstate=function()
	{
	  alert("Use of the back button has been disabled, please navigate the website using the links on the page.");
	}
</script>

</body>
</html>