<html>
<head>
	<title>User pannel</title>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<?php $user_id = 3; require('data.php'); ?>
</head>
<body>
	<div class="content">
		<div class="pannel">
			<form id="form_01" action="user.php?type=lol" method="POST" accept-charset="utf-8">
				username:<input type="text" value="<?php echo getUsername($user_id); ?>" />
				<input type="submit" value="change" />
			</form>
			<hr>
			<form id="form_05" action="user.php" method="POST" accept-charset="utf-8">
				email:<input type="text" value="<?php echo getEmail($user_id); ?>" />
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
			<?php
				$phoneNumbersArray = (array)getPhoneNumbers($user_id);
				$townNamesArray = (array)getTowns();
				foreach($phoneNumbersArray as $values)
				{
					echo '<form id="form_02" action="user.php" method="POST" accept-charset="utf-8">';
					echo '<table>';
					echo '<tr>';
					echo '<td style="vertical-align: top; width: 200px">';
					echo '<input type="radio" name="town" value="added" checked="true"/>town already added';
					echo '<select name="townSelect" id="townSelect">';

					foreach($townNamesArray as $values2)
					{
						if ($values2 == $values[1])
						{
							echo '<option value="' . $values2 . '" selected="selected">' . $values2 . '</option>';
						}else
						{
							echo '<option value="' . $values2 . '">' . $values2 . '</option>';
						}
					}
					echo '</select>';
					echo '</td>';
					echo '<td style="vertical-align: top; width: 50px">';
					echo 'OR';
					echo '</td>';
					echo '<td style="vertical-align: top; width: 500px">';
					echo '<input type="radio" name="town" value="notAdded"/>add a town<br>';
					echo 'Town:<input type="text" name="newTown"><br>';
					echo '</td>';
					echo '</tr>';
					echo '</table>';
					echo 'Phone:<input type="text" name="newTown" value="' . $values[0] . '">';
					echo '<input type="submit" value="change">';
					echo '</form>';
					// echo $values[0] . ": " . $values[1] . "<br>";
				}
			?>
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
