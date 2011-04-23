<html>
<head>
	<title>User pannel</title>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
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
		<table>
			<tr>
				<td style="vertical-align: top; width: 200px">
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
				</td>
				<td style="vertical-align: top; width: 50px">
					OR
				</td>
				<td style="vertical-align: top; width: 500px">
					<input type="radio" name="town" value="notAdded"/>add a town<br>
					Town:<input type="text" name="lol6" value="asdf"><br>
				</td>
			</tr>
		</table>

		<table>
			<tr>
				<td style="vertical-align: top; width: 200px">
					<input type="radio" name="company" value="added" checked="true"/>company already added
					<br>
					<select name="companySelect" id="companySelect">
						<?php
						$result = mysql_query("SELECT * FROM podjetje");
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row['naziv'] . "\">" . $row['naziv'] . "</option>";
						}
						?>
					</select>
				</td>
				<td style="vertical-align: top; width: 50px">
					OR
				</td>
				<td style="vertical-align: top; width: 500px">
					<input type="radio" name="company" value="notAdded"/>create new company<br>
					Name:<input type="text" name="lol3" value="asdf"><br>
					Street:<input type="text" name="lol4" value="asdf"><br>
					<table>
						<tr>
							<td style="vertical-align: top; width: 200px">
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
							</td>
							<td style="vertical-align: top; width: 50px">
								OR
							</td>
							<td style="vertical-align: top; width: 500px">
								<input type="radio" name="town" value="notAdded"/>add a town<br>
								Town:<input type="text" name="lol6" value="asdf"><br>
							</td>
						</tr>
					</table>
					Responsible person:<input type="text" name="lol5" value="asdf"><br>
					Phone:<input type="text" name="lol6" value="asdf"><br>
					Mail:<input type="text" name="lol6" value="asdf"><br>
					website:<input type="text" name="lol6" value="asdf"><br>
					desciption:<input type="text" name="lol6" value="asdf"><br>
				</td>
			</tr>
		</table>
		<div style="display:blockk">
		<br>
		<input type="submit" value="Register">
		</div>
	</form>
	</div>
</body>
</html>
