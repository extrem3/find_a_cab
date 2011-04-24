<?php
require('config.php');

mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

//password checking and hashing to be added still!!!
if($_GET['type'] == "user")
{
	mysql_query("DELETE FROM uporabniki WHERE username=" . $_GET['user'] . " AND email=" . $_GET['email']);
}
