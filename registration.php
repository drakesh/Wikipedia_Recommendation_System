<?php 
	// Connects to your Database 
	mysql_connect("localhost", "mysqlusername", "password") or die(mysql_error()); 
	mysql_select_db("wikiuser") or die(mysql_error()); 
	//This code runs if the form has been submitted
	if (isset($_POST['submit'])) 
	{ 
	//This makes sure they did not leave any fields blank
		if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] | !$_POST['emailid'] | !$_POST['areaofinterest'] )
		{
			echo '<body style = "background-color:black">';
			die('<font color = "white"> You did not complete all of the required fields <a href=registration.php> Click Here to Register</a></font>');
		}

	// checks if the username is in use
		if (!get_magic_quotes_gpc()) 
		{
			$_POST['username'] = addslashes($_POST['username']);
		}
		$usercheck = $_POST['username'];
		$check = mysql_query("SELECT wikiusername FROM userreg WHERE wikiusername = '$usercheck'");
		$validatename = mysql_query("(SELECT Field6 from wiki.wikidata1a where Field6 LIKE '%$usercheck%')UNION
									(SELECT Field6 from wiki.wikidata1b where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata2a where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata2b where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata3a where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata3b where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata4a where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata4b where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata5a where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata5b where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata6a where Field6 LIKE '%$usercheck%') UNION
									(SELECT Field6 from wiki.wikidata7b where Field6 LIKE '%$usercheck%');");
		$check3 = mysql_num_rows($validatename);
		$check2 = mysql_num_rows($check);

	//if the name exists it gives an error
		if ($check2 != 0) 
		{
			echo'<H2> <font color = "white">Registration Failed</font></H2>';
			echo '<body style = "background-color:black">';
			die('<font color = "white" size = 4> Sorry, the username '.$_POST['username'].' is already registered.<a href=registration.php> Click Here to go Back</a></font>');
		}
	//if the name does not exist in the Wikipedia Database
		if ($check3 == 0) 
		
		{
			echo'<H2> <font color = "white">Registration Failed</font></H2>';
			echo '<body style = "background-color:black">';
			die('<font color = "white" size = 4> The username '.$_POST['username'].' is not a registered Wikipedia Username. We suggest you to first 
			register with Wikipedia and make some contributions after which you can register for our service. Thank You for your interest in our service. <a href=registration.php> Click Here to go Back</a></font>');
		}	
	//this makes sure both passwords entered match

		if ($_POST['pass'] != $_POST['pass2']) 
		{
			echo'<H2> <font color = "white">Registration Failed</font></H2>';
			echo '<body style = "background-color:black">';
			die('<font color = "white" size = 4>Your passwords did not match. <a href=registration.php> Click Here to go Back</a></font>');
		}
 	// here we encrypt the password and add slashes if needed

		$_POST['pass'] = md5($_POST['pass']);

		if (!get_magic_quotes_gpc()) 
		{
			$_POST['pass'] = addslashes($_POST['pass']);
			$_POST['username'] = addslashes($_POST['username']);
 		} 

	// now we insert it into the database

		$insert = "INSERT INTO userreg (wikiusername, password, emailid,Areaofinterest) VALUES ('".$_POST['username']."', '".$_POST['pass']."', '".$_POST['emailid']."','".$_POST['areaofinterest']."')";
		$add_member = mysql_query($insert);
?>


<body bgcolor="black">
	
<font color = 'white'>
	<h1>Registered</h1>
<p>Thank you, you have registered - you may now login</a>.</p>
<table>
<tr> <td> 
	<a href=login.php> Go to Login Page</a>
</td></tr>
</font>
 </table>
</body>

 <?php 
 } 
else 
{	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WikiEdit - Register</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/Icon.ico" />
</head>

<body bgcolor="black">
	<img style="position:absolute;left:100px;top:100px;"src="images/wikilogo.jpg" alt="WIKI LOGO" width="300" height="275">
	<img style="position:relative;left:500px;top:100px;"src="images/wikiedit.jpg" alt="WIKI EDIT" width="600" height="200">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<table border="0" style="color:white;position:relative;left:500px;top:150px;">
	<tr><td colspan=2><h1>Register</h1></td></tr> 
	<tr><td><font size="5">Username:</font></td><td><input type="text" name="username" maxlength="60" value = "Wikipedia User Name" onfocus="this.value=''">
	<tr><td><font size="5">Email ID:</font></td><td>
	<input type="text" name="emailid" maxlength="60" value = "Enter your Email Address" onfocus="this.value=''">
	<tr><td><font size="5">Area of Interest:</font></td><td>
	<input type="text" name="areaofinterest" maxlength="60" value = "Enter at least one Area of Interest briefly:" onfocus="this.value=''">
	</td></tr>
	<tr><td><font size="5">Password:</font></td><td>
	<input type="password" name="pass" maxlength="20">
	</td></tr>
	<tr><td><font size="5">Confirm Password:</font></td><td>
	<input type="password" name="pass2" maxlength="20">
	</td></tr>
	<tr><th colspan=2><input type="submit" name="submit"  value="Register"></th></tr> </table>
	
	
	</form>
</body>
</html>
 <?php
 }
 ?> 

