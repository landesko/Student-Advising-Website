<?php
echo("<html><head><title></title>Appointments For:</head><body>");

$advisor;
$stuID;

$debug = false;
include('CommonMethods.php');
$COMMON = new Common($debug); // common methods

$sql = "select firstName, lastName from listOfAdvisors";
$rAdv = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
while($rowAdv = mysql_fetch_row($rAdv))
{
     $advisor=$rowAdv[0] . " " . $rowAdv[1];
     echo("<table><tr><td>".$advisor." on Monday</td></tr><tr><th>Time</th><th>Student ID</th><th>Name</th><th>Major</th></tr>");
     $sql = "SELECT * FROM `Monday` WHERE `advisor` = '$advisor'";
     $rStuIDs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

     while($rowStuIDs = mysql_fetch_row($rStuIDs)){     
         $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[2]'";
         $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
         $row = mysql_fetch_row($rs);
         echo("<tr><td>$rowStuIDs[0]</td>");

         foreach($row as $value){
              echo("<td>".$value."</td>");
         }
         echo("</tr>");

         if($rowStuIDs[3]==1){
              for($i=5;$i<14;$i++){
                   $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[$i]'";
                   $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
                   $row2 = mysql_fetch_row($rs);
                   echo("<tr><td></td>");
                   foreach($row2 as $value){
                        echo("<td>".$value."</td>");
                   }
                   echo("</tr>");
              }
         }

     }//end time slot
     echo("</table><br>");
}//end advisor table

////////////////////////
$sql = "select firstName, lastName from listOfAdvisors";
$rAdv = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
while($rowAdv = mysql_fetch_row($rAdv))
{
     $advisor=$rowAdv[0] . " " . $rowAdv[1];
     echo("<table><tr><td>".$advisor." on Tuesday</td></tr><tr><th>Time</th><th>Student ID</th><th>Name</th><th>Major</th></tr>");
     $sql = "SELECT * FROM `Tuesday` WHERE `advisor` = '$advisor'";
     $rStuIDs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

     while($rowStuIDs = mysql_fetch_row($rStuIDs)){     
         $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[2]'";
         $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
         $row = mysql_fetch_row($rs);
         echo("<tr><td>$rowStuIDs[0]</td>");

         foreach($row as $value){
              echo("<td>".$value."</td>");
         }
         echo("</tr>");

         if($rowStuIDs[3]==1){
              for($i=5;$i<14;$i++){
                   $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[$i]'";
                   $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
                   $row2 = mysql_fetch_row($rs);
                   echo("<tr><td></td>");
                   foreach($row2 as $value){
                        echo("<td>".$value."</td>");
                   }
                   echo("</tr>");
              }
         }

     }//end time slot
     echo("</table><br>");
}//end advisor table

///////////////////////
$sql = "select firstName, lastName from listOfAdvisors";
$rAdv = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
while($rowAdv = mysql_fetch_row($rAdv))
{
     $advisor=$rowAdv[0] . " " . $rowAdv[1];
     echo("<table><tr><td>".$advisor." on Wednesday</td></tr><tr><th>Time</th><th>Student ID</th><th>Name</th><th>Major</th></tr>");
     $sql = "SELECT * FROM `Wednesday` WHERE `advisor` = '$advisor'";
     $rStuIDs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

     while($rowStuIDs = mysql_fetch_row($rStuIDs)){     
         $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[2]'";
         $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
         $row = mysql_fetch_row($rs);
         echo("<tr><td>$rowStuIDs[0]</td>");

         foreach($row as $value){
              echo("<td>".$value."</td>");
         }
         echo("</tr>");

         if($rowStuIDs[3]==1){
              for($i=5;$i<14;$i++){
                   $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[$i]'";
                   $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
                   $row2 = mysql_fetch_row($rs);
                   echo("<tr><td></td>");
                   foreach($row2 as $value){
                        echo("<td>".$value."</td>");
                   }
                   echo("</tr>");
              }
         }

     }//end time slot
     echo("</table><br>");
}//end advisor table

//////////////////////////
$sql = "select firstName, lastName from listOfAdvisors";
$rAdv = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
while($rowAdv = mysql_fetch_row($rAdv))
{
     $advisor=$rowAdv[0] . " " . $rowAdv[1];
     echo("<table><tr><td>".$advisor." on Thursday</td></tr><tr><th>Time</th><th>Student ID</th><th>Name</th><th>Major</th></tr>");
     $sql = "SELECT * FROM `Thursday` WHERE `advisor` = '$advisor'";
     $rStuIDs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

     while($rowStuIDs = mysql_fetch_row($rStuIDs)){     
         $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[2]'";
         $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
         $row = mysql_fetch_row($rs);
         echo("<tr><td>$rowStuIDs[0]</td>");

         foreach($row as $value){
              echo("<td>".$value."</td>");
         }
         echo("</tr>");

         if($rowStuIDs[3]==1){
              for($i=5;$i<14;$i++){
                   $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[$i]'";
                   $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
                   $row2 = mysql_fetch_row($rs);
                   echo("<tr><td></td>");
                   foreach($row2 as $value){
                        echo("<td>".$value."</td>");
                   }
                   echo("</tr>");
              }
         }

     }//end time slot
     echo("</table><br>");
}//end advisor table

////////////////////////
$sql = "select firstName, lastName from listOfAdvisors";
$rAdv = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
while($rowAdv = mysql_fetch_row($rAdv))
{
     $advisor=$rowAdv[0] . " " . $rowAdv[1];
     echo("<table><tr><td>".$advisor." on Friday</td></tr><tr><th>Time</th><th>Student ID</th><th>Name</th><th>Major</th></tr>");
     $sql = "SELECT * FROM `Friday` WHERE `advisor` = '$advisor'";
     $rStuIDs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

     while($rowStuIDs = mysql_fetch_row($rStuIDs)){     
         $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[2]'";
         $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
         $row = mysql_fetch_row($rs);
         echo("<tr><td>$rowStuIDs[0]</td>");
         if($row[0]!=null){
              foreach($row as $value){
                    echo("<td>".$value."</td>");
              }
         }
         
         echo("</tr>");

         if($rowStuIDs[3]==1){
              for($i=5;$i<14;$i++){
                   $sql = "SELECT * FROM `students` WHERE `id` = '$rowStuIDs[$i]'";
                   $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
                   $row2 = mysql_fetch_row($rs);
                   echo("<tr><td></td>");
                   foreach($row2 as $value){
                        echo("<td>".$value."</td>");
                   }
                   echo("</tr>");
              }
         }

     }//end time slot
     echo("</table><br>");
}//end advisor table

echo("</body></html>");
?>