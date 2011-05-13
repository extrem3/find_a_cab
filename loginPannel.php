<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Login</title>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script> 
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
		body {
			background: #333333 url(img/dark_grey_noise_bg.png) repeat-x;
		}
	</style>
</head>
<body>
	<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();
	if(isset($_SESSION['user_id']) && isset($_SESSION['user_level']))
	{
			echo '<div id="wrongLogin">Ste ze prijavljeni v sistem!';
			echo '<a href="login.php?logout=true">odjavi me!</a>';
			echo '</div>';
	}else
	{
		echo '<div class="login-pannel">';
		if(isset($_GET['failed']))
		{
			echo '<div id="wrongLogin">Napacno uporabnisko ime ali geslo</div>';
		}
		echo '<form id="login" action="login.php" method="POST" accept-charset="utf-8">';
		echo 'Uporabniško ime:<input type="text" name="username" id="username-input" /><br>';
		echo 'Geslo:<input type="password" name="password" id="pass-input" /><br>';
		echo '<input type="submit" value="Prijava" id="login-button" onclick="self.parent.loadLogin()" />';
		echo '</form>';
		echo '</div>';
	}
	?>
</body>
</html>
