<html>
<head>
	<title>User pannel</title>
</head>
<body>
	<div class="content">
	<form action="addCompany.php" method="POST" accept-charset="utf-8">
		Registriraj uporabnika:<br>
		Username:<input type="text" name="lol" value="asdf"><br>
		Password:<input type="password" name="lol2" value="asdf"><br>
		First Name:<input type="text" name="lol3" value="asdf"><br>
		Last Name:<input type="text" name="lol4" value="asdf"><br>
		Phone number:<input type="text" name="lol5" value="asdf"><br>
		email:<input type="text" name="lol6" value="asdf"><br>
		<input type="radio" name="town" value="added" checked="true"/>town already added
		<select name="companySelect" id="companySelect">
			<?php
			require('config.php');
			mysql_connect($location,$username,$password);
			@mysql_select_db($database) or die( "Unable to select database");
			
			$result = mysql_query("SELECT * FROM mesta ORDER BY mesto");
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"" . $row['mesto'] . "\">" . $row['mesto'] . "</option>";
			}
			?>
		</select>
		<input type="radio" name="town" value="notAdded"/>add a town
		Town:<input type="text" name="lol6" value="asdf"><br>
		<input type="radio" name="company" value="added" checked="true"/>company already added
		<select name="companySelect" id="companySelect">
			<?php
			$result = mysql_query("SELECT * FROM podjetje");
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"" . $row['naziv'] . "\">" . $row['naziv'] . "</option>";
			}
			?>
		</select>
		<input type="radio" name="company" value="notAdded"/>create new company
		Name:<input type="text" name="lol3" value="asdf"><br>
		Street:<input type="text" name="lol4" value="asdf"><br>
		<input type="radio" name="town" value="added" checked="true"/>town already added
		<select name="companySelect" id="companySelect">
			<?php
			require('config.php');
			mysql_connect($location,$username,$password);
			@mysql_select_db($database) or die( "Unable to select database");
			
			$result = mysql_query("SELECT * FROM mesta ORDER BY mesto");
			while($row = mysql_fetch_array($result))
			{
				echo "<option value=\"" . $row['mesto'] . "\">" . $row['mesto'] . "</option>";
			}
			?>
		</select>
		<input type="radio" name="town" value="notAdded"/>add a town
		Town:<input type="text" name="lol6" value="asdf"><br>
		Responsible person:<input type="text" name="lol5" value="asdf"><br>
		Phone:<input type="text" name="lol6" value="asdf"><br>
		Mail:<input type="text" name="lol6" value="asdf"><br>
		website:<input type="text" name="lol6" value="asdf"><br>
		desciption:<input type="text" name="lol6" value="asdf"><br>
	<p><input type="submit" value="Continue"></p>
	</form>
	</div>
</body>
</html>
