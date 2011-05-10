<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
session_destroy();
?>
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
		<div class="login-pannel">
			<?php 
			if($_GET['failed'] == "true")
			{
				echo '<div id="wrongLogin">Napacno uporabnisko ime ali geslo</div>';
			} else if($_GET['failed'] == "maybe")
			{
				echo '<div id="wrongLogin">Prosimo ponovno vpisite vase uporabnisko ime in geslo</div>';
			}
			?>
			<form id="login" action="login.php" method="POST" accept-charset="utf-8">
				Uporabniško ime:<input type="text" name="username" id="username-input" /><br>
				Geslo:<input type="password" name="password" id="pass-input" /><br>
				<input type="submit" value="Prijava" id="login-button" onclick="self.parent.loadLogin()" />
			</form>
		</div>
</body>
</html>
