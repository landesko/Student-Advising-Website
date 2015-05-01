<?php

session_start();
?>

<html>

<head>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


<head>
<title>COEIT Advising Sign Up</title>
<!-- ============================================================== -->
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="description" content="UMBC Advising" />
<meta name="keywords" content="UMBC, Advising" />
<!-- ============================================================== -->

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
            <img class="navbar-brand"  src="res/logo.png" >      
        </div>
        <div class="titleBar">
             <h2>COEIT Student Advising Web Page</h2>
             </div>
       
       </div>
  </nav>

     <!--Sign In-->
    <div class="container">

      <form class="form-signin" action = "schedule.php" method ="post">
        <h2 class="form-signin-heading">Please Sign In</h2>
        <label for="inputFname" class="sr-only">First Name</label>
        <input type="text" name = "fname" class="form-control" placeholder="First Name"  autofocus>
        <label for="inputLname"  class="sr-only">Last Name</label>
        <input type="text" name = "lname" class="form-control" placeholder="Last Name"  autofocus>
        <label for="inputID"  class="sr-only">ID</label>
        <input type="text" name = "studentID" class="form-control" placeholder="Student ID"  autofocus>
        <label for="inputMajor"  class="sr-only">Major</label>
        <input type="text" name = "major" class="form-control" maxlength="4" placeholder="Major"  autofocus>
        <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button>
        <p>*Students, Sign In to create an appointment or to view an existing appointment*</p>
      </form>
      
      

    </div> <!-- /container -->


<!-- Load javascript required for Bootstrap animation-->
<script src="https://code.jquery.com/jquery.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</body>
</html>