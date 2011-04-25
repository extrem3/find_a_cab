<html>
<head>
	<title>User pannel</title>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<?php $user_id = 3; require('data.php'); ?>
</head>
<body>
	<div class="content">
		<div class="pannel">
			<form id="username" action="user.php?type=username" method="POST" accept-charset="utf-8">
				username:<input type="text" name="username" value="<?php echo getUsername($user_id); ?>" />
				<input type="submit" value="change" />
			</form>
			<hr>
			<form id="name" action="user.php?type=name" method="POST" accept-charset="utf-8">
				name:<input type="text" name="name" value="<?php $nameArray = (array)getName($user_id); echo $nameArray[0]; ?>" /><br>
				last name:<input type="text" name="lastName" value="<?php echo $nameArray[1]; ?>" />
				<input type="submit" value="change" />
			</form>
			<hr>
			<form id="email" action="user.php?type=email" method="POST" accept-charset="utf-8">
				email:<input type="text" name="email" value="<?php echo getEmail($user_id); ?>" />
				<input type="submit" value="change" />
			</form>
			<hr>
			<form id="password" action="user.php?type=password" method="POST" accept-charset="utf-8">
				old password:<input type="password" name="oldPassword"/><br>
				new password:<input type="password" name="password"/><br>
				repeat new password:<input type="password" name="passwordCheck"/><br>
				<input type="submit" value="change" />
			</form>
			<hr>
			<?php
				$phoneNumbersArray = (array)getPhoneNumbers($user_id);
				$townNamesArray = (array)getTowns();
				foreach($phoneNumbersArray as $values)
				{
					$i ++;
					echo '<form id="phone' . $i . '" action="user.php?type=phone" method="POST" accept-charset="utf-8">';
					echo $values[0] . ' [' . $values[1] . ']';
					echo '<input type="hidden" name="phone" value="' . $values[0] . '">';
					echo '<input type="submit" value="remove">';
					echo '</form>';
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
									$townNamesArray = (array)getTowns();
									foreach($townNamesArray as $values)
									{
										echo '<option value="' . $values . '">' . $values . '</option>';
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
				phone:<input type="text" value="somehting" />
				<input type="submit" value="add" />
			</form>
			<?php
				$companyArray = (array)getCompany($user_id);
				if(count($companyArray) > 1)
				{
					echo '<hr>';
					echo '<form id="form_02" action="user.php" method="POST" accept-charset="utf-8">';
					echo 'Name:<input type="text" name="companyName" value="' . $companyArray[0] . '"><br>';
					echo 'Street:<input type="text" name="companyStreet" value="' . $companyArray[1] . '"><br>';
					echo 'Town:<input type="text" name="newCompanyTown" value="' . $companyArray[2] . '"><br>';
					echo 'Responsible person:<input type="text" name="companyInCharge" value="' . $companyArray[3] . '"><br>';
					echo 'Phone:<input type="text" name="companyPhone" value="' . $companyArray[4] . '"><br>';
					echo 'Fax:<input type="text" name="companyPhone" value="' . $companyArray[5] . '"><br>';
					echo 'Mail:<input type="text" name="companyMail" value="' . $companyArray[6] . '"><br>';
					echo 'website:<input type="text" name="companyWebsite" value="' . $companyArray[7] . '"><br>';
					echo 'desciption:<input type="text" name="companyDescription" value="' . $companyArray[8] . '"><br>';
					echo '<input type="submit" value="change" />';
					echo '</form>';
				}
			?>
			<hr>
			<form id="form_02" action="user.php" method="POST" accept-charset="utf-8">
			I changed my company, so please move me to:
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
