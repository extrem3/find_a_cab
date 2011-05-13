<?php
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_level']))
{
	$user_id = $_SESSION['user_id'];
	$user_level = $_SESSION['user_level'];
}else
{
	header("Location: loginPannel.php?failed=true");
}
?>
