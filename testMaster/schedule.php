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

            for ($i= 0; $i < 3; $i++) { 
               
                echo "<th>";
                
                //echo advisor name
                echo "advisor";

                echo "</th>";
            }
        ?>

      </tr>
    </thead>

    <!--  echo advisor names in th tag here-->
    <tbody>
       
        <?php
            $sqlDate = "2015-03-02";

            include('CommonMethods.php');
            $debug = true;

            $COMMON = new Common($debug);

            $sql = "SELECT `time` TIME_FORMAT(`time`, '%h:%i %p') FROM `apptTimes` WHERE `date` = '$sqlDate`";
            $result = $COMMON->executeQuery($sql,$_SERVER["SCRIPT_NAME"]);

            var_dump($result);

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