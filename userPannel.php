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
    var errors = new Array(new Array(0, 1, "username"),
                           new Array(0, 2, "email"),
                           new Array(0, 3, "email"),
                           new Array(2, 4, "phone"),
                           new Array(2, 5, "phone"),
                           new Array(0, 6, "password"),
                           new Array(4, 7, "companyMail"),
                           new Array(4, 8, "companyPhone"),
                           new Array(0, 9, "username"),
                           new Array(0, 10, "name"),
                           new Array(0, 11, "lastName"),
                           new Array(2, 12, "newTown"),
                           new Array(4, 13, "companyName"),
                           new Array(4, 14, "companyStreet"),
                           new Array(4, 15, "companyInCharge"),
                           new Array(4, 16, "newCompanyTown"));
		$('#leftColumn input').css("backgroundColor", "#616161" );
		$('#leftColumn input').css("border", "none" );
		$(".expandingBody").hide();
		$(".expandingBody").hide();
    if($("#values_phone1").length == 0)
    {
      $("#addNumber").removeClass("expandingHeader");
      $("#addNumber").html("Dodajte novo številko");
      $("#addNumber").next().show();
    }else
    {
      $("#addNumber").html("Če želite dodati številko kliknite TUKAJ");
    }
		$('.expandingHeader').css("cursor", "pointer" );
		$('#leftColumn input').focus( function() {
			$(this).animate({ backgroundColor: "#ffffff" }, 300);
			$(this).css("color", "#ff0000");
		});
		$('#leftColumn input').blur( function() {
			$(this).animate({ backgroundColor: "#616161" }, 300);
		});
		$(".expandingHeader").click(function() {
			$(this).next().slideToggle("fast");
		})
		$('#phoneNumbers form').submit(onSubmitDeletePhone);
    function onSubmitDeletePhone(event)
    {
			var formContents = $(this).serialize();
      var clickedOn = event.currentTarget.id;
			bodyContent = $.ajax({
				url: "user.php?type=phone",
				global: false,
				type: "POST",
				data: formContents,
				dataType: "html",
				async:false,
				success: function(msg){
					var doneArray = msg.match(/done/g);
					if (doneArray != null && doneArray.length > 0)
					{
            $('#values_' + clickedOn).fadeOut('fast', function (){
              $('#values_' + clickedOn).remove();
            });
					}
				}
			}).responseText;
			return false;
    }
		$('#addPhone').submit(function(event) {
			var formContents = $(this).serialize();
			bodyContent = $.ajax({
				url: "user.php?type=addPhone",
				global: false,
				type: "POST",
				data: formContents,
				dataType: "html",
				async:false,
				success: function(msg){
					var doneArray = msg.match(/done/g);
					if (doneArray != null && doneArray.length > 0)
					{
            console.log($('input[name$="phone"]').val());
            var phoneId = 3;
            var phoneNumberVal = $('#addPhone input[name$="phone"]').val();
            var townVal = $('#addPhone input[name$="newTown"]').val();
            $("#phoneTable").find("tbody").append("<tr id='values_phone" + phoneId + "' class='values'>" + 
                "<td>" + phoneNumberVal + "</td>" + 
                "<td>" + townVal + "</td>" + 
                "<td>" + 
                "<form id='phone" + phoneId + "' accept-charset='utf-8' method='POST' action='user.php?type=phone'>" + 
                "<input type='hidden' value='" + phoneNumberVal + "' name='phone'>" + 
                "<input type='submit' class='delete' value='X'></form>" + 
                "</td>" + 
                "</tr>")
            $('#phoneNumbers form').submit(onSubmitDeletePhone);
            $("#addPhoneError").html("");
          } else
          {
            $("#addPhoneError").html(msg);
          }
				}
			}).responseText;
			return false;
		});
    

	});
	</script>
</head>
<body>
	<div id="header">
		<div id="najdiTaxi">&nbsp;</div>
	</div>
	<div id="topRow">
		<div id="welcomeInformation">Dobrodošli, <i><?php echo getUsername($user_id); ?></i>. Nahajate se na administrativni strani, kjer lahko urejate svoje podatke.</div>
		<div id="topLogout"><a href="login.php?logout=true">Odjava</a></div>
	</div>
	<div class="content">
		<div class="pannel"> <!-- i don't need div.pannel, if it's not necessary you can remove this line and the mathing one at the end of the file -->
			<div id="leftColumn">
				<div class="detailInformations">
					<div class="boxName">Vaši podatki</div>
					
					<form id="name" action="user.php?type=all<?php if (getCompany($user_id) != "") {echo '&companyOwner=true';} ?>" method="POST" accept-charset="utf-8">
					Osebni podatki
					<table id="personalInformation">
						<tr><td>Ime:</td><td><input type="text" name="name" value="<?php $nameArray = (array)getName($user_id); echo $nameArray[0]; ?>" /></td></tr>
						<tr><td>Priimek:</td><td><input type="text" name="lastName" value="<?php echo $nameArray[1]; ?>" /></td></tr>
						<!-- <input type="submit" value="Spremeni" /> -->
						<tr><td>Naslov spletne pošte:</td><td><input type="text" name="email" value="<?php echo getEmail($user_id); ?>" /></td></tr>
					</table>
					<hr>
					
					Podatki Vašega NajdiTaxi računa
					<table id="personalInformation">
						<tr><td>Uporabniško ime:</td><td><?php echo getUsername($user_id); ?></td></tr>
						<tr><td>Staro geslo:</td><td><input type="password" name="oldPassword"/></td></tr>
						<tr><td>Novo geslo:</td><td><input type="password" name="password"/></td></tr>
						<tr><td>Ponovite geslo:</td><td><input type="password" name="passwordCheck"/></td></tr>
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
					Če ste ustvarili novo podjetje ali pa se želite pridružiti že obstoječemu podjetju kliknite <a href="newCompany.php" id="newCompany">TUKAJ</a>.<i>(če želite spremeniti podatke Vašega podjetja pa to storite zgoraj).</i>
					<!-- here was newCompany.php code -->
					<div id="editSettings">
						<!-- we need some backend support here -->
						<input type="submit" value="Shrani" />
					</div>
					</form>
				</div>
				<div class="emptyRow">&nbsp;</div>
				<div class="detailInformations">
					<div class="boxName">Statistika</div>
					<div id="statistic">
					Št. prikazov vaših kontaktov:<br />
					Ocena uporabnikov:
					</div>
					<div id="statisticNumbers">
					<!-- need some support here -->
					<?php 
						$resultUserShown = mysql_query("SELECT prikazov FROM uporabniki WHERE id_uporabnik='$user_id'"); 
						echo mysql_result($resultUserShown, 0);
					?>
					<br />
					5
					</div>
				</div>
				<div class="bottom">&nbsp;</div>
			</div>
			<div id="centerCross">&nbsp;</div>
			<div id="rightColumn">
				<div class="detailInformations">
					<div class="boxName">Vpišite / uredite telefonske številke</div>
					<div id="phoneNumbers">
						<?php
							$phoneNumbersArray = (array)getPhoneNumbers($user_id);
							$townNamesArray = (array)getTowns();
							$i = 0;
              if(count($phoneNumbersArray) > 0)
              {
                echo '<table id="phoneTable">';
                echo '<tr>';
                echo '<th id="telephoneNumber">Telefonska številka:</th>';
                echo '<th id="city">Mesto:</th>';
                echo '<th>Zbriši:</th>';
                echo '</tr>';
                foreach($phoneNumbersArray as $values)
                {
                  $i ++;
                  echo '<tr class="values" id="values_phone' . $i . '">';
                  echo '<td>' . $values[0] . '</td>' . ' <td>' . $values[1] . '</td>';
                  echo '<td>';
                  echo '<form id="phone' . $i . '" action="user.php?type=phone" method="POST" accept-charset="utf-8">';
                  echo '<input type="hidden" name="phone" value="' . $values[0] . '">';
                  echo '<input type="submit" value="X" class="delete">'; 
                  echo '</form>';
                  echo '</td>';
                  echo '</tr>';
                }
                echo '</table>';
                echo '<hr>';
              }
						?>
						</table>
					</div>
					<div class="expandingText">
						<div class="expandingHeader" id="addNumber"></div>
						<div class="expandingBody">
							<form id="addPhone" action="user.php?type=addPhone" method="POST" accept-charset="utf-8">
								Mesto:<input type="text" name="newTown"><br>
								Telefon:<input type="text" name="phone" />
                <div id="addPhoneError"></div>
								<input type="submit" value="Dodaj" />
							</form>
						</div>
					</div>
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
