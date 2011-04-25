<?php
session_start();
unset($_SESSION['user_id']);
require('config.php');
mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

foreach(array_keys($_POST) as $key)
{
	$clean[$key] = mysql_real_escape_string($_POST[$key]);
}

echo $_SESSION['user_id'];
$loginQuery = mysql_query("SELECT id_uporabnik FROM uporabniki WHERE username='" . $clean['username'] . "' AND geslo='" . $clean['password'] . "'");
if(mysql_num_rows($loginQuery)>0) 
{
	$loginRow = mysql_fetch_assoc($loginQuery);
	$_SESSION['user_id'] = $loginRow['id_uporabnik'];
	$_SESSION['user_level'] = $loginRow['nivo'];
	header("Location: userPannel.php");
}

?>
