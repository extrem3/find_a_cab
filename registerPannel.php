<html>
<head>
	<title>User pannel</title>
	<link rel="stylesheet" type="text/css" href="css/slides.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/themes/jquery.ui.all.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <script type="text/javascript" src="scr/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.button.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.position.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.autocomplete.js"></script>
	<script type="text/javascript">
	var total = 0;
	var slideSpeed = 200;
	var slideWidth = 480;
	var currentPosition = 0;
	var numberOfSlides = 0;
	var hideButtons = new Array(new Array(1, -1),
								new Array(3, -1),
								new Array(6, -1));
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
	$(document).ready(function() {
		$('form').append(' <div id="content_8" class="slide"> <br> <div>Uspesno ste se registrirali v sistem. Sedaj se lahko prijavite.</div> <div class="button" id="closeRegistration">Zapri</div></div>');
		var slides = $('.slide');
		numberOfSlides = slides.length - 1;
		$('#navigation').html('<div id="prevSlide" ></div><div id="statusBar" /><div id="nextSlide" >Naprej</div>')
		$('#content_2').append('<div class="button" id="content_driver_yes">Da</div>');
		$('#content_2').append('<div class="button" id="content_driver_no">Ne</div>');
		$('#content_4').append('<div class="button" id="content_owner_yes">Sem lastnik podjetja</div>');
		$('#content_4').append('<div class="button" id="content_owner_no">Moje podjetje je ze v bazi</div>');
		$('#content').css('overflow', 'hidden');
		$('input[type="checkbox"]').css('display', 'none');
		$('input[type="radio"]').css('display', 'none');
		$('.inputDescription').css('display', 'none');
		$('.button').button();
		$('.button').removeClass('ui-corner-all');

		// Wrap all .slides with #slideInner div
		slides.wrapAll('<div id="slideInner"></div>')
			  .css({
					'float' : 'left',
					'width' : slideWidth
					});

		// Set #slideInner width equal to total width of all slides
		$('#slideInner').css('width', slideWidth * (numberOfSlides + 1));
		$('input').css("background-color", "#cccccc")

		$('input').focus( function() {
			$(this).animate({ backgroundColor: "#ffffff" }, 300);
		});
		$('input').blur( function() {
			$(this).animate({ backgroundColor: "#cccccc" }, 300);
		});
		$('#closeRegistration').click( function() {
			self.parent.Shadowbox.close();
		});
		$('#nextSlide').click( function() {
			moveSlideHolder(currentPosition + 1, true);
		});
		$('#prevSlide').click( function() {
			moveSlideHolder(currentPosition - 1, false);
		});

		$('#content_driver_yes').click( function() {
			$('#cabOwner').attr('checked', true)
			$('#companyOwner').attr('checked', true)
			hideButtons[0][1] = 1;
			$("#content_owner_no").button('option', 'label', 'Moje podjetje je ze v bazi');
			$(".button").button();
			moveSlideHolder(currentPosition + 1, true);
		});
		$('#content_driver_no').click( function() {
			$('#cabOwner').removeAttr('checked')
			hideButtons[0][1] = 0;
			$("#content_owner_no").button('option', 'label', 'Nisem lastnik podjetja');
			moveSlideHolder(currentPosition + 2, true);
		});
		$('#content_owner_yes').click( function() {
			$('#companyOwner').attr('checked', true)
			$('input:radio[name=company]').filter('[value=notAdded]').attr('checked', true);
			hideButtons[1][1] = 1;
			moveSlideHolder(currentPosition + 1, true);
		});
		$('#content_owner_no').click( function() {
			if(hideButtons[0][1] == 0)
			{
				$('#companyOwner').removeAttr('checked')
			}
			$('input:radio[name=company]').filter('[value=added]').attr('checked', true);
			hideButtons[1][1] = 0;
			moveSlideHolder(currentPosition + 3, true);
		});

		updateStatusBar();
		$('form').submit(function() {
			var formContents = $(this).serialize();
			bodyContent = $.ajax({
				url: "register.php",
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
						$('#slideInner').animate({
							'marginLeft' : slideWidth*(-7)
						}, slideSpeed);
						$('#prevSlide').html('');
						$('#nextSlide').html('');
						$('#statusBar').html("");
					}else
					{
						stripErrors(msg);
					}
				}
			}).responseText;
			return false;
		});
	});
	function moveSlideHolder(to, forward)
	{
		if(to >= 0 && to < numberOfSlides)
		{
			if(currentPosition == hideButtons[1][0] && !forward && hideButtons[0][1] == 0)
			{
				//if we are returning to ALI STE VOZNIK and he said he is not
				currentPosition = hideButtons[0][0];
			}else if(currentPosition == hideButtons[0][0] && forward && hideButtons[0][1] == 0)
			{
				//if we are going forward from ALI STE VOZNIK and he said he is not
				currentPosition = hideButtons[1][0];
			}else if(currentPosition == hideButtons[2][0] && !forward)
			{
				//if we are returning to DO YOU HAVE A COMPANY and he said he doesn't
				if(hideButtons[0][1] == 1 && hideButtons[1][1] == 1)
				{
					//if he said he is a driver and he is the owner of a company
					currentPosition = hideButtons[1][0] + 1;
				}else if(hideButtons[0][1] == 1 && hideButtons[1][1] == 0)
				{
					//if he said he is a driver and he is not the owner of a company
					currentPosition = hideButtons[1][0] + 2;
				}else if(hideButtons[0][1] == 0 && hideButtons[1][1] == 0)
				{
					//if he said he is not a driver and he is not the owner of a company
					currentPosition = hideButtons[1][0];
				}else 
				{
					//if he said he is not a driver and he is the owner of a company
					currentPosition = hideButtons[1][0] + 1;
				}
			}else if((currentPosition > hideButtons[1][0] && currentPosition < hideButtons[2][0]) && !forward)
			{
				currentPosition = hideButtons[1][0];
			}else if(currentPosition == hideButtons[1][0] && forward)
			{
				//if we are going forward from DO YOU HAVE A COMPANY and he said he doesn't
				if(hideButtons[0][1] == 1 && hideButtons[1][1] == 1)
				{
					//if he said he is a driver and he is the owner of a company
					currentPosition = hideButtons[1][0] + 1;
				}else if(hideButtons[0][1] == 1 && hideButtons[1][1] == 0)
				{
					//if he said he is a driver and he is not the owner of a company
					currentPosition = hideButtons[1][0] + 2;
				}else if(hideButtons[0][1] == 0 && hideButtons[1][1] == 0)
				{
					//if he said he is not a driver and he is not the owner of a company
					currentPosition = hideButtons[2][0];
				}else 
				{
					//if he said he is not a driver and he is the owner of a company
					currentPosition = hideButtons[1][0] + 1;
				}
			}else if((currentPosition > hideButtons[1][0] && currentPosition < hideButtons[2][0]) && forward)
			{
				currentPosition = hideButtons[2][0];
			}else
			{
				currentPosition = to
			}
			$('#slideInner').animate({
				'marginLeft' : slideWidth*(-currentPosition)
				}, slideSpeed);
			updateStatusBar();
		}
		if(currentPosition != 0)
			$('#prevSlide').html('Nazaj');
		else
			$('#prevSlide').html('');

		if(currentPosition != numberOfSlides - 1)
			$('#nextSlide').html('Naprej');
		else
			$('#nextSlide').html('');

		for(var j = 0; j < hideButtons.length - 1; ++j)
		{
			if(hideButtons[j][0] == to && hideButtons[j][1] == -1)
			{
				$('#nextSlide').html('');
			}
		}
	}
	function updateStatusBar()
	{
		$('#statusBar').html("<div class='usedButton'>&nbsp;</div>");
		var k = 0;
		for (var i = 0; i < numberOfSlides - 1; ++i)
		{
			if (hideButtons[k][0] - 1 == i)
			{
				++ k;
				$('#statusBar').append("|");
			}

			if (i < currentPosition)
			{
				$('#statusBar').append("<div class='usedButton'>&nbsp;</div>");
			}else
			{
				$('#statusBar').append("<div class='unusedButton'>&nbsp;</div>");
			}
		}
	}
	var tempErrors = new Array();
	function stripErrors(e)
	{
		for (var i = 0; i < tempErrors.length; ++i)
		{
			for (var j = 0; j < errors.length; ++j)
			{
				if (tempErrors[i] == errors[j][1])
				{
					$('input[name=' + errors[j][2] + ']').css("background-color", "#ffffff")
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
					$('input[name=' + errors[j][2] + ']').css("background-color", "#e97c34")
					if (first > errors[j][0])
					{
						first = errors[j][0];
					}
					break;
				}
			}
		}
		moveSlideHolder(first, true);
	}
	</script>
</head>
<body>
	<div id="content">
	<form action="register.php" method="POST" accept-charset="utf-8">
		<div id="content_1" class="slide">
			<h1>Obvezni podatki</h1>
			<table>
				<tr><td class="name">Ime:</td><td id="lastName">Priimek:</td></tr>
				<tr><td class="name"><input id="name2" type="text" name="name"></td>
					<td><input id="surname2" type="text" name="lastName"></td></tr>
			</table><hr />
			<a>Email:</a><br>				<input id="email2" type="text" name="email"><br>
			<a>Uporabnisko ime:</a><br>	<input id="username2" type="text" name="username"><br><hr />
			<table>
				<tr><td>Geslo:</td><td>Ponovite geslo:</td>
				<tr><td id="pass"><input type="password" name="password"></td>
					<td><input type="password" name="passwordCheck"></td></tr>
			</table>
			<br>
		</div>
		<div id="content_2" class="slide">
			<h1>Ali ste voznik taksija?</h1><br>
			<input type="checkbox" name="cabOwner" id="cabOwner"/><div class="inputDescription">Da</div>
		</div>
		<div id="content_3" class="slide">
			<h1>Vpisite vaso telefonsko stevilko ter mesto v katerem vozite</h1><br>
			<a>Telefonska stevilka:</a><br><input type="text" name="phone"><br>
			<a>Ime Mesta:</a><br><input type="text" name="newTown"><br>
			(vec stevilk boste lahko vstavili kasneje)
			<br>
			<br>
		</div>
		<div id="content_4" class="slide">
			<h1>Podjetje</h1><br>
			<input type="checkbox" name="companyOwner" id="companyOwner"/><div class="inputDescription">Sem lastnik podjetja oziroma sem zaposlen pri (ce ste voznik taksija morate pripadati podjetju):</div>
			<br>
			<br>
		</div>
		<div id="content_5" class="slide">
			<input type="radio" name="company" value="notAdded"/><div class="inputDescription">Sem lastnik podjetja</div>
			Naziv podjetja:<input type="text" name="companyName"><br>
			Ulica:<input type="text" name="companyStreet"><br>
			Mesto:<input type="text" name="newCompanyTown"><br>
			Odgovorna oseba:<input type="text" name="companyInCharge"><br>
			Telefon:<input type="text" name="companyPhone"><br>
			Fax:<input type="text" name="companyFax"><br>
			Spletna posta:<input type="text" name="companyMail"><br>
			Spletna stran:<input type="text" name="companyWebsite"><br>
			Opis:<input type="text" name="companyDescription"><br>
			<br> <br>
		</div>
		<div id="content_6" class="slide">
			<div id="or">ALI</div> <br>
			<input type="radio" name="company" value="added" checked="true"/><div class="inputDescription">Podjetje je ze v bazi:</div>
			<br>
			<select name="companySelect" id="companySelect">
				<?php
				require('config.php');
				mysql_connect($location,$username,$password);
				@mysql_select_db($database) or die( "Unable to select database");
						
				$result = mysql_query("SELECT * FROM podjetje");
				echo "selection";
				while($row = mysql_fetch_array($result))
				{
					echo "<option value=\"" . $row['naziv'] . "\">" . $row['naziv'] . "</option>";
				}
				?>
			</select>
			<br> <br>
		</div>
		<div id="content_7" class="slide">
			<br>
			<input type="submit" value="Zakljuci">
		</div>
	</form>
	</div>
	<div id="navigation" />
</body>
</html>
