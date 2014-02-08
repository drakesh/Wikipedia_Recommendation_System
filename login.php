<?php 
	ini_set("default_socket_timeout", 1200);
	 ini_set('max_execution_time', 1200);
 // Connects to your Database 
 mysql_connect("localhost", "mysqlusername", "password") or die(mysql_error()); 
 mysql_select_db("wikiuser") or die(mysql_error()); 
session_start();
 //Checks if there is a login cookie
 if(isset($_COOKIE['ID_my_site']))
 //if there is, it logs you in and directes you to the members page

 { 
 	$username = $_COOKIE['ID_my_site']; 
 	$pass = $_COOKIE['Key_my_site'];
	$check = mysql_query("SELECT * FROM userreg WHERE wikiusername = '$username'");
	
 	while($info = mysql_fetch_array( $check )) 	
 		{
 		if ($pass != $info['password']) 

 			{

 			}

 		else

 			{
			$insert = "INSERT INTO CURRENTUSER (username) VALUES ('".$_POST['username']."')";
		mysql_query($insert);
 			header("Location: members.php");
 			}
 		}
 }


 //if the login form is submitted 
 if (isset($_POST['submit'])) 
 { 
 // if form has been submitted

 // makes sure they filled it in

 	if(!$_POST['username'] | !$_POST['pass']) 
	{
	
		echo '<body style = "background-color:black">';
		die('<font color = "white"> You did not fill in a required field.<a href=login.php> Click Here to go Back</a></font>');
 	}

 	// checks it against the database

 	$check = mysql_query("SELECT * FROM userreg WHERE wikiusername = '".$_POST['username']."'");

	//Gives error if user dosen't exist
	$check2 = mysql_num_rows($check);

	if ($check2 == 0) 
	{
 		echo '<body style = "background-color:black">';
		die('<font color = "white">That user does not exist in our database. <a href=registration.php> Click Here to Register</a></font>');
	}

	while($info = mysql_fetch_array( $check )) 	
	{

	$_POST['pass'] = stripslashes($_POST['pass']);
 	$info['password'] = stripslashes($info['password']);
 	$_POST['pass'] = md5($_POST['pass']);

 //gives error if the password is wrong

 	if ($_POST['pass'] != $info['password']) 
		{
			echo '<body style = "background-color:black">';
			die('<font color = "white">Incorrect password, please try again.<a href=login.php> Click Here to go Back</a></font>');
			
		}
	else 
		{ 
		$_SESSION['user'] = $_POST['username'];

  // if login is ok then we add a cookie 

		$_POST['username'] = stripslashes($_POST['username']); 
		$hour = time() + 3600; 
		setcookie(ID_my_site, $_POST['username'], $hour); 
		setcookie(Key_my_site, $_POST['pass'], $hour);	 
		//then redirect them to the members area 
		header("Location: members.php"); 
		}	 
	} 
} 

else 

{	 
 
 // if they are not logged in 

 ?> 

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WikiEdit - Login</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/Icon.ico" />
</head>

<body bgcolor="black">
	<img style="position:absolute;left:100px;top:100px;"src="images/wikilogo.jpg" alt="WIKI LOGO" width="300" height="275">
	<img style="position:relative;left:500px;top:50px;"src="images/wikiedit.jpg" alt="WIKI EDIT" width="600" height="200">
	<table border="0" width="400" style="color:white;position:relative;left:400px;top:225px;">
		<tr><td><font size="5">WikiEdit is a webservice that helps enthusiastic Wikipedia users (like you!) by recommending Wikipedia pages to edit. These recommended pages are based on your previous contributions to Wikipedia articles and your area of interest.</font></td></tr>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
 		<table border="0" style="color:white;position:relative;left:900px;"> 
 			<tr><td colspan=2><h1>Login</h1></td></tr> 
 			<tr><td><font size="5">Username:</td><td><input type="text" name="username" maxlength="40"></font></td></tr> 
 			<tr><td><font size="5">Password:</td><td><input type="password" name="pass" maxlength="50"></font></td></tr> 
 			<tr><td colspan="2" align="right"><input type="submit" name="submit" value="Login"></font></td></tr> 
 			<tr><td><a href=registration.php style="color:white;"><font size="5"> Click Here to Register</a> </font></td></tr>
 		</table>
 	</form>	
</body>
</html>
 <?php 

 } 

 ?> 