<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

$month = 3;
$day;
$time;
$incrementor = 0;

include('../CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

//Group advising loop to instantiate the database
for ($i = 23; $i < 28; $i++)
{
	for ($j = 13; $j < 16; $j++)
	{
		for ($k = 0; $k < 10; $k++)
		{
			$sql = "INSERT INTO `dale2`.`gAdvising` (`apptNum`, `studentID`, `fname`, `lname`, `major`, `available`, `time`, `date`) VALUES ('$incrementor', NULL, NULL, NULL, NULL, '1', '$j:00', '2015-03-$i')";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$incrementor++;
		}
		for ($k = 0; $k < 10; $k++)
		{
			$sql = "INSERT INTO `dale2`.`gAdvising` (`apptNum`, `studentID`, `fname`, `lname`, `major`, `available`, `time`, `date`) VALUES ('$incrementor', NULL, NULL, NULL, NULL, '1', '$j:30', '2015-03-$i')";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$incrementor++;
		}
	}
}



?>
<p></p>
</body>
</html>

SELECT COUNT(  `available` ) 
FROM  `gAdvising` 
WHERE  `time` =  '13:00'
AND  `date` =  '2015-03-23'

$sql =  "SELECT COUNT( * ) ,  '$advisorArray[i]' AS  `$advisorArray[i]` 
FROM  `$advisorArray[i]` 
WHERE  `studentID` =  '$studentID'";