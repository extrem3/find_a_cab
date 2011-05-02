<html>
<head>
	<title>User pannel</title>
	<link rel="stylesheet" type="text/css" href="css/slides.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<script type="text/javascript">
	var total = 0;
	var slideSpeed = 200;
	var slideWidth = 730;
	var currentPosition = 0;
	$(document).ready(function() {
		var slides = $('.slide');
		var numberOfSlides = slides.length;
		$('#navigation').html('<div id="prevSlide">prev</div> <div id="nextSlide">next</div>')
		$('#prevSlide').css('display', 'inline');
		$('#nextSlide').css('display', 'inline');
		$('#content').css('overflow', 'hidden');

		// Wrap all .slides with #slideInner div
		slides.wrapAll('<div id="slideInner"></div>')
			  .css({
					'float' : 'left',
					'width' : slideWidth
					});

		// Set #slideInner width equal to total width of all slides
		$('#slideInner').css('width', slideWidth * numberOfSlides);

		$('#nextSlide').click(
			function() 
			{
				if(currentPosition < numberOfSlides - 1)
				{
					++ currentPosition;
					// Move slideInner using margin-left
					$('#slideInner').animate({
						'marginLeft' : slideWidth*(-currentPosition)
						}, slideSpeed);
				}
			});
		$('#prevSlide').click(
			function() 
			{
				if(currentPosition > 0)
				{
					-- currentPosition;
					// Move slideInner using margin-left
					$('#slideInner').animate({
						'marginLeft' : slideWidth*(-currentPosition)
						}, slideSpeed);
				}
			});
	});
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
			<h1>Ali ste lastnik podjetja?</h1><br>
			<input type="checkbox" name="companyOwner">Company owner
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
	<div id="navigation" />
	</div>
</body>
</html>
