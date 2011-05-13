<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_level']))
{
	$user_id = $_SESSION['user_id'];
	$user_level = $_SESSION['user_level'];
}else
{
	header("Location: loginPannel.php?failed=failedLOL");
}
?>
