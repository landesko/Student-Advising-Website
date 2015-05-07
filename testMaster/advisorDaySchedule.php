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
    
  <style>
  .whiteBG
  {
	background: white;  
  }
  </style>
  
    
   
</head>


<body class="whiteBG">

<div class="container">
<?php

$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods

var_dump(($_POST['advName']));

$scheduleInfo = explode(" ", ($_POST['advName']));

$advName = $scheduleInfo[0]. " " .$scheduleInfo[1] ;
$theDate = $scheduleInfo[2];

echo("<br><br>");
echo("$advName<br>");
echo("$theDate");//2015-3-11
$curDay=$theDate;


$sql = "SELECT * FROM `advisors` WHERE `fname` = '$scheduleInfo[0]' AND `lname` = '$scheduleInfo[1]'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
echo("<div class='container'>");//
while($row = mysql_fetch_row($rs)){
	$advisor=$row[1] . " " . $row[2];
	$advID=$row[0];
	$i=0;
	$curDay = $theDate;
	//echo("<div class='container'>");//
	while($i < 1){
		$emptytable=1;
		echo("<br>".$advisor." on ".$curDay);
		echo("<table width='100%'>");
		echo("<th>Time</th><th>Name</th><th>Student ID</th><th>Major</th>");
			//$sql = "SELECT * FROM `apptTimes` WHERE `date` = '$curDay'";
			//$rs1 = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			//while($row1 = mysql_fetch_row($rs1))
			//{			
				//$apptID=$row1[0];
				
				$sql = "SELECT * FROM `appointments` WHERE `date` = '$curDay' AND `advisorID` = '$advID' ORDER BY `time` ASC";
				$rs2 = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);										
				while($row2 = mysql_fetch_row($rs2)){
					//empty table check
					$emptytable=0;
					
					$sql = "SELECT * FROM `students` WHERE `studentID` = '$row2[3]' ";
					$rs3 = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					$row3 = mysql_fetch_row($rs3);
				

					$stuID=$row3[0];
					$stuMaj = $row3[3];
					$stuName=$row3[1] . " " . $row3[2];
					if ($row2[3]==null){
						$stuName="No Student";
						$stuID="867-5309";
						$rowColor++;
						if (isset($row2[5])){
							$stuMaj="open to ".$row2[5]." students";
						}
						else{
							$stuMaj="open to any tech student";
						}
					}
					if($lasttime == $row2[2]){
						$thistime = " ";
					}
					else{
						$thistime = $row2[2];
						$lasttime = $row2[2];
					}
					
					
					echo("<tr>");
					echo("<td>");
					echo($thistime);
					echo("</td><td>");				
					echo($stuName);
					echo("</td><td>");
					echo($stuID);
					echo("</td><td>");
					echo($stuMaj);
					echo("</tr>");						
				}
				
			//}
			$curDay = date('Y-m-d', strtotime($curDay . ' + 1 day'));
			$i=$i+1;
			$lasttime=7;
			
			if($emptytable==1){
				echo("<tr>");
				echo("<td>");
				echo("No");
				echo("</td><td>");
				echo("Student");
				echo("</td><td>");			
				echo("Appointment");
				echo("</td><td>");
				echo("Today");
				echo("</tr>");						
			}
			
			echo("</table>");
	}
}
	
echo("<div class='no-print'>");
echo("<br><br><button class='btn btn-m btn-warning' type='button' onclick='windowClose()' >Close This Window</button>");
echo("</div>");
	
?>
</div>
</body>

<script type="text/javascript">
    window.print();
</script>

<script language="javascript" type="text/javascript"> 
function windowClose() { 
window.open('','_parent',''); 
window.close();
} 
</script>

<script type = "text/javascript" >
    history.pushState(null, null, 'advisorDaySchedule.php');
    window.addEventListener('popstate', function(event) {
    	history.pushState(null, null, 'advisorDaySchedule.php');
    });
	window.onpopstate=function()
	{
	  alert("Use of the back button has been disabled, please navigate the website using the links on the page.");
	}
</script>