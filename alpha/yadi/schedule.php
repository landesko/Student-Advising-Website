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

            $time = 9;

            $printTime;
            $timeSuffix;
            $am = "  am";
            $pm = "  pm";
            $suffix = $am;
            
            for ($i= 0; $i < 15; $i++) { 

                if ($i % 2 == 0) {
                    $timeSuffix = ":30";
                }
                else{
                    $timeSuffix = ":00";
                }

                if($time>12){
                    $printTime = $time - 12;
                    $suffix = $pm;
                }
                else{
                    $printTime = $time;
                    $suffix = $am;
                }


                // set class info/success/warn based on 

                echo "<tr class='info'>";

                    echo "<td>$printTime$timeSuffix$suffix</td>";

                    // echo info here
                        echo "<td id='advisorSlot'>Open</td>";
                        echo "<td id='advisorSlot'>Close</td>";
                        echo "<td id='advisorSlot'>Open</td>";
                
                echo "</tr>";

                $time++;
            }
        ?>

    </tbody>
  </table>
</div>
 <!-- /container -->


 <?php
    echo "";

 ?>


<!-- Load javascript required for Bootstrap animation-->
<script src="https://code.jquery.com/jquery.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>