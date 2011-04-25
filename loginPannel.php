<?php

session_destroy();
?>

<html>
<head>
	<title>Login</title>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script> 
</head>
<body>
	<div class="content">
		<div class="pannel">
			<form id="login" action="login.php" method="POST" accept-charset="utf-8">
				Username:<input type="text" name="username"/><br>
				Password:<input type="password" name="password"/><br>
				<input type="submit" value="Login" />
			</form>
		</div>
	</div>
</body>
</html>
