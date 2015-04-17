<?php

session_start();
?>

<html>
<head>
    <title>UMBC Advisor Console</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    
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
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <img class="navbar-brand"  src="res/logo.png" >
                
        </div>
         <h2>CMEE Student Advising Web Page</h2>
    </div>
  </nav>

     <!--Sign In-->
   <div class="container">
    <table class="table" border="1">
   
    <thead>
      <tr>
        <th class="warning">Time</th>

    <!--  echo advisor names in th tag here-->
        <?php

            include('CommonMethods.php');
            $debug = false;

            $COMMON = new Common($debug);

          $advisorSql = "SELECT * FROM `advisors` WHERE 1";
          $rs = $COMMON->executeQuery($advisorSql,$_SERVER["SCRIPT_NAME"]);


          $advisorInfo;
		  $advisorID;
          $count = 0;
          while($row = mysql_fetch_row($rs)){
            $advisorInfo[$count] = $row;
            $count++;
          }
            // advisor names
            for ($i= 0; $i < $count; $i++) { 
                echo "<th class='warning'>";
                //echo advisor name
                $name = $advisorInfo[$i][2];
				$advisorID[$i] = $advisorInfo[$i][0];
                echo "$name";
                echo "</th>";
            }

            //var_dump($advisorInfo);
        ?>

      </tr>
    </thead>

    <!--  echo advisor names in th tag here-->
    <tbody>
       

        <?php
            // date('w',srttotime());
			
			$advisingArray = array();

            $sqlDate = "2015-03-02";

          // time info
          $apptTimeSql = "SELECT `apptNum`,`date`,TIME_FORMAT(`time`, '%h:%i %p') FROM `apptTimes` WHERE `date` = '$sqlDate'";
          $rs = $COMMON->executeQuery($apptTimeSql,$_SERVER["SCRIPT_NAME"]);
          $apptTimeInfo;
          $count = 0;
          while($row = mysql_fetch_row($rs)){
            $apptTimeInfo[$count] = $row;
            $count++;
          }



          //var_dump($apptTimeInfo);
          //var_dump($apptTimeInfo[1][2]);
		  
		  echo("<form class='formm-signin' action='added.php' method='post' name='Form1'>"); 
		  
		  $rowColor = 0; 
          
            foreach ($apptTimeInfo as $timeInfo) {

              // time
			  if($rowColor % 3 == 0)
			  {
              echo "<tr class='info'>";
			  }
			  else if($rowColor % 3 == 1)
			  {
              echo "<tr class='danger'>";
			  }
			   else if($rowColor % 3 == 2)
			  {
              echo "<tr class='success'>";
			  }
              echo "<td>$timeInfo[2]</td>";

                // get appt info
              $apptNum = $timeInfo[0];
			  
			  for($i = 0; $i<count($advisorID); $i++)
			  {
				  $apptSlot = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum' AND `advisorID` = '$advisorID[$i]' AND `open` = 1";
				  $rs = $COMMON->executeQuery($apptSlot,$_SERVER["SCRIPT_NAME"]);
				  $apptAvailable = mysql_fetch_row($rs);
				  
				  $groupOrNot = "SELECT COUNT(`apptNum`) FROM `appointments` WHERE `apptNum` = '$apptNum' AND `advisorID` = '$advisorID[$i]'";
				  $rs = $COMMON->executeQuery($apptSlot,$_SERVER["SCRIPT_NAME"]);
				  $isGroup = mysql_fetch_row($rs);
				  //echo "$row";
				  if($apptAvailable[0] >= 1)
				  {
				  	if($isGroup[0] > 1)
					{
						echo "<td class='advisorSlotOpen'><input id='$advisorID[$i]' type='radio' name='time' value='$advisorID[$i] $apptNum' checked><label for='$advisorID[$i]'>Group - $apptAvailable[0]</label></td>";
					}
					else
					{
						echo "<td class='advisorSlotOpen'><input id='$advisorID[$i]' type='radio' name='time' value='$advisorID[$i] $apptNum' checked><label for='$advisorID[$i]'>Single - Open</label></td>";
					}
				  }
				  else
				  {
					echo"<td></td>";
				  }
				  
			  }
			  	$rowColor++;
                echo "</tr>"; 
            }
		


        ?>
    </tbody>
  </table>
  <button class="btn btn-lg btn-primary" type="submit" >Submit</button></form> <br><br>
</div>

 <!-- /container -->


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