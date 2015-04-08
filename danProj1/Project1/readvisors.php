<?php

session_start();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


<head>
<title>Advising Sign Up</title>
<!-- ============================================================== -->
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Content-Language" content="en-us" />
<meta name="description" content="UMBC Advising" />
<meta name="keywords" content="UMBC, Advising" />
<!-- ============================================================== -->

<base target="_top" />
<link rel="stylesheet" type="text/css" href="styler.css" />

<base target="_top" />
<link rel="stylesheet" type="text/css" href="template.css" />
<link rel="icon" type="image/png" href="icon.png" />
</head>

<body>

<div class="topContainer">
  <div class="leftTopContainer">
    
  	<img src="umbcLogo.png" width="261" height="72" alt="umbcLogo" />
  	<b>Student Advising</b>
  
  	</div>
    
  <div class="rightTopContainer">
  		<div class="rightTopContent">
        <a href="index.php">Logout</a>	
        </div>
  
    </div>
</div>

<div class="container">
<div class="inner-container">

<p>

<?php
//This page is different than advisor because we are not accepting post data,
//Instead we are accepting session data from results.php

//accepts session variables
$fname = ($_SESSION['fname']);
$lname = ($_SESSION['lname']);
$studentID = ($_SESSION['studentID']);
$major = ($_SESSION['major']);

//recreates the variables for the next page
$_SESSION['studentID'] = $studentID;
$_SESSION['fname'] = $fname;
$_SESSION['lname'] = $lname;
$_SESSION['major'] = $major;


echo ("Welcome, " . $fname . " " . $lname . ", to student advising.");

?>
<br /> <br />

Please select which advisor you would like to meet with or choose group advising.
<br /><br />

<!-- MUST EDIT THIS TO ADD ANY NEW ADVISOR NAMES -->
<!-- Radio form to allow student to choose advisor -->
<form action="dates.php" method="post" name="Form1">
<input type="radio" name="advisor" value="Josh Abrams" checked>Josh Abrams
<br>
<input type="radio" name="advisor" value="Anne Arey">Anne Arey
<br>
<input type="radio" name="advisor" value="Emily Stephens">Emily Stephens
<br>
<input type="radio" name="advisor" value="Group Advising">Group Advising
<br> <br />
<input type="submit" name="submit" value="Submit">
</form> 

</p>

</div>
</div>

</body>
</html>
