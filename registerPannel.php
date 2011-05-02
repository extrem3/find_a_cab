<html>
<head>
	<title>User pannel</title>
	<link rel="stylesheet" type="text/css" href="css/slides.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/themes/jquery.ui.all.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.button.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.position.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.autocomplete.js"></script>
	<script type="text/javascript">
	var total = 0;
	var slideSpeed = 200;
	var slideWidth = 730;
	var currentPosition = 0;
	var numberOfSlides = 0;
	var hideButtons = new Array(new Array(1, -1),
								new Array(3, -1),
								new Array(5, -1));
	$(document).ready(function() {
		var slides = $('.slide');
		numberOfSlides = slides.length;
		$('#navigation').html('<div class="button" id="prevSlide" ></div><div id="statusBar" /><div class="button" id="nextSlide" >Naprej</div>')
		$('#content').css('overflow', 'hidden');

		// Wrap all .slides with #slideInner div
		slides.wrapAll('<div id="slideInner"></div>')
			  .css({
					'float' : 'left',
					'width' : slideWidth
					});

		// Set #slideInner width equal to total width of all slides
		$('#slideInner').css('width', slideWidth * numberOfSlides);

		$('#nextSlide').click( function() {
				moveSlideHolder(currentPosition + 1, true);
			});
		$('#prevSlide').click( function() {
				moveSlideHolder(currentPosition - 1, false);
			});

		$('#content_driver_yes').click( function() {
				hideButtons[0][1] = 1;
				moveSlideHolder(currentPosition + 1, true);
			});
		$('#content_driver_no').click( function() {
				hideButtons[0][1] = 0;
				moveSlideHolder(currentPosition + 2, true);
			});
		$('#content_owner_yes').click( function() {
				hideButtons[1][1] = 1;
				moveSlideHolder(currentPosition + 1, true);
			});
		$('#content_owner_no').click( function() {
				hideButtons[1][1] = 0;
				moveSlideHolder(currentPosition + 2, true);
			});

		updateStatusBar();
	});
	function moveSlideHolder(to, forward)
	{
		if(to != 0)
			$('#prevSlide').html('Nazaj');
		else
			$('#prevSlide').html('');

		if(to != numberOfSlides - 1)
			$('#nextSlide').html('Naprej');
		else
			$('#nextSlide').html('Zakljuci');

		for(var j = 0; j < hideButtons.length - 1; ++j)
		{
			if(hideButtons[j][0] == to && hideButtons[j][1] == -1)
			{
				$('#nextSlide').html('');
			}
		}
		if(to >= 0 && to < numberOfSlides)
		{
			if(currentPosition == hideButtons[1][0] && !forward && hideButtons[0][1] == 0)
			{
				//if we are returning to ALI STE VOZNIK and he said he is not
				currentPosition = hideButtons[0][0];
			}else if(to == hideButtons[0][0] + 1 && forward && hideButtons[0][1] == 0)
			{
				//if we are going forward from ALI STE VOZNIK and he said he is not
				currentPosition = hideButtons[1][0];
			}else if(currentPosition == hideButtons[2][0] && !forward && hideButtons[1][1] == 0)
			{
				//if we are returning to DO YOU HAVE A COMPANY and he said he doesn't
				currentPosition = hideButtons[1][0];
			}else if(to == hideButtons[1][0] + 1 && forward && hideButtons[1][1] == 0)
			{
				//if we are going forward from DO YOU HAVE A COMPANY and he said he doesn't
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
	}
	function updateStatusBar()
	{
		$('#statusBar').html("<div class='usedButton'>&nbsp;</div>");
		$('#statusBar').append("|");
		var k = 0;
		for (var i = 0; i < numberOfSlides - 1; ++i)
		{
			if (hideButtons[k][0] + 1 == i)
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
	</script>
</head>
<body>
	<div id="content">
	<form action="register.php" method="POST" accept-charset="utf-8">
		<div id="content_1" class="slide">
			<h1>Obvezni podatki</h1><br>
			Uporabnisko ime:<input type="text" name="username"><br>
			Geslo:<input type="password" name="password"><br>
			Ponovite geslo:<input type="password" name="passwordCheck"><br>
			Ime:<input type="text" name="name"><br>
			Priimek:<input type="text" name="lastName"><br>
			Email:<input type="text" name="email"><br>
			<br>
			<br>
		</div>
		<div id="content_2" class="slide">
			<h1>Ali ste voznik taksija?</h1><br>
			<input type="checkbox" name="cabOwner">Taxi driver
			<div class="button" id="content_driver_yes">Da</div>
			<div class="button" id="content_driver_no">Ne</div>
		</div>
		<div id="content_3" class="slide">
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
			</table>
			Phone number:<input type="text" name="phone"><br>
			(vec stevilk boste lahko vstavili kasneje)
			<br>
			<br>
		</div>
		<div id="content_4" class="slide">
			<h1>Ali je vase podjetje ze v nasi bazi?</h1><br>
			<input type="checkbox" name="companyOwner">Company owner
			<div class="button" id="content_owner_yes">Da</div>
			<div class="button" id="content_owner_no">Ne</div>
		</div>
		<div id="content_5" class="slide">
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
						Town:<input type="text" name="newCompanyTown"><br>
						Responsible person:<input type="text" name="companyInCharge"><br>
						Phone:<input type="text" name="companyPhone"><br>
						Mail:<input type="text" name="companyMail"><br>
						Website:<input type="text" name="companyWebsite"><br>
						Desciption:<input type="text" name="companyDescription"><br>
					</td>
				</tr>
			</table>
		</div>
		<div id="content_6" class="slide">
			<div style="display:block">
			<br>
			<input type="submit" value="Register">
			</div>
		</div>
	</form>
	</div>
	<div id="navigation" />
</body>
</html>
