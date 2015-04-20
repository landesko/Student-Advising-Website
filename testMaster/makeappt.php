<?php
echo("<html><head></head><body>");

$debug = true;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods

$sdate=Date('2015-03-02');
$cdate=Date("2015-03-02");
$edate=Date("2015-05-01");
$timearry = array(
	0 => '09:00:00',
	1 => '09:30:00',
	2 => '10:00:00',
	3 => '10:30:00',
	4 => '11:00:00',
	5 => '11:30:00',
	6 => '12:00:00',
	7 => '12:30:00',
	8 => '13:00:00',
	9 => '13:30:00',
	10 => '14:00:00',
	11 => '14:30:00',
	12 => '15:00:00',
	13 => '15:30:00',	
);

$z=0;
$advarry = array(
	0 => 0,
	1 => 0,
	2 => 0,
	3 => 0,
);
$sql = "select * from advisors";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
while($row = mysql_fetch_row($rs))
{
     $advarry[$z]=$row[0];
	 $z=$z+1;
}


while($cdate < $edate){
	
	$i=0;
	while($i<5){
		$k=0;
		while($k<14){

			$sql = "INSERT INTO `dalearn1`.`apptTimes` (`ApptNum`, `date`, `time`) 
			VALUES (NULL, '$cdate', '$timearry[$k]')";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			//$z=0;
			//while($z<4){
				//$sql = "INSERT INTO `dalearn1`.`testingappointments` (`ApptNum`, `date`, `time`, `maxCapacity`, `currentCapacity`) 
				//VALUES (NULL, '$cdate', '$timearry[$k]', 0, 0)";
				//$z=$z+1;
				//$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			//}
			
			$k=$k+1;
		}
		$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
		$i=$i+1;
	}
	$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
	$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
}


echo("</body></html>");
?>
