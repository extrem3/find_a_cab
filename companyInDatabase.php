<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php 
require('data.php'); require('checkLogin.php');?>
<html>
<head>
	<title>Sprememba podjetja</title>
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
			Podjetje je že zapisano v bazi:
			<table id="table">
				<tr>
					<td id="inDatabase">
						<select name="companySelect" id="companySelect">
							<?php
							$result = mysql_query("SELECT * FROM podjetje");
							while($row = mysql_fetch_array($result))
							{
								echo "<option value=\"" . $row['naziv'] . "\">" . $row['naziv'] . "</option>";
							}
							?>
						</select>
						<tr><td>&nbsp;</td><td><input type="submit" value="Spremeni" /></td></tr>
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
