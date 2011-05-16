<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php 
require('data.php'); require('checkLogin.php');?>
<html>
<head>
	<title>User pannel</title>
	<link rel="stylesheet" type="text/css" href="css/userPannel.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
</head>
<body>
	<div id="header">
		<div id="najdiTaxi">&nbsp;</div>
	</div>
	<div id="topRow">
		<div id="welcomeInformation">Dobrodošli, <i><?php echo getUsername($user_id); ?></i>. Nahajate se na administrativni strani, kjer lahko urejate svoje podatke.</div>
		<div id="topLogout">Odjava</div> <!-- we need some php support here :) -->
	</div>
	<div class="content">
		<div class="pannel">
			<form id="username" action="user.php?type=username" method="POST" accept-charset="utf-8">
				Uporabniško ime:<input type="text" name="username" value="<?php echo getUsername($user_id); ?>" />
				<input type="submit" value="Spremeni" />
			</form>
			<hr>
			<form id="name" action="user.php?type=name" method="POST" accept-charset="utf-8">
				Ime:<input type="text" name="name" value="<?php $nameArray = (array)getName($user_id); echo $nameArray[0]; ?>" /><br>
				Priimek:<input type="text" name="lastName" value="<?php echo $nameArray[1]; ?>" />
				<input type="submit" value="Spremeni" />
			</form>
			<hr>
			<form id="email" action="user.php?type=email" method="POST" accept-charset="utf-8">
				Spletna pošta:<input type="text" name="email" value="<?php echo getEmail($user_id); ?>" />
				<input type="submit" value="Spremeni" />
			</form>
			<hr>
			<form id="password" action="user.php?type=password" method="POST" accept-charset="utf-8">
				Staro geslo:<input type="password" name="oldPassword"/><br>
				Novo geslo:<input type="password" name="password"/><br>
				Ponovite geslo:<input type="password" name="passwordCheck"/><br>
				<input type="submit" value="Spremeni" />
			</form>
			<hr>
			<?php
				$phoneNumbersArray = (array)getPhoneNumbers($user_id);
				$townNamesArray = (array)getTowns();
				$i = 0;
				foreach($phoneNumbersArray as $values)
				{
					$i ++;
					echo '<form id="phone' . $i . '" action="user.php?type=phone" method="POST" accept-charset="utf-8">';
					echo $values[0] . ' [' . $values[1] . ']';
					echo '<input type="hidden" name="phone" value="' . $values[0] . '">';
					echo '<input type="submit" value="Odstrani">';
					echo '</form>';
				}
			?>
			<hr>
			<form id="addPhone" action="user.php?type=addPhone" method="POST" accept-charset="utf-8">
				<table>
					<tr>
						<td style="vertical-align: top; width: 200px">
							<input type="radio" name="town" value="added" checked="true"/>Mesto je že ponujeno
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
							ALI
						</td>
						<td style="vertical-align: top; width: 500px">
							<input type="radio" name="town" value="notAdded"/>Dodaj mesto<br>
							Mesto:<input type="text" name="newTown"><br>
						</td>
					</tr>
				</table>
				Telefon:<input type="text" name="phone" value="1112223" />
				<input type="submit" value="Dodaj" />
			</form>
			<?php
				$companyArray = (array)getCompany($user_id);
				if(count($companyArray) > 1)
				{
					echo '<hr>';
					echo '<form id="company" action="user.php?type=company" method="POST" accept-charset="utf-8">';
					echo 'Name:<input type="text" name="companyName" value="' . $companyArray[0] . '"><br>';
					echo 'Street:<input type="text" name="companyStreet" value="' . $companyArray[1] . '"><br>';
					echo 'Town:<input type="text" name="companyTown" value="' . $companyArray[2] . '"><br>';
					echo 'Responsible person:<input type="text" name="companyInCharge" value="' . $companyArray[3] . '"><br>';
					echo 'Phone:<input type="text" name="companyPhone" value="' . $companyArray[4] . '"><br>';
					echo 'Fax:<input type="text" name="companyFax" value="' . $companyArray[5] . '"><br>';
					echo 'Mail:<input type="text" name="companyMail" value="' . $companyArray[6] . '"><br>';
					echo 'website:<input type="text" name="companyWebsite" value="' . $companyArray[7] . '"><br>';
					echo 'desciption:<input type="text" name="companyDescription" value="' . $companyArray[8] . '"><br>';
					echo '<input type="submit" value="change" />';
					echo '</form>';
				}
			?>
			<hr>
			<form id="addCompany" action="user.php?type=addCompany" method="POST" accept-charset="utf-8">
			Spremenil sem podjetje, prosim prestavite me:
			<table>
				<tr>
					<td style="vertical-align: top; width: 200px">
						<input type="radio" name="company" value="added" checked="true"/>Podjetje je že med ponujenimi
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
						ALI
					</td>
					<td style="vertical-align: top; width: 500px">
						<input type="radio" name="company" value="notAdded"/>Vpišite novo podjetje<br>
						Naziv podjetja:<input type="text" name="companyName"><br>
						Ulica:<input type="text" name="companyStreet"><br>
						Mesto:<input type="text" name="companyTown"><br>
						Odgovorna oseba:<input type="text" name="companyInCharge"><br>
						Telefon:<input type="text" name="companyPhone"><br>
						Fax:<input type="text" name="companyFax"><br>
						Spletna pošta:<input type="text" name="companyMail"><br>
						Spletna stran:<input type="text" name="companyWebsite"><br>
						Opis:<input type="text" name="companyDescription"><br>
						<input type="submit" value="Spremeni" />
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</body>
</html>
