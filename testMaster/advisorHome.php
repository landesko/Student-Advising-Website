<?php




$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods


echo("<form action='advisorSetAvail.php' method='post' name='advAvail'>");
echo("<input type='submit' value='Set Availability'>");
echo("</form>");




$sql = "SELECT * FROM `advisors` ";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$advName;
$advFullName;
$advFName;
$advLName;
echo("<form action='advisorShowSchedule.php' method='post' name='advAvail'>");


echo("<br>");

echo("<input type='submit' value='Show Schedule'>");
echo(" for: ");
echo("<select name='advisor'>");
echo("<option value=all> all advisors </option>");
while($row = mysql_fetch_row($rs))
{
     $advFullName=$row[1].$space.$row[2];
     $advName=$row[1] . " " . $row[2];
     echo("<option value='");
     echo("$advName'");
     echo(">" . $advName . "</option>");
}
echo("</select>");
echo("</form>");

?>
