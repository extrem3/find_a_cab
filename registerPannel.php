<html>
<head>
	<title>User pannel</title>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
</head>
<body>
	<div class="content">
	<form action="register.php" method="POST" accept-charset="utf-8">
		Registriraj uporabnika:<br>
		Username:<input type="text" name="username"><br>
		Password:<input type="password" name="password"><br>
		Repeat password:<input type="password" name="passwordCheck"><br>
		First Name:<input type="text" name="name"><br>
		Last Name:<input type="text" name="lastName"><br>
		email:<input type="text" name="email"><br>
		<br>
		<br>
		<input type="checkbox" name="cabOwner">Taxi driver
		<table>
			<tr>
				<td style="vertical-align: top; width: 200px">
					<input type="radio" name="town" value="added" checked="true"/>town already added
					<select name="townSelect" id="townSelect">
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
					Town:<input type="text" name="newTown"><br>
				</td>
			</tr>
		</table>
		Phone number:<input type="text" name="phone"><br>
		<br>
		<br>
		<input type="checkbox" name="companyOwner">Company owner
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
					Name:<input type="text" name="companyName"><br>
					Street:<input type="text" name="companyStreet"><br>
					<table>
						<tr>
							<td style="vertical-align: top; width: 200px">
								<input type="radio" name="companyTown" value="added" checked="true"/>town already added
								<select name="companyTownSelect" id="companyTownSelect">
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
								<input type="radio" name="companyTown" value="notAdded"/>add a town<br>
								Town:<input type="text" name="newCompanyTown"><br>
							</td>
						</tr>
					</table>
					Responsible person:<input type="text" name="companyInCharge"><br>
					Phone:<input type="text" name="companyPhone"><br>
					Mail:<input type="text" name="companyMail"><br>
					website:<input type="text" name="companyWebsite"><br>
					desciption:<input type="text" name="companyDescription"><br>
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