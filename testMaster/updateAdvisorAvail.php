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
            <li><a href="advisorChangeAvail.php">Remove Availability</a></li>
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
echo("<html><head></head><body>");

$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods
//var_dump($_POST);

$advisor = ($_POST['advisor']);

$advid = 'fakekaf';

$sql = "select * from advisors";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
while($row = mysql_fetch_row($rs))
{
     $advName=$row[1] . " " . $row[2];
	 if ($advName == $advisor){
		$advid = $row[0];
	 }
}

$weekdays = array(
	0 => -1,
	1 => -1,
	2 => -1,
	3 => -1,
	4 => -1,
	5 => -1,
);
if (isset($_POST['mon'])) {
	$weekdays[1]=1;
}
if (isset($_POST['tue'])) {
	$weekdays[2]=2;
}
if (isset($_POST['wed'])) {
	$weekdays[3]=3;
}
if (isset($_POST['thr'])) {
	$weekdays[4]=4;
}
if (isset($_POST['fri'])) {
	$weekdays[5]=5;
}

$sdate = date(($_POST['startdate']));
$cdate = $sdate;
$edate = date(($_POST['enddate']));

//if they only picked a single day in the range 
//ignore them not checking the day of week boxes
if($sdate==$edate){
	$i=0;
	while($i<6){
		$weekdays[$i]=$i;
		$i++;
	}
}
	
//if dates are out of order, switch them
if($sdate>$edate){
	$cdate=$sdate;
	$sdate=$edate;
	$edate=$cdate;
}

$usrErr="<p>Advisor Availability Updated</p>";
$weekdaySum=0;
$i=0;
while($i<6){
	$weekdaySum=$weekdaySum + $weekdays[$i];
	$i++;
}
if($weekdaySum==-6){
	$usrErr="<p>Please go back and select what days of the week you wish to add availability for<p>";
}

$rowsPerDay= ($_POST['slotsPerDay']);
$arrayOfChanges=array();
$i=0;
while($i<$rowsPerDay){
	$arrayOfChanges[$i]=array();
	$i++;
}
$i=0;
while($i<$rowsPerDay){
	$arrayOfChanges[$i][0]=($_POST['time'][$i]);
	$arrayOfChanges[$i][1]=($_POST['cap'][$i]);
	$arrayOfChanges[$i][2]=($_POST['major'][$i]);
	$i++;
}

$arrayOfDates=array();
$sql_dates = "SELECT * FROM `dates` WHERE `date` BETWEEN '$sdate' AND '$edate'";
$rs_dates = $COMMON->executeQuery($sql_dates, $_SERVER["SCRIPT_NAME"]);
$numOfGoodDates=0;
while($row_dates = mysql_fetch_row($rs_dates)){
	$j=1;	
		while ($j<6){
			if ($weekdays[$j]==(date("w", strtotime($row_dates[0])))){
				$arrayOfDates[$numOfGoodDates]=$row_dates[0];
				$numOfGoodDates++;
			}
			$j++;
		}
}
	
$i=0;
while($i<$numOfGoodDates){
	$j=0;
	$cdate=$arrayOfDates[$i];
	while($j<$rowsPerDay){
		$ctime = $arrayOfChanges[$j][0];
		$ccap = $arrayOfChanges[$j][1];
		$cmaj = $arrayOfChanges[$j][2];
		$sql = "SELECT * FROM `appointments` WHERE `date` = '$cdate' AND `time` = '$ctime' AND `advisorID` = '$advid'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$oldcount=0;
		$badMajor=0;
		while($row = mysql_fetch_row($rs)){
			$oldcount++;
			if((isset($row[5]))&&($row[5]!=$cmaj)&&($badMajor!=1)){
				$usrErr .= "<p>You tried to change the major of the appointment on ".$cdate." at ".$ctime." from ".$row[5]." to ".$cmaj." , please use the modify page to do that<p>";
				$badMajor=1;
			}
		}
		if(($oldcount>$ccap)&&($ccap>0)){
			$usrErr=$usrErr."<p>You tried to lower the capacity of the appointment on ".$cdate." at ".$ctime." from ".$oldcount." to ".$ccap." , please use the modify page to do that<p>";
		}
		while(($oldcount<$ccap)&&($badMajor!=1)){
			if($cmaj == "any"){
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `open`) 
						VALUES ('$cdate', '$ctime', '$advid', 1);";
			}
			else{
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$cdate', '$ctime', '$advid', '$cmaj', 1);";
			}
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$oldcount++;
		}
		$j++;
	}
	$i++;
}


echo($usrErr);
echo("<form action='advisorSetAvail.php' method='post' name='advAvail'>");
echo("<button class='btn btn-sm btn-primary' type='submit' >Set More Availabilities</button>");
echo("</form>");


echo("<form action='advisorHome.php' method='post' name='advAvail'>");
echo("<button class='btn btn-sm btn-primary' type='submit' >Back To Advisor Home</button>");
echo("</form>");
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
    history.pushState(null, null, 'updateAdvisorAvail.php');
    window.addEventListener('popstate', function(event) {
    	history.pushState(null, null, 'updateAdvisorAvail.php');
    });
	window.onpopstate=function()
	{
	  alert("Use of the back button has been disabled, please navigate the website using the links on the page.");
	}
</script>

</body>
</html>