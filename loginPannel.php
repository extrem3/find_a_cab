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
</head>
<body>
	<div id="header">
		<div id="name">&nbsp;</div>
	</div>
		<div class="pannel">
			<form id="login" action="login.php" method="POST" accept-charset="utf-8">
				Uporabniško ime:<input type="text" name="username" id="username-input" /><br>
				Geslo:<input type="password" name="password" id="pass-input" /><br>
				<input type="submit" value="Prijava" id="login-button" />
			</form>
		</div>
	<div id="footer"><div id="footer-font">vsa vsebina je last njenih izdelovalcev (c) 2011</div></div>
</body>
</html>
