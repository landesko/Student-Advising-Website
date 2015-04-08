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

//accepts session and post data here
$fname = ($_SESSION['fname']);
$lname = ($_SESSION['lname']);
$studentID = ($_SESSION['studentID']);
$major = ($_SESSION['major']);
$advisor = ($_POST['advisor']);

//recreates new session data here
$_SESSION['studentID'] = $studentID;
$_SESSION['fname'] = $fname;
$_SESSION['lname'] = $lname;
$_SESSION['major'] = $major;
$_SESSION['advisor'] = $advisor;

echo($fname . " " . $lname . " is logged in."); 
echo("<br \n> <br \n>");

//reiterates what advisor the student chose
echo ("You chose " . $advisor . ".");
echo ("<br><br>");
echo ("Please choose a date below to meet with an advisor.");

//Radio for to allow student to choose what date they would like to meet with the advisor
//For the scope of this project I have created 5 different days students can meet with advisor
//MUST EDIT THIS TO ADD MORE DATES IN!!
echo("
<form action='results.php' method='post' name='Form1'>
<input type='radio' name='date' value='3/23' checked>March 23, 2015
<br>
<input type='radio' name='date' value='3/24'>March 24, 2015
<br>
<input type='radio' name='date' value='3/25'>March 25, 2015
<br>
<input type='radio' name='date' value='3/26'>March 26, 2015
<br>
<input type='radio' name='date' value='3/27'>March 27, 2015
<br> <br />
<input type='submit' name='submit' value='Submit'>
</form> "
);

 
 ?>
 
</p>

</div>
</div>

</body>
</html>
