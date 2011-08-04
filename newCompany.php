<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php 
require('data.php'); require('checkLogin.php');?>
<html>
<head>
	<title>Sprememba podjetja</title>
	<link rel="stylesheet" type="text/css" href="css/newCompany.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript">
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
						   new Array(4, 16, "companyTown"));
	$(document).ready(function() {
		$('input').css("background-color", "#cccccc")

		$('input').focus( function() {
			$(this).animate({ backgroundColor: "#ffffff" }, 300);
		});
		$('input').blur( function() {
			$(this).animate({ backgroundColor: "#cccccc" }, 300);
		});
		$('form').submit(function() {
			var formContents = $(this).serialize();
			bodyContent = $.ajax({
				url: "user.php?type=addCompany",
				global: false,
				type: "POST",
				data: formContents,
				dataType: "html",
				async:false,
				success: function(msg){
					$('form#submit').hide();
					var doneArray = msg.match(/done/g);
					if (doneArray != null && doneArray.length > 0)
					{
            alert("done");
					}else
					{
						stripErrors(msg);
					}
				}
			}).responseText;
			return false;
		});
    var tempErrors = new Array();
    function stripErrors(e)
    {
      for (var i = 0; i < tempErrors.length; ++i)
      {
        for (var j = 0; j < errors.length; ++j)
        {
          if (tempErrors[i] == errors[j][1])
          {
            $('input[name=' + errors[j][2] + ']').animate({ backgroundColor: "#ffffff" }, 300);
            break;
          }
        }
      }
      tempErrors = e.match(/\d+/g);
      var first = 9;
      for (var i = 0; i < tempErrors.length; ++i)
      {
        for (var j = 0; j < errors.length; ++j)
        {
          if (tempErrors[i] == errors[j][1])
          {
            $('input[name=' + errors[j][2] + ']').animate({ backgroundColor: "#e97c34" }, 300);
            break;
          }
        }
      }
    }
  });
  </script>
</head>
<body>
	<div id="header">
		<div id="najdiTaxi">&nbsp;</div>
	</div>
	<div id="topRow">
		<div id="welcomeInformation">Dobrodošli! Nahajate se na Vaši administrativni strani, kjer lahko urejate Vaše podatke.</div>
	</div>
	<div class="content">
		<div id="leftColumn">
			<div class="detailInformations">
				<div class="boxName">Ustvarite novo podjetje<a href="#" id="backLink" onclick="history.go(-1);return false;">Nazaj</a></div>
				
				<form id="addCompany" action="user.php?type=addCompany" method="POST" accept-charset="utf-8">
					<table id="table">
					<tr><td>Naziv podjetja:</td><td><input type="text" name="companyName"></td></tr>
					<tr><td>Ulica:</td><td><input type="text" name="companyStreet"></td></tr>
					<tr><td>Mesto:</td><td><input type="text" name="companyTown"></td></tr>
					<tr><td>Odgovorna oseba:</td><td><input type="text" name="companyInCharge"></td></tr>
					<tr><td>Telefon:</td><td><input type="text" name="companyPhone"></td></tr>
					<tr><td>Fax:</td><td><input type="text" name="companyFax"></td></tr>
					<tr><td>Spletna pošta:</td><td><input type="text" name="companyMail"></td></tr>
					<tr><td>Spletna stran:</td><td><input type="text" name="companyWebsite"></td></tr>
					<tr><td>Opis:</td><td><input type="text" name="companyDescription"></td></tr>
					</table>
					<input id="submit" type="submit" value="Spremeni" />
				</form>
			</div>
			<div id="bottom">&nbsp;</div>
		</div>
		<div id="rightColumn">
			<div class="detailInformations">
				<div class="boxName">Pridružite se podjetju, ki je že zapisano v bazi<a href="#" id="backLink2" onclick="history.go(-1);return false;">Nazaj</a></div>
				
				<form id="addCompany" action="user.php?type=addCompany&exists=true" method="POST" accept-charset="utf-8">
					<select name="companySelect" id="companySelect">
						<?php
						$result = mysql_query("SELECT * FROM podjetje");
						while($row = mysql_fetch_array($result))
						{
							echo "<option value=\"" . $row['naziv'] . "\">" . $row['naziv'] . "</option>";
						}
						?>
					</select><br />
					<input type="submit" value="Spremeni" />
				</form>
			</div>
			<div id="bottom">&nbsp;</div> <!-- leave this alone -->
		</div>
	</div>
	<div id="footer">
		<div id="footer-font">Lorem ipsum dolor sit amet, consectetur adipiscing elit. (c) 2011</div>
	</div>
</body>
</html>
