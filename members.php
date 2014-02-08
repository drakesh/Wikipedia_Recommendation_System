<?php 

 // Connects to your Database 
 
 //header('Content-type: text/plain');
 
 ini_set("default_socket_timeout", 1200);
 
 ini_set('max_execution_time', 1200);
 session_start();

 mysql_connect("localhost", "mysqlusername", "password") or die(mysql_error()); 

 mysql_select_db("wikiuser") or die(mysql_error()); 
 

$client = new SoapClient("http://rakesh-pc:8080/WikiEdit/wikiSearchService?wsdl");
$user = $_SESSION['user'];
$params = array(
  "arg0" => $user,
);
$result = $client->wikiFind($params);
function array_iunique($array) {
    return array_intersect_key(
        $array,
        array_unique(array_map("StrToLower",$array))
    );
}
$res = array_iunique($result->return);
?>
 <html>
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WikiEdit - Login</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/Icon.ico" />
</head>
 <body bgcolor = "black">
	<img style="position:absolute;right:100px;top:100px;"src="images/wikilogo.jpg" alt="WIKI LOGO" width="300" height="275">
	<img style="position:relative;left:550px;top:30px;"src="images/wikiedit.jpg" alt="WIKI EDIT" width="200" height="100">
	<table>
	<tr>
	<th><font size="4" color = "white">Links for Suggested Wikipedia Articles:</th>
	</tr> 
	<?php
	foreach($res as $link)
	{
	echo "<tr>";
	echo "<tr>";
	echo "<td>";
	echo '<a href="'.$link.'" target = "_blank">'.$link.'</a>';
	echo "</td>";
	echo "</tr>";
	echo "</tr>";
	}
	?>
</table>
 
</body>
</html>
 
<?php
 //checks cookies to make sure they are logged in 
 
 if(isset($_COOKIE['ID_my_site'])) 

 { 

 	$username = $_COOKIE['ID_my_site']; 

 	$pass = $_COOKIE['Key_my_site']; 

 	 	$check = mysql_query("SELECT * FROM userreg WHERE wikiusername = '$username'")or die(mysql_error()); 

 	while($info = mysql_fetch_array( $check )) 	 

 		{ 
 

 //if the cookie has the wrong password, they are taken to the login page 

 		if ($pass != $info['password']) 

 			{ 			header("Location: login.php"); 

 			} 

 

 //otherwise they are shown the admin area	 

 	else
	

 			{ 

 echo "<a href=logout.php>Logout</a>"; 

 			} 

 		} 

 		} 

 else 

 

 //if the cookie does not exist, they are taken to the login screen 

 {			 

 header("Location: login.php"); 

 } 

 ?> 