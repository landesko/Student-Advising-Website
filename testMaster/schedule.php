<html>
<head>
    <title>UMBC Advisor Console</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
</head>

  <!-- Custom style for sign in -->
  <link href="css/signin.css" rel="stylesheet">

   <!-- Main Style -->
  <link href="css/main.css" rel="stylesheet">

   <!-- Timetable Style -->
  <link href="css/timetable.css" rel="stylesheet">

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
         <h1>CMEE Student Advising Web Page</h1>
    </div>
  </nav>

     <!--Sign In-->
   <div class="container">
    <table class="table">
   
    <thead>
      <tr>
        <th>Time</th>

    <!--  echo advisor names in th tag here-->
        <?php

            include('CommonMethods.php');
            $debug = false;

            $COMMON = new Common($debug);

          $advisorSql = "SELECT * FROM `advisors` WHERE 1";
          $rs = $COMMON->executeQuery($advisorSql,$_SERVER["SCRIPT_NAME"]);


          $advisorInfo;
          $count = 0;
          while($row = mysql_fetch_row($rs)){
            $advisorInfo[$count] = $row;
            $count++;
          }
            // advisor names
            for ($i= 0; $i < $count; $i++) { 
                echo "<th>";
                //echo advisor name
                $name = $advisorInfo[$i][2];
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
          
            foreach ($apptTimeInfo as $timeInfo) {

              // time
              echo "<tr class='info'>";
              echo "<td>$timeInfo[2]</td>";

                // get appt info
              $t = $timeInfo[0];
              echo "$timeInfo[0]<br>";

              //var_dump($timeInfo[0]);

              $apptInfoSql = "SELECT * FROM `appointments` WHERE `apptNum` = '$t'";
              $rs = $COMMON->executeQuery($apptInfoSql,$_SERVER["SCRIPT_NAME"]);
              
              // store appt info in a 2D array
              $apptInfo=null;
              $count = 0;
              while($row = mysql_fetch_row($rs)){
                $apptInfo[$count] = $row;
                $count++;
              }


              if($apptInfo==null)
                break;
              //var_dump($apptInfo[0]);
              //var_dump($apptInfo[1]);

              foreach ($advisorInfo as $advisor) {
                
                echo "loop advisor $advisor[1] ID: $advisor[0]<br>";

                 foreach ($apptInfo as $appt) {

                echo "loop appt. ID: $appt[2]<br> ";
                  //echo "$appt[0]<br>";
 
                    // check if id match
                    if($appt[2] == $advisor[0]){
                        echo "ID Matches. $appt[2] $advisor[0]<br>";

                      if($appt[3] == 1){
                        echo "<td>Open</td>";
                      } 
                      else
                        echo "<td>Close</td>";
                    }
                }
              }             
              
                echo "</tr>"; 
            }



            /*
            $sqlApptNum = "SELECT `apptNum` FROM `apptTimes` WHERE `date` = '$sqlDate'";
            $apptNumArray = $COMMON->executeQuery($sqlApptNum,$_SERVER["SCRIPT_NAME"]);
            //1-14

            $advisors = "SELECT `advisorID` from `advisors` WHERE 1";
            $advisorArray = $COMMON->executeQuery($advisors,$_SERVER["SCRIPT_NAME"]);

            while($advisorName = mysql_fetch_row($advisorArray))
            {

            }

            $adv1 = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum` AND `advisorID` = 'JA12345`";
            $apptReturnAdv1 = $COMMON->executeQuery($adv1,$_SERVER["SCRIPT_NAME"]);
            $adv2 = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum` AND `advisorID` = 'JA12345`";
            $apptReturnAdv1 = $COMMON->executeQuery($adv1,$_SERVER["SCRIPT_NAME"]);
            $adv3 = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum` AND `advisorID` = 'JA12345`";
            $apptReturnAdv1 = $COMMON->executeQuery($adv1,$_SERVER["SCRIPT_NAME"]);
            $adv4 = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum` AND `advisorID` = 'JA12345`";
            $apptReturnAdv1 = $COMMON->executeQuery($adv1,$_SERVER["SCRIPT_NAME"]);


            while ($row = mysql_fetch_row($apptNum)) {
                echo "<tr class='info'>";
                $adv1 = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum` AND `advisorID` = 'JA12345`";
                $adv2 = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum` AND `advisorID` = 'AA12345`";
                $adv3 = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum` AND `advisorID` = 'ES12345`";
                $adv4 = "SELECT COUNT(`open`) FROM `appointments` WHERE `apptNum` = '$apptNum` AND `advisorID` = 'CB12345`";
                    echo "<td>$row[0]</td>";

                echo "</tr>";   
            }
                */             


            /*
            //for ($i= 0; $i < 15; $i++) { 

                // set class info/success/warn based on 
                echo "<tr class='info'>";

                    echo "<td>$printTime$timeSuffix$suffix</td>";

                    // echo info here
                    echo "<td id='advisorOpen'>Open</td>";
                    echo "<td id='advisorOpen'>Close</td>";
                    echo "<td id='advisorOpen'>Open</td>";
                
                echo "</tr>";

                $count++;   

                if ($i % 2 == 0) {
                    $time++;
                }
            }
            */
        ?>

    </tbody>
  </table>
</div>
 <!-- /container -->


<!-- Load javascript required for Bootstrap animation-->
<script src="https://code.jquery.com/jquery.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>