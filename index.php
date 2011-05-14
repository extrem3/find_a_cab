<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>jQuery UI Autocomplete - Combobox</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/themes/jquery.ui.all.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<script type="text/javascript" src="scr/shadowbox.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.button.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.position.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.autocomplete.js"></script>
	<link rel="stylesheet" type="text/css" href="css/shadowbox.css">
	<link rel="stylesheet" type="text/css" href="css/demos.css">
	<style type="text/css">
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
	</style>
	<script type="text/javascript">
	Shadowbox.init({
		handleOversize: "resize"
	});
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						<?php
error_reporting(E_ALL);
							require('config.php');
							mysql_connect($location,$username,$password);
							@mysql_select_db($database) or die( "Unable to select database");

							$query="SELECT * FROM mesta ORDER BY mesto";
							$result=mysql_query($query);

							$echoString = "\t\t\t\t\t\tsource: [";
							$i = 0;
							while ($row = mysql_fetch_assoc($result)) {
								$i ++;
								$row_text = $row['mesto'];
								$echoString .= "'$row_text', ";
							}
							if ($i > 0)
							{
								$echoString = substr($echoString, 0, -2);
								$echoString .= "],";
							}else
							{
								$echoString .= "],";
							}
							echo $echoString;
						?>
						select: function( event, ui ) {
							// loadSomething(ui.item.option.innerHTML);
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
							}
						}
					}).keypress(function(e){
						if(e.keyCode === 13)
						{
							loadSomething(input.val());
							input.blur();
						}
					})
					.addClass( "ui-widget ui-widget-content" )

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li><\/li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "<\/a>" )
						.appendTo( ul )
						.find("a").removeClass('ui-corner-all');
				};
				input.id = "asdf";
				// input.keydown(function(e){
				// 	
				// 	if(e.keyCode === 13)
				// 	{
				// 		alert(ui.item.option.innerHTML)
				// 	}
				// })

				this.button = $( "<button type='button'>&nbsp;<\/button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( " ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});

				submitButton = $( "<button type='button'>Najdi!<\/button>" )
					.attr( "title", "Show All Items" )
					.insertAfter( this.button )
					.css("margin-left", "5px")
					.css('border', 'none')
					.button({
						icons: {
							primary: "ui-icon-circle-zoomin"
						},
						text: true
					})
					.addClass( " ui-button-icon" )
					.removeClass( "ui-corner-all" )
					.click(function() {
						loadSomething(input.val())
					});

			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
		// input.val($(select).find("option:selected").text())
	})( jQuery );
	// $(window).load(function(){

	// })

	$(function() {
		var selectBox = $("#ui-dropbox")
			.append($("<select><\/select>")
				.attr({id: "combobox",
					   name: "combobox"})
			)
		$( "#combobox" ).combobox();
		$( "ul.ui-autocomplete" ).removeClass("ui-corner-all")
		$("#searchForm").hide();
		$("#ui-dropbox").show();
		$("#ui-active-menuitem").removeClass("ui-corner-all");
		$( "#toggle" ).click(function() {
			$( "#combobox" ).toggle();
		});
		$('.ui-autocomplete-input').css('width', '300px')
	});
	var moved = false;
	var speed = 600;
	var animated = false;
	var loaded = false;
	var storedResults = "";
	function loadSomething(a)
	{
		loaded = false;
		animated = false;
		if (!moved)
		{
			$('.index-search').animate({
				'top' : 100
			}, speed);
			moved = true;
			$('#results').fadeOut(speed, function(){
				$('#loadSpinner').fadeIn(speed, function(){
					animated = true;
					displayResults("empty");
				});
			});
		}else
		{
			$('#results').fadeOut(speed, function(){
				$('#loadSpinner').fadeIn(speed, function(){
					animated = true;
					displayResults("empty");
				});
			});
		}
		bodyContent = $.ajax({
			url: "search.php",
			global: false,
			type: "POST",
			data: ({id:a}),
			dataType: "html",
			async:false,
			success: function(msg){
				loaded = true;
				displayResults(msg);
			}
		}).responseText;
	}
	function displayResults(r)
	{
		if (loaded == true && animated == true)
		{
			$('#loadSpinner').fadeOut(speed, function(){
				if(r == "empty")
				{
					$("#results").html(storedResults);
				}else
				{
					$("#results").html(r);
				}
				$('#results').fadeIn(speed);
			});
		}else if(r != "empty")
		{
			storedResults = r;
		}
	}
	</script>
</head>
<body>
	<div id="header">
		<div class="login-register">
			<a rel="shadowbox;title=Prijava;height=250;width=450" href="loginPannel.php" id="loginButton">Prijavi se!</a> 
			<a rel="shadowbox;title=Registracija;height=400;width=500" href="registerPannel.php" id="registerButton">Registriraj se!</a>
		</div>
		<div id="name">&nbsp;</div>
	</div>
	<div class="index-search">
		<div class="ui-widget" id="ui-dropbox" style="display: none"></div>
		<form id="searchForm" action="search.php" method="POST">
			<input id="search-box" type="text" name="id" />
			<input class="find_button" type="submit" value="Najdi!" />
		</form>
	</div>
	<div id="loadSpinner"><img src="img/spinner.gif"/></div>
	<div id="results">
	<!-- <div id="index-ads">Tukaj pridejo oglasi</div> -->
	</div>
	<div id="footer">
		<a href="loginpannel.php"><div id="footer-login">Prijavi se!</div></a>
		<div id="footer-font">vsa vsebina je last njenih izdelovalcev (c) 2011</div>
	</div>
</body>
</html>
