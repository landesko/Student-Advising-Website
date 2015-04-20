<?php
echo("<html><head><title></title>Appointments:</head><body>");

$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods

$advisor = ($_POST['advisor']);
$advID;
$stuID;

$thisMonday = date('2015-04-20');;
//while(date('w', $thisMonday)>1){
//$thisMonday = date('Y-m-d', strtotime($thisMonday . ' - 1 day'));
//}
$thisFriday = $thisMonday;
for($i=0;$i<6;$i++){
	$thisFriday = date('Y-m-d', strtotime($thisFriday . ' + 1 day'));
}
$curDay = $thisMonday;

	
$sql = "SELECT * FROM `advisors`";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
while($row = mysql_fetch_row($rs)){
	$advName=$row[1] . " " . $row[2];
	if($advName == $advisor){
		$advID=$row[0];
	}
}

if($advisor == "all"){
	$sql = "SELECT * FROM `advisors`";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	while($row = mysql_fetch_row($rs)){

	}
}
else{
	$i=0;
	while($i < 5){
		$emptytable=1;
		echo("<br>".$advisor." on ".$curDay);
		echo("<table>");
		echo("<th>Time</th><th>Name</th><th>Major</th>");
			$sql = "SELECT * FROM `apptTimes` WHERE `date` = '$curDay'";
			$rs1 = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			while($row1 = mysql_fetch_row($rs1))
			{			
				$apptID=$row1[0];
				
				$sql = "SELECT * FROM `appointments` WHERE `apptNum` = '$apptID' AND `advisorID` = '$advID'";
				$rs2 = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);										
				while($row2 = mysql_fetch_row($rs2)){
					//empty table check
					$emptytable=0;
					
					$sql = "SELECT * FROM `students` WHERE `studentID` = '$row2[1]' ";
					$rs3 = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					$row3 = mysql_fetch_row($rs3);
				
					$stuName=$row3[1] . " " . $row3[2];
					if ($row2[1]==null){
						$stuName="No Student";
					}
					echo("<tr>");
					echo("<td>");
					echo($row1[2]);
					echo("</td><td>");				
					echo($stuName);
					echo("</td><td>");
					//echo($row3[4]);
					echo($row3[3]);
					echo("</tr>");						
				}
				
			}
			$curDay = date('Y-m-d', strtotime($curDay . ' + 1 day'));
			$i=$i+1;
			
			if($emptytable==1){
				echo("<tr>");
				echo("<td>");
				echo("NO");
				echo("</td><td>");				
				echo("appt");
				echo("</td><td>");
				echo("today");
				echo("</tr>");						
			}
			
			echo("</table>");
	}
}
	
?>