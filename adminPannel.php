<html>
<head>
	<title>User pannel</title>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
</head>
<body>
	<div class="content">
		<div class="removeUser">Remove User:<br>
		<?php
			require('config.php');
			mysql_connect($location,$username,$password);
			@mysql_select_db($database) or die( "Unable to select database");
			
			$result = mysql_query("SELECT * FROM uporabniki ORDER BY username");
			while($row = mysql_fetch_array($result))
			{
				echo "<form action=\"admin.php?type=user&user_id=" . $row['id_uporabnik'] . "\" method=\"POST\" accept-charset=\"utf-8\">";
				echo "<div class=\"name\">" . $row['username'] . "</div>";
				echo "<div class=\"email\">" . $row['email'] . "</div>";
				echo "<input type=\"submit\" value=\"SAKUJO!!!\">";
				echo "</form><br>";
			}
		?>
		</div>
	</div>
</body>
</html>
