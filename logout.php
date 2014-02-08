<?php 
	mysql_connect("localhost", "mysqlusername", "password") or die(mysql_error()); 
	mysql_select_db("wikiuser") or die(mysql_error()); 
 $past = time() - 100; 

 //this makes the time in the past to destroy the cookie 

 setcookie(ID_my_site, gone, $past); 

 setcookie(Key_my_site, gone, $past); 
 $clear = mysql_query("DELETE FROM CURRENTUSER");

 header("Location: login.php"); 

 ?> 