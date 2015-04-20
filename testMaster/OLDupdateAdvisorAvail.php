<?php
echo("<html><head></head><body>");

$debug = true;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods

var_dump($_POST);

$advisor = ($_POST['advisor']);
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

echo("<br>");
echo("weekdays[1] ");
echo("<br>");
echo($weekdays[1]);
echo("<br>");
echo("cdate");
echo("<br>");
echo($cdate);
echo("<br>");
echo("(date('N', $cdate))");
echo("<br>");
$foo = (date('N', $cdate));
echo($foo);
echo("<br>");

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
);
$major = array(
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
);
$timearry = array(
	0 => '09:00',
	1 => '09:30',
	2 => "10:00",
	3 => "10:30",
	4 => "11:00",
	5 => "11:30",
	6 => "12:00",
	7 => "12:30",
	8 => "13:00",
	9 => "13:30",
	10 => "14:00",
	11 => "14:30",
	12 => "15:00",
	13 => "15:30",	
);

while($cdate < $edate){
	$i=0;
	while($i<7){
		$j=1;
		while ($j<6){
			if ($weekdays[$j]==(date('N', $cdate))){
				$k=0;
				while($k<14){
					$sql = "INSERT INTO `dalearn1`.`testingappointments` (`ApptNum`, `time`, `date`, `advID`, `max`, `cur`) VALUES (NULL, $timearry[$k], $cdate, ab12345, $cap[$k], '0');";
					$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
					$k=$k+1;
				}
			}
			$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
			$i=$i+1;
			$j=$j+1;
		}
		
	}
	$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
	$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
	$i=$i+2;
}








echo("<p>Apointment updated</p>");
echo("<form action='advisorSetAvail.php' method='post' name='advAvail'>");
echo("<input type='submit' value='Set Availability'>");
echo("</form>");


echo("<form action='advisorShowSchedule.php' method='post' name='advAvail'>");
echo("<input type='submit' value='Show Schedule'>");
echo("</form>");

echo("</body></html>");
?>
