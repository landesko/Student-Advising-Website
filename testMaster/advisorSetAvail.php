<?php

echo("<html><head><title></title>Set Availability For:</head><body>");

$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods
$sql = "select fName, lName from advisors";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$advName;
$advFullName;
$advFName;
$advLName;
$space=' ';
$maj;
$num=0;
$sdate=Date('2015-03-02');
$cdate=Date("2015-03-02");
$edate=Date("2015-05-01");

$Tsql = "SELECT time_format(`time`,'%h:%i %p'), `time` FROM `times` WHERE 1;";
$Trs = $COMMON->executeQuery($Tsql, $_SERVER["SCRIPT_NAME"]);

$array = array();

$count = 0;

while ($trow = mysql_fetch_row($Trs)){
	$array[$count]=$trow;
	$count++;
}

echo("<br><br>TESTING ARRAY<br><br>");
$tempcount=$count;
while($tempcount > 0){
	echo($array[$tempcount][0]);
	echo("<br>");
	echo($array[$tempcount][0]);
	$tempcount--;
	echo("<br>next<br>");
}




echo("<form action='updateAdvisorAvail.php' method='post' name='form1'>");
echo("<select name='advisor'>");

while($row = mysql_fetch_row($rs))
{
     $advFullName=$row[0].$space.$row[1];
     $advName=$row[0] . " " . $row[1];
     echo("<option value='");
     echo("$advName'");
     echo(">" . $advName . "</option>");
}
echo("</select>");
echo("<br>");

echo(" On ");//same as 
echo("<input type='checkbox' name='mon' value='1' />Monday");
echo("<input type='checkbox' name='tue' value='2' />Tuesday");
echo("<input type='checkbox' name='wed' value='3' />Wednesday");
echo("<input type='checkbox' name='thr' value='4' />Thursday");
echo("<input type='checkbox' name='fri' value='5' />Friday");

echo("<br>");
echo(" Between: ");
echo("<select name='startdate'>");
while($cdate < $edate){
	
	$i=0;
	while($i<7){
		echo("<option value='");
		echo("$cdate'");
		echo(">" . $cdate . "</option>");
		$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
		$i=$i+1;
	}
	$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
	$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
}
echo("</select>");

$cdate=$sdate;
echo(" And: ");
echo("<select name='enddate'>");
while($cdate < $edate){
	
	$i=0;
	while($i<7){
		echo("<option value='");
		echo("$cdate'");
		echo(">" . $cdate . "</option>");
		$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
		$i=$i+1;
	}
	$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
	$cdate = date('Y-m-d', strtotime($cdate . ' + 1 day'));
}
echo("</select>");


$sql = "select major from majors";
echo("<table><tr><th>Start Time</th><th>Capacity</th><th>Major</th></tr>");

while($num < $count){
	echo("<tr><td>"); echo($array[$num][0]); echo("</td><td>");
	echo("<select name='cap$num'>");
	$i=0;
	while($i<12){
		echo("<option value='");
		echo("$i'");
		echo(">" . $i . "</option>");
		$i=$i+1;
	}
	echo("</select>");
	echo("</td><td>");
	echo("<select name='major$num'><option value=any>any</option>");
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	while($row = mysql_fetch_row($rs)){
		$maj=$row[0];
		echo("<option value='");
		echo("$maj'");
		echo(">" . $maj . "</option>");
	}
	echo("</select>");
	echo("</td></tr>");
	$num = $num + 1;
}

echo("</table>");

echo("<input type='submit' value='Update Availability'>");
echo("</form>");


echo("</body></html>");

?>