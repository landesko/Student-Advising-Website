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

<!-- Styling - Same on Every Page -->
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


<!-- Form to enter student first name, lastname, ID, and major -->
<p>
Please enter your name, student ID number, and major.<br>
<form action="advisors.php" method="post" name="Form1">
First Name <br>
	<input type="text" size="25" maxlength="50" name="fname"><br> <br />
Last Name <br>
	<input type="text" size="25" maxlength="50" name="lname"><br> <br />
ID <br>
	<input type="text" size="25" maxlength="10" name="studentID"><br> <br />
Major <br>
	<input type="text" size="25" maxlength="4" name="major"><br> <br />
<input type='submit' value='submit'>

</form>
<br /><br /> 

</p>

</div>
</div>

</body>
</html>
