<head>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/results.css">
	<style type="text/css">
	.index-search {top: 150px; }
	</style>
	<script type="text/javascript">
	(function( $ ) {
		$(".companyDetails").hide();
		$(".driver").click(function() {
				$(this).next().slideToggle("fast");
		})
  });

  </script>
</head>
<body>
<?php
require('config.php');

mysql_connect($location,$username,$password); /* spremenil localhost v 'localhost' */
@mysql_select_db($database) or die( "Unable to select database");

$dataArray = array();

$town = mysql_real_escape_string($_POST["id"]);
/* echo '<div class="results-ads">Tukaj bojo oglasi!</div>'; */

echo '<div class="content">';
echo '<div class="contentTitle">';
echo '<hr class="hr">&nbsp;</hr>';
echo '<div class="townName">' . $town . '</div>';
echo '</div>';
echo '<div id="resultsContents">';

$result = mysql_query("SELECT id_mesto FROM mesta WHERE mesto='$town'");
if(mysql_num_rows($result)>0) 
{
	$town_id = mysql_result($result, 0);

	$result = mysql_query("SELECT * FROM mesta_telefonske WHERE ID_mesta='$town_id'");


	while ($row = mysql_fetch_array($result)) 
	{
		$phone_id = $row['ID_telefonske'];
		$resultPhoneNumbers = mysql_query("SELECT telefonske_st,ID_user FROM telefonske_st WHERE ID_telefonske_st='$phone_id'");
		$phoneNumber = mysql_result($resultPhoneNumbers, 0, 0);

		$userId = mysql_result($resultPhoneNumbers, 0, 1);
		$resultUserShown = mysql_query("SELECT prikazov FROM uporabniki WHERE id_uporabnik='$userId'");
		$userShown = mysql_result($resultUserShown, 0);
		mysql_query("UPDATE uporabniki SET prikazov='" . ($userShown + 1) . "' WHERE id_uporabnik='" . $userId . "'");
		$resultUserName = mysql_query("SELECT ime,priimek FROM uporabniki WHERE id_uporabnik='$userId'");
		$userName = mysql_result($resultUserName, 0, 0);
		$userLastName = mysql_result($resultUserName, 0, 1);

		$resultUserCompanyId = mysql_query("SELECT id_podjetje FROM upor_podj WHERE id_uporabnik='$userId'");
		$userCompanyId = mysql_result($resultUserCompanyId, 0, 0);
		$resultUserCompanyName = mysql_query("SELECT naziv,rating,ratings_total,ulica,tel,fax,email,www,opis FROM podjetje WHERE id_podjetje='$userCompanyId'");
		$userCompanyName = mysql_result($resultUserCompanyName, 0, 0);
		$userCompanyRating = mysql_result($resultUserCompanyName, 0, 1);
		$userCompanyRatingTotal = mysql_result($resultUserCompanyName, 0, 2);
		$userCompanyAddress = mysql_result($resultUserCompanyName, 0, 3);
		$userCompanyPhone = mysql_result($resultUserCompanyName, 0, 4);
		$userCompanyFax = mysql_result($resultUserCompanyName, 0, 5);
		$userCompanyMail = mysql_result($resultUserCompanyName, 0, 6);
		$userCompanyWebsite = mysql_result($resultUserCompanyName, 0, 7);
		$userCompanyDesctiption = mysql_result($resultUserCompanyName, 0, 8);
		if($userCompanyRatingTotal == 0)
			$userCompanyRatingTotal = 1;

		$dataArrayTemp = array($phoneNumber, $userCompanyName, $userName, $userLastName, $userCompanyAddress, $userCompanyPhone, $userCompanyFax, $userCompanyMail, $userCompanyWebsite, $userCompanyDesctiption);
		array_push($dataArray, $dataArrayTemp);

		echo '<div class="driver">';
		echo '<div class="companyName">' . $userCompanyName . '</div>';
		echo '<div class="driverName">Voznik: ' . $userName . ' ' . $userLastName . '</div>';
		echo '<div class="phoneNumber">' . $phoneNumber . '</div>';
		echo '<div class="companyDetails">'; 
		echo '<div class="companyAddress">' . $userCompanyAddress . '</div>';
		echo '<div class="companyPhone">' . $userCompanyPhone . '</div>';
		echo '<div class="companyFax">' . $userCompanyFax . '</div>';
		echo '<div class="companyMail">' . $userCompanyMail . '</div>';
		echo '<div class="companyWebsite">' . $userCompanyWebsite . '</div>';
		echo '<div class="companyDescription">' . $userCompanyDesctiption . '</div>';
		echo '</div></div>';
	}
}
echo '</div>';
echo '</div>';
?>
</body>
