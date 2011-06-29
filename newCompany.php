<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php 
require('data.php'); require('checkLogin.php');?>
<html>
<head>
	<title>Pogosto zastavljena sprašanja</title>
	<link rel="stylesheet" type="text/css" href="css/newCompany.css">
</head>
<body>
	<div id="header">
		<div id="najdiTaxi">&nbsp;</div>
	</div>
	<div id="topRow">
		<div id="welcomeInformation">Dobrodošli! Nahajate se na Vaši administrativni strani, kjer lahko urejate Vaše podatke.</div>
	</div>
	<div id="content">
		<div id="boxName">Popolna sprememba podjetja<a href="#" id="backLink" onclick="history.go(-1);return false;">Nazaj</a></div>
		<!-- this code was previously in userPannel.php -->
		<form id="addCompany" action="user.php?type=addCompany" method="POST" accept-charset="utf-8">
			Izberite med že vpisanim podjetjem, ali pa vpišite novo:
			<table id="table">
				<tr>
					<td id="inDatabase">
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
					<td id="or">
						ALI
					</td>
					<td id="new">
						<input type="radio" name="company" value="notAdded"/>Vpišite novo podjetje<br>
						<table>
						<tr><td>Naziv podjetja:</td><td><input type="text" name="companyName"></td></tr>
						<tr><td>Ulica:</td><td><input type="text" name="companyStreet"></td></tr>
						<tr><td>Mesto:</td><td><input type="text" name="companyTown"></td></tr>
						<tr><td>Odgovorna oseba:</td><td><input type="text" name="companyInCharge"></td></tr>
						<tr><td>Telefon:</td><td><input type="text" name="companyPhone"></td></tr>
						<tr><td>Fax:</td><td><input type="text" name="companyFax"></td></tr>
						<tr><td>Spletna pošta:</td><td><input type="text" name="companyMail"></td></tr>
						<tr><td>Spletna stran:</td><td><input type="text" name="companyWebsite"></td></tr>
						<tr><td>Opis:</td><td><input type="text" name="companyDescription"></td></tr>
						<tr><td>&nbsp;</td><td><input type="submit" value="Spremeni" /></td></tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="bottom">&nbsp;</div> <!-- leave this alone -->
	<div id="footer">
		<div id="footer-font">Lorem ipsum dolor sit amet, consectetur adipiscing elit. (c) 2011</div>
	</div>
</body>
</html>
