<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php 
require('data.php'); require('checkLogin.php');?>
<html>
<head>
	<title>Uporabniški račun</title>
	<link rel="stylesheet" type="text/css" href="css/userPannel.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$(function() {
		$('#leftColumn input').css("backgroundColor", "#616161" );
		$('#leftColumn input').css("border", "none" );
		$('#leftColumn input').focus( function() {
			$(this).animate({ backgroundColor: "#ffffff" }, 300);
			$(this).css("color", "#ff0000");
		});
		$('#leftColumn input').blur( function() {
			$(this).animate({ backgroundColor: "#616161" }, 300);
		});
		$(".expandingBody").hide();
		$(".expandingHeader").click(function() {
			$(this).next().slideToggle("fast");
		})
	})
	</script>
</head>
<body>
	<div id="header">
		<div id="najdiTaxi">&nbsp;</div>
	</div>
	<div id="topRow">
		<div id="welcomeInformation">Dobrodošli, <i><?php echo getUsername($user_id); ?></i>. Nahajate se na administrativni strani, kjer lahko urejate svoje podatke.</div>
		<div id="topLogout"><a href="login.php?logout=true">Odjava</a></div> <!-- we need some php support here :) -->
	</div>
	<div class="content">
		<div class="pannel"> <!-- i don't need div.pannel, if it's not necessary you can remove this line and the mathing one at the end of the file -->
			<div id="leftColumn">
				<div class="detailInformations">
					<div class="boxName">Vaši podatki</div>
					
					Osebni podatki
					<table id="personalInformation">
					<form id="name" action="user.php?type=name" method="POST" accept-charset="utf-8">
						<tr><td>Ime:</td><td><input type="text" name="name" value="<?php $nameArray = (array)getName($user_id); echo $nameArray[0]; ?>" /></td></tr>
						<tr><td>Priimek:</td><td><input type="text" name="lastName" value="<?php echo $nameArray[1]; ?>" /></td></tr>
						<!-- <input type="submit" value="Spremeni" /> -->
					</form>
					<form id="email" action="user.php?type=email" method="POST" accept-charset="utf-8">
						<tr><td>Naslov spletne pošte:</td><td><input type="text" name="email" value="<?php echo getEmail($user_id); ?>" /></td></tr>
						<!-- <input type="submit" value="Spremeni" /> -->
					</form>
					</table>
					<hr>
					
					Podatki Vašega NajdiTaxi računa
					<table id="personalInformation">
					<form id="username" action="user.php?type=username" method="POST" accept-charset="utf-8">
						<tr><td>Uporabniško ime:</td><td><input type="text" name="username" value="<?php echo getUsername($user_id); ?>" /></td></tr>
						<!-- <input type="submit" value="Spremeni" /> -->
					</form>
					<form id="password" action="user.php?type=password" method="POST" accept-charset="utf-8">
						<tr><td>Staro geslo:</td><td><input type="password" name="oldPassword"/></td></tr>
						<tr><td>Novo geslo:</td><td><input type="password" name="password"/></td></tr>
						<tr><td>Ponovite geslo:</td><td><input type="password" name="passwordCheck"/></td></tr>
						<!-- <input type="submit" value="Spremeni" /> -->
					</form>
					</table>
					
					<?php
						$companyArray = (array)getCompany($user_id);
						if(count($companyArray) > 1)
						{
							echo '<hr>Podatki Vašega podjetja<table id="personalInformation">';
							echo '<form id="company" action="user.php?type=company" method="POST" accept-charset="utf-8">';
							echo '<tr><td>Naziv podjetja:</td><td><input type="text" name="companyName" value="' . $companyArray[0] . '"></td></tr>';
							echo '<tr><td>Ulica:</td><td><input type="text" name="companyStreet" value="' . $companyArray[1] . '"></td></tr>';
							echo '<tr><td>Mesto:</td><td><input type="text" name="companyTown" value="' . $companyArray[2] . '"></td></tr>';
							echo '<tr><td>Odgovorna oseba:</td><td><input type="text" name="companyInCharge" value="' . $companyArray[3] . '"></td></tr>';
							echo '<tr><td>Telefon:</td><td><input type="text" name="companyPhone" value="' . $companyArray[4] . '"></td></tr>';
							echo '<tr><td>Fax:</td><td><input type="text" name="companyFax" value="' . $companyArray[5] . '"></td></tr>';
							echo '<tr><td>Mail:</td><td><input type="text" name="companyMail" value="' . $companyArray[6] . '"></td></tr>';
							echo '<tr><td>Spletna stran:</td><td><input type="text" name="companyWebsite" value="' . $companyArray[7] . '"></td></tr>';
							echo '<tr><td>Opis:</td><td><input type="text" name="companyDescription" value="' . $companyArray[8] . '"></td></tr>';
							echo '<!-- <input type="submit" value="change" /> -->';
							echo '</form></table>';
						}
					?>
					<hr>
					Če ste ustvarili novo podjetje ali pa se želite pridružiti že obstoječemu podjetju kliknite <a href="newCompany.php" id="newCompany">TUKAJ</a>.(če želite spremeniti podatke Vašega podjetja pa to storite zgoraj).
					<!-- here was newCompany.php code -->
					<div id="editSettings">
						<!-- we need some backend support here -->
						<a href="#" class="edit">Uredi</a>
						<a href="#" class="edit">Shrani</a>
					</div>
				</div>
				<div class="emptyRow">&nbsp;</div>
				<div class="detailInformations">
					<div class="boxName">Statistika</div>
					Št. prikazov vaših kontaktov:<br />
					Ocena uporabnikov:
				</div>
				<div class="bottom">&nbsp;</div>
			</div>
			<div id="centerCross">&nbsp;</div>
			<div id="rightColumn">
				<div class="detailInformations">
					<div class="boxName">Vpišite / uredite telefonske številke</div>
					<div id="phoneNumbers">
						<table id="phoneTable">
						<tr>
							<th id="telephoneNumber">Telefonska številka:</th>
							<th id="city">Mesto:</th>
							<th>Zbriši:</th>
						</tr>
						<?php
							$phoneNumbersArray = (array)getPhoneNumbers($user_id);
							$townNamesArray = (array)getTowns();
							$i = 0;
							foreach($phoneNumbersArray as $values)
							{
								$i ++;
								echo '<form id="phone' . $i . '" action="user.php?type=phone" method="POST" accept-charset="utf-8">';
								echo '<tr class="values"><td>' . $values[0] . '</td>' . ' <td>' . $values[1] . '</td>';
								echo '<input type="hidden" name="phone" value="' . $values[0] . '">';
								echo '<td><input type="submit" value="X" class="delete"></td></tr>';
								echo '</form>';
							}
						?>
						</table>
					</div>
					<hr>
					<form id="addPhone" action="user.php?type=addPhone" method="POST" accept-charset="utf-8">
						Mesto:<input type="text" name="newTown"><br>
						Telefon:<input type="text" name="phone" value="1112223" />
						<input type="submit" value="Dodaj" />
					</form>
				</div>
				<div class="emptyRow">&nbsp;</div>
				<div class="detailInformations">
					<div class="boxName">Splošne informacije</div>
					<div class="expandingText">
						<div class="expandingHeader">Obvestila uporabnikom spletnega portala najdiTAXI.si</div>
						<div class="expandingBody">some text bla bla bla</div>
					</div>
					<a href="FAQ.php" id="FAQ">Pogosto zastavljena vprašanja</a><br>
					<div class="expandingText">
						<div class="expandingHeader"> Pogoji uporabe spletnega portala najdiTAXI.si</div>
						<div class="expandingBody">some text bla bla bla</div>
					</div>
					Predlogi za spremembe, dopolnitve..<br>
					Imate vprašanje? Kontaktirajte skrbnika spletnega portala!<br>
				</div>
				<div class="bottom">&nbsp;</div>
			</div>	
		</div>
	</div>
	<div id="footer">
		<div id="footer-font">Lorem ipsum dolor sit amet, consectetur adipiscing elit. (c) 2011</div>
	</div>
</body>
</html>
