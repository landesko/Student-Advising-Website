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
            <li><a href="advisorSetAvail.php">Set Availability</a></li>
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
	 //echo("<br><br>advisor: " . $advisor . " =? " . $advName);
	 if ($advName == $advisor){
	 //echo("<br>yup");
		$advid = $row[0];
	 }
}

//echo("<br><br> advid: " . $advid . "<br><br>");













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

//echo("<br>");


$cap = array(
	0 => ($_POST['cap0']),
	1 => ($_POST['cap1']),
	2 => ($_POST['cap2']),
	3 => ($_POST['cap3']),
	4 => ($_POST['cap4']),
	5 => ($_POST['cap5']),
	6 => ($_POST['cap6']),
	7 => ($_POST['cap7']),
	8 => ($_POST['cap8']),
	9 => ($_POST['cap9']),
	10 => ($_POST['cap10']),
	11 => ($_POST['cap11']),
	12 => ($_POST['cap12']),
	13 => ($_POST['cap13']),
	14 => ($_POST['cap14']),
	15 => ($_POST['cap15']),
);
$majorArray = array(
	0 => ($_POST['major0']),
	1 => ($_POST['major1']),
	2 => ($_POST['major2']),
	3 => ($_POST['major3']),
	4 => ($_POST['major4']),
	5 => ($_POST['major5']),
	6 => ($_POST['major6']),
	7 => ($_POST['major7']),
	8 => ($_POST['major8']),
	9 => ($_POST['major9']),
	10 => ($_POST['major10']),
	11 => ($_POST['major11']),
	12 => ($_POST['major12']),
	13 => ($_POST['major13']),
	14 => ($_POST['major14']),
	15 => ($_POST['major15']),
);

$Tsql = "SELECT time_format(`time`,'%h:%i %p'), `time` FROM `times` WHERE 1;";
$Trs = $COMMON->executeQuery($Tsql, $_SERVER["SCRIPT_NAME"]);

$timearray = array();

$count = 0;

while ($trow = mysql_fetch_row($Trs)){
	$timearray[$count]=$trow;
	$count++;
}


//$timearry = array(
//	0 => '09:00:00',
//	1 => '09:30:00',
//	2 => "10:00:00",
//	3 => "10:30:00",
//	4 => "11:00:00",
//	5 => "11:30:00",
//	6 => "12:00:00",
//	7 => "12:30:00",
//	8 => "13:00:00",
//	9 => "13:30:00",
//	10 => "14:00:00",
//	11 => "14:30:00",
//	12 => "15:00:00",
//	13 => "15:30:00",	
//);

while($cdate < $edate){
//echo("<br>cdate: ");
//echo($cdate);
		$j=1;	
		while ($j<6){//check each weekdat
			//echo("   <br> weekdays: ");
			//echo($weekdays[$j]);
			//echo(" =? ");
			//echo((date("w", strtotime($cdate))));
			if ($weekdays[$j]==(date("w", strtotime($cdate)))){
				//echo("      yup");
				$k=0;
				while($k<16){
					//echo("      date: ");
					//echo($cdate);
					//echo(" k: ");
					//echo($k);
					//echo(" time: ");
					//echo($timearry[$k][0]);
					//echo(" faketime: ");
					//echo($timearry[$k][1]);
					//echo("<br>");
					//$sql = "SELECT * FROM `apptTimes` WHERE `date` = '$cdate' AND `time` = `$timearry[$k]`";
					//$sql = "SELECT * FROM `apptTimes` WHERE `date` = '$cdate' AND `time` = '$timearry[$k]'";
					//$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					//$row = mysql_fetch_row($rs);
					//$aptnum = $row[0];
					
					$z=$cap[$k];
					while ($z>0){
						//$sql = "INSERT INTO `dale2`.`appointments` (`apptNum`, `studentID`, `advisorID`) VALUES ('$aptnum', NULL, '$advid');";
						$theTIME = $timearray[$k][1];
						if($majorArray[$k]=='any'){
						$sql = "INSERT INTO `dale2`.`appointments` (`date`, `time`, `advisorID`, `open`) 
						VALUES ('$cdate', '$theTIME', '$advid', 1);";
						}
						else{
						$sql = "INSERT INTO `dale2`.`appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$cdate', '$theTIME', '$advid', '$majorArray[$k]', 1);";
						}
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
						$z=$z-1;
					}
					$k=$k+1;
				}
			}
			$j=$j+1;
		}
	$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
}








echo("<p>Advisor Availability Updated</p>");
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

</body>
</html>