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

  <!-- Custom styles for sign in -->
  <link href="css/signin.css" rel="stylesheet">

  <!-- Main Style -->
  <link href="css/main.css" rel="stylesheet">
  
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

    <!-- Collect the nav links, forms, and other content for toggling -->
   <!-- <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#">Advisor Console</a></li>
      </ul>
     
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Login</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
    <!--</div><!-- /.container-fluid -->
  </nav>

     <!--Sign In-->
    <div class="container">

      <form class="form-signin" action = "schedule.php" method ="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputFname" class="sr-only">First Name</label>
        <input type="text" name = "fname" class="form-control" placeholder="First Name"  autofocus>
        <label for="inputLname"  class="sr-only">Last Name</label>
        <input type="text" name = "lname" class="form-control" placeholder="Last Name"  autofocus>
        <label for="inputID"  class="sr-only">ID</label>
        <input type="text" name = "ID" class="form-control" placeholder="ID"  autofocus>
        <label for="inputMajor"  class="sr-only">Major</label>
        <input type="text" name = "major" class="form-control" placeholder="Major"  autofocus>
        <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
      </form>

    </div> <!-- /container -->


<!-- Load javascript required for Bootstrap animation-->
<script src="https://code.jquery.com/jquery.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>