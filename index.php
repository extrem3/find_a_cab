<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>jQuery UI Autocomplete - Combobox</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/themes/jquery.ui.all.css">
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.button.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.position.js"></script>
	<script type="text/javascript" src="scr/ui/jquery.ui.autocomplete.js"></script>
	<link rel="stylesheet" type="text/css" href="css/demos.css">
	<style type="text/css">
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
	</style>
	<script type="text/javascript">
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
							require('config.php');
							mysql_connect($location,$username,$password);
							@mysql_select_db($database) or die( "Unable to select database");

							$query="SELECT * FROM mesta ORDER BY mesto";
							$result=mysql_query($query);

							$echoString = "\t\t\t\t\t\tsource: [";
							while ($row = mysql_fetch_assoc($result)) {
								$row_text = $row['mesto'];
								$echoString .= "'$row_text', ";
							}
							$echoString = substr($echoString, 0, -2);
							$echoString .= "],";
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
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li><\/li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "<\/a>" )
						.appendTo( ul );
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
					.addClass( "ui-corner-right ui-button-icon" )
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
					.button({
						icons: {
							primary: "ui-icon-circle-zoomin"
						},
						text: true
					})
					.addClass( "ui-corner-right ui-button-icon" )
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

	$(function() {
		var selectBox = $("#ui-dropbox")
			.append($("<select><\/select>")
				.attr({id: "combobox",
					   name: "combobox"})
			)
		$( "#combobox" ).combobox();
		$("#searchForm").hide();
		$("#ui-dropbox").show();
		$( "#toggle" ).click(function() {
			$( "#combobox" ).toggle();
		});
		$('.ui-autocomplete-input').css('width', '500px')
	});
	function loadSomething(a)
	{
		bodyContent = $.ajax({
			  url: "search.php",
			  global: false,
			  type: "POST",
			  data: ({id:a}),
			  dataType: "html",
			  async:false,
			  success: function(msg){
				  $("#results").html(msg);
			  }
		   }
		).responseText;
	}
	</script>
</head>
<body>
<<<<<<< HEAD
	<div id="header">
		<div id="name">
			NajdiTaxi.si
		</div>
	</div>
	<div id="search">
=======
	<!-- <div id="header" align="center"><img src="img/najditaxt_logo_m.png" alt="NajdiTaxi.si" /></div> -->
	<div class="center">
>>>>>>> 57df47952fba326ba7a74cfc3ab921f76d254308
		<div class="ui-widget" id="ui-dropbox" style="display: none"></div>
		<form id="searchForm" action="search.php" method="POST">
			<input id="search-box" type="text" name="id" />
			<input type="submit" value="Najdi!" />
		</form> 
		<div id="results"></div>
	</div>
	<div id="content">
		<div id="city">
			Celje
		</div>
		<div id="line">
			&nbsp;
		</div>
		<div class="taxi-line">
			<div class="name">
			TAXI lorem
			</div>
			<div class="number">
			040-123-456
			</div>
			<div class="stars">
			bla
			</div>
		</div>
		
		<div class="taxi-line">
			<div class="name">
			TAXI lorem
			</div>
			<div class="number">
			040-123-456
			</div>
			<div class="stars">
			bla
			</div>
		</div>
		
		<div class="taxi-line">
			<div class="name">
			TAXI lorem
			</div>
			<div class="number">
			040-123-456
			</div>
			<div class="stars">
			bla
			</div>
		</div>
		
		<div class="taxi-line">
			<div class="name">
			TAXI lorem
			</div>
			<div class="number">
			040-123-456
			</div>
			<div class="stars">
			bla
			</div>
		</div>
	</div>
</body>
</html>
