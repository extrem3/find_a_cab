<?php
require('config.php');
$town = $_POST["id"];
echo '<div class="townName">' . $town . '</div>';

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$result = mysql_query("SELECT id_mesto FROM mesta WHERE mesto='$town'");
$town_id = mysql_result($result, 0);

$result = mysql_query("SELECT * FROM mesta_telefonske WHERE ID_mesta='$town_id'");


while ($row = mysql_fetch_array($result)) 
{
	$phone_id = $row['ID_telefonske'];
	$resultPhoneNumbers = mysql_query("SELECT telefonske_st,ID_user FROM telefonske_st WHERE ID_telefonske_st='$phone_id'");
	$phoneNumber = mysql_result($resultPhoneNumbers, 0, 0);
	$userId = mysql_result($resultPhoneNumbers, 0, 1);
	$resultUserName = mysql_query("SELECT ime,priimek FROM uporabniki WHERE id_uporabnik='$userId'");
	$userName = mysql_result($resultUserName, 0, 0);
	$userLastName = mysql_result($resultUserName, 0, 1);
	$resultUserCompanyId = mysql_query("SELECT id_podjetje FROM upor_podj WHERE id_uporabnik='$userId'");
	$userCompanyId = mysql_result($resultUserCompanyId, 0, 0);
	$resultUserCompanyName = mysql_query("SELECT naziv,rating,ratings_total FROM podjetje WHERE id_podjetje='$userCompanyId'");
	$userCompanyName = mysql_result($resultUserCompanyName, 0, 0);
	$userCompanyRating = mysql_result($resultUserCompanyName, 0, 1);
	$userCompanyRatingTotal = mysql_result($resultUserCompanyName, 0, 2);
	if($userCompanyRatingTotal == 0)
		$userCompanyRatingTotal = 1;

	echo '<div class="driver"><div class="driverName">' . $userName . ' ' . $userLastName . '</div><div class="companyName">' . $userCompanyName . '</div><div class="phoneNumber">' . $phoneNumber . '</div><div class="rating">' . ($userCompanyRating/$userCompanyRatingTotal) . '</div></div>';
}
?>
