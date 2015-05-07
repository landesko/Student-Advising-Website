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

$debug = true;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods
//var_dump($_POST);
$cancelledStudents = array();
$numOfScrewedStudents=0;//hah!

$advisorIdNumber= ($_POST['advisorID']);
$rowsToProcess= ($_POST['numOfUpdates']);

$arrayOfChanges=array();

$i=0;
while($i<$rowsToProcess){
	$arrayOfChanges[$i]=array();
	$i++;
}
$i=0;
while($i<$rowsToProcess){
	$arrayOfChanges[$i][0]=($_POST['date'][$i]);
	$arrayOfChanges[$i][1]=($_POST['time'][$i]);
	$arrayOfChanges[$i][2]=($_POST['cap'][$i]);
	$arrayOfChanges[$i][3]=($_POST['major'][$i]);
	$i++;
}
$i=0;
while($i<$rowsToProcess){
	$tdate = $arrayOfChanges[$i][0];
	$ttime = $arrayOfChanges[$i][1];
	$tcap = $arrayOfChanges[$i][2];
	$tmaj = $arrayOfChanges[$i][3];
	
	$sql_capacity = "SELECT * FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
	$rs_capacity = $COMMON->executeQuery($sql_capacity, $_SERVER["SCRIPT_NAME"]);
	$currentCapacity=0;
	$currentMajor=NULL;
	while($row_capacity = mysql_fetch_row($rs_capacity)){
		$currentStudents[$currentCapacity]=$row_capacity[3];
		$currentMajor=$row_capacity[5];
		$currentCapacity++;
	}
	
	if($tcap > $currentCapacity){
		if($tmaj == $currentMajor){
			//cap went up, major didn't change
			$x=0;
			//make appts
			while($x<($tcap-$currentCapacity)){
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$tmaj', 1);";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$x++;
			}
		}//end major no change
		else if($tmaj == "any"){
			//cap went up, major got less restrictive
			//change existing majors to any (null)
			
			//can't seem to set null, end up with text word null
			//$sql = "UPDATE `appointments` SET `major`= NULL WHERE `date`=`$tdate` AND `time`=`$ttime` AND `adcisorID`=`$advisorIdNumber`;";
			//$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			
			//get all of these apointments
			$sql_SAVE = "SELECT * FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_SAVE = $COMMON->executeQuery($sql_SAVE, $_SERVER["SCRIPT_NAME"]);
			
			//delete them
			$sql_DELETE = "DELETE FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_DELETE = $COMMON->executeQuery($sql_DEKETE, $_SERVER["SCRIPT_NAME"]);
			
			//put them back with "Any" (null) major
			while($row = mysql_fetch_row($rs_SAVE)){
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `open`) 
						VALUES ('$row[1]', '$row[2]', '$row[4]', 1);";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			}
			
			//finaly add the new ones
			$x=0;
			while($x<($tcap-$currentCapacity)){
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$tmaj', 1);";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$x++;
			}
		}//end major less strict
		else{
			//cap went up, major got more restrictive
			
			$x=0;
			//get all of these apointments
			$sql_SAVE = "SELECT * FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_SAVE = $COMMON->executeQuery($sql_SAVE, $_SERVER["SCRIPT_NAME"]);
			
			//delete them
			$sql_DELETE = "DELETE FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_DELETE = $COMMON->executeQuery($sql_DEKETE, $_SERVER["SCRIPT_NAME"]);
			
			//put back the ones that fit
			while($row = mysql_fetch_row($rs_SAVE)){
				if(isset($row[3])){//this apointment is taken
					$thisStudentsMajor = "SELECT `major` FROM `students` WHERE `studentID` = '$row[3]';";
					if($tmaj == $thisStudentsMajor){//student still fits
						$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$tmaj', 1);";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					}
					else{//student out in the cold
						$x--;//we lost a student, so need one more blank appt
						$cancelledStudents[$numOfScrewedStudents]=$row;//email these guys
						$numOfScrewedStudents++;
					}
				}
			}
			
			//finaly add the new ones
			while($x<($tcap-$currentCapacity)){
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$tmaj', 1);";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$x++;
			}
		}//end major more strict
	}//end cap increased
	else if($tcap == $currentCapacity){
		//cap the same
		if($tmaj == $currentMajor){
			//do nothing
		}//end major no change
		else if($tmaj == "any"){
			//also do nothing
		}//end major less strict
		else{
			$x=0;
			//get all of these apointments
			$sql_SAVE = "SELECT * FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_SAVE = $COMMON->executeQuery($sql_SAVE, $_SERVER["SCRIPT_NAME"]);
			//delete them
			$sql_DELETE = "DELETE FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_DELETE = $COMMON->executeQuery($sql_DEKETE, $_SERVER["SCRIPT_NAME"]);
			//put back the ones that fit
			while($row = mysql_fetch_row($rs_SAVE)){
				if(isset($row[3])){//this apointment is taken
					$thisStudentsMajor = "SELECT `major` FROM `students` WHERE `studentID` = '$row[3]';";
					if($tmaj == $thisStudentsMajor){//student still fits
						$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$tmaj', 1);";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					}
					else{//student out in the cold
						$x--;//we lost a student, so need one more blank appt
						$cancelledStudents[$numOfScrewedStudents]=$row;//email these guys
						$numOfScrewedStudents++;
					}
				}
			}
			//make empty appts in place of anyone we kicked out
			while($x<0){
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$tmaj', 1);";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$x++;
			}
		}//end major more strict
	}//end cap same
	else{//cap went down
		if($tmaj == $currentMajor){
			//cap went down, major didn't change
			$x=$tcap;
			//get all of these apointments
			$sql_SAVE = "SELECT * FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_SAVE = $COMMON->executeQuery($sql_SAVE, $_SERVER["SCRIPT_NAME"]);
			//delete them
			$sql_DELETE = "DELETE FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_DELETE = $COMMON->executeQuery($sql_DEKETE, $_SERVER["SCRIPT_NAME"]);
			//put back the ones that fit
			while($row = mysql_fetch_row($rs_SAVE)){
				if((isset($row[3]))&&($x>0)){//this apointment is taken AND there's room for this guy
					$thisStudentsMajor = "SELECT `major` FROM `students` WHERE `studentID` = '$row[3]';";
					if($tmaj == $thisStudentsMajor){//student still fits, unneeded
						$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `studentID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$row[3]', '$tmaj', 1);";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
						$x++;
					}
					else{//student out in the cold
						$cancelledStudents[$numOfScrewedStudents]=$row;//email these guys
						$numOfScrewedStudents++;
					}
				}
			}
			while($x>0){
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$tmaj', 1);";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$x++;
			}
		}//end major no change
		else if($tmaj == "any"){
			$x=$tcap;
			//get all of these apointments
			$sql_SAVE = "SELECT * FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_SAVE = $COMMON->executeQuery($sql_SAVE, $_SERVER["SCRIPT_NAME"]);
			//delete them
			$sql_DELETE = "DELETE FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_DELETE = $COMMON->executeQuery($sql_DEKETE, $_SERVER["SCRIPT_NAME"]);
			//put back the ones that fit
			while($row = mysql_fetch_row($rs_SAVE)){
				if((isset($row[3]))&&($x>0)){//this apointment is taken AND there's room for this guy
					$thisStudentsMajor = "SELECT `major` FROM `students` WHERE `studentID` = '$row[3]';";
					if($tmaj == $thisStudentsMajor){//student still fits, unneeded
						$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `studentID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$row[3]', '$tmaj', 1);";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
						$x++;
					}
					else{//student out in the cold
						$cancelledStudents[$numOfScrewedStudents]=$row;//email these guys
						$numOfScrewedStudents++;
					}
				}
			}
			while($x>0){
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$tmaj', 1);";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$x++;
			}
		}//end major less strict
		else{
			$x=$tcap;
			//get all of these apointments
			$sql_SAVE = "SELECT * FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_SAVE = $COMMON->executeQuery($sql_SAVE, $_SERVER["SCRIPT_NAME"]);
			//delete them
			$sql_DELETE = "DELETE FROM `appointments` WHERE `date` = '$tdate' AND `time` = '$ttime' AND `advisorID` = '$advisorIdNumber'";
			$rs_DELETE = $COMMON->executeQuery($sql_DEKETE, $_SERVER["SCRIPT_NAME"]);
			//put back the ones that fit
			while($row = mysql_fetch_row($rs_SAVE)){
				if((isset($row[3]))&&($x>0)){//this apointment is taken AND there's room for this guy
					$thisStudentsMajor = "SELECT `major` FROM `students` WHERE `studentID` = '$row[3]';";
					if($tmaj == $thisStudentsMajor){//student still fits, unneeded
						$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `studentID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$row[3]', '$tmaj', 1);";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
						$x++;
					}
					else{//student out in the cold
						$cancelledStudents[$numOfScrewedStudents]=$row;//email these guys
						$numOfScrewedStudents++;
					}
				}
			}
			while($x>0){
				$sql = "INSERT INTO `appointments` (`date`, `time`, `advisorID`, `major`, `open`) 
						VALUES ('$tdate', '$ttime', '$advisorIdNumber', '$tmaj', 1);";
						$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$x++;
			}
			}//end major more strict
	}//end cap down
//////////////////
	$i++;
}

//$cancelledStudents = array();
//$numOfScrewedStudents=0;//hah!


echo("<p>Advisor Availability Updated</p>");
echo("<form action='advisorChangeAvail.php' method='post' name='advAvail'>");
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