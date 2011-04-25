<html>
<head>
	<title>User pannel</title>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
</head>
<body>
	<div class="content">
		<?php
			$user_id = 3;
			require('config.php');
			mysql_connect($location,$username,$password);
			@mysql_select_db($database) or die( "Unable to select database");
			
			$result = mysql_query("SELECT * FROM uporabniki WHERE id_uporabnik='" . $user_id . "'");
			while($row = mysql_fetch_array($result))
			{
				$company_id_query = mysql_query("SELECT id_podjetje FROM upor_podj WHERE id_uporabnik='" . $row['id_uporabnik'] . "'");
				if(mysql_num_rows($company_id_query)>0) 
				{
					$companyRow = mysql_fetch_assoc($company_id_query);
					$companyId = $companyRow['id_podjetje'];

					$company_query = mysql_query("SELECT * FROM podjetje WHERE id_podjetje='" . $companyId . "'");
					if(mysql_num_rows($company_query)>0) 
					{
						$realCompanyRow = mysql_fetch_assoc($company_query);
						$companyTitle = $realCompanyRow['naziv'];
					}
				}
				echo "<form action=\"admin.php?type=user&user_id=" . $row['id_uporabnik'] . "\" method=\"POST\" accept-charset=\"utf-8\">";
				echo "<div class=\"name\">User: " . $row['username'] . "[" . $row['ime'] . " " . $row['priimek'] . "]</div>";
				echo "<div class=\"email\">Email: " . $row['email'] . "</div>";
				$result2 = mysql_query("SELECT * FROM telefonske_st WHERE ID_user='" . $row['id_uporabnik'] . "'");
				while($townRow = mysql_fetch_array($result2))
				{
					$phone_id_query = mysql_query("SELECT ID_mesta FROM mesta_telefonske WHERE ID_telefonske='" . $townRow['ID_telefonske_st'] . "'");
					if(mysql_num_rows($phone_id_query)>0) 
					{
						$phoneRow = mysql_fetch_assoc($phone_id_query);
						$mestoId = $phoneRow['ID_mesta'];

						$town_id_query = mysql_query("SELECT mesto FROM mesta WHERE id_mesto='" . $mestoId . "'");
						if(mysql_num_rows($town_id_query)>0) 
						{
							$townRow2 = mysql_fetch_assoc($town_id_query);
							echo "<div class=\"phone\">Phone: " . $townRow['telefonske_st'] . " [" . $townRow2['mesto'] .  "]" . "</div>";
						}
					}
				}
				echo "<div class=\"company\">Company: " . $companyTitle . "</div>";
				echo "<input type=\"submit\" value=\"SAKUJO!!!\">";
				echo "</form><br>";
			}
		?>
		<div class="pannel">
			<form id="form_01" action="user.php?type=lol" method="POST" accept-charset="utf-8">
				username:<input type="text" value="somehting" />
				<input type="submit" value="change" />
			</form>
			<hr>
			<form id="form_05" action="user.php" method="POST" accept-charset="utf-8">
				email:<input type="text" value="somehting" />
				<input type="submit" value="change" />
			</form>
			<hr>
			<form id="form_02" action="user.php" method="POST" accept-charset="utf-8">
				old password:<input type="password"/><br>
				new password:<input type="password"/><br>
				repeat new password:<input type="password"/><br>
				<input type="submit" value="change" />
			</form>
			<hr>
			<form id="form_02" action="user.php" method="POST" accept-charset="utf-8">
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
				<tr>
						phone:<input type="text" value="somehting" />
						<input type="submit" value="change" />
				</tr>
			</table>
			<hr>
			<form id="form_02" action="user.php" method="POST" accept-charset="utf-8">
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
				<tr>
						phone:<input type="text" value="somehting" />
						<input type="submit" value="add" />
				</tr>
			</table>
			</form>
			<hr>
			<form id="form_02" action="user.php" method="POST" accept-charset="utf-8">
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
				<input type="submit" value="change" />
			</form>
			<hr>
			<form id="form_02" action="user.php" method="POST" accept-charset="utf-8">
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
				<input type="submit" value="change" />
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</body>
</html>
