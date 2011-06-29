<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Pogosto zastavljena sprašanja</title>
	<link rel="stylesheet" type="text/css" href="css/FAQ.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$(function() {
		$(".answer").hide();
		$(".FAQ").click(function() {
			$(".answer").slideUp("fast");
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
		<div id="welcomeInformation">Dobrodošli! Nahajate se na strani z odgovori najpogosteje zastavljenih vprašanj.</div>
	</div>
	<div id="content">
		<div id="boxName">Odgovori na pogosta vprašanja<a href="#" id="backLink" onclick="history.go(-1);return false;">Nazaj</a></div>

		<div class="FAQ">Vprašanje 1</div>
		<div class="answer">Odgovor 1</div>
		<div class="FAQ">Vprašanje 2</div>
		<div class="answer">Odgovor 2</div>
	</div>
	<div id="bottom">&nbsp;</div> <!-- leave this alone -->
	<div id="footer">
		<div id="footer-font">Lorem ipsum dolor sit amet, consectetur adipiscing elit. (c) 2011</div>
	</div>
</body>
</html>
