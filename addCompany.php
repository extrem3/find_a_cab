<?php
require('config.php');

mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$id_user;
$id_town;
$id_town2;
$id_company;


function addUser()
{
	//password checking and hashing to be added still!!!
	if(mysql_num_rows(mysql_query("SELECT * FROM uporabniki WHERE username= '" . $_POST['username'] . "'"))>0) 
		return "user with this username already exists";
	if(mysql_num_rows(mysql_query("SELECT * FROM uporabniki WHERE email= '" . $_POST['email'] . "'"))>0) 
		return "user with this email already exists";
	
	mysql_query("INSERT INTO uporabniki (username, geslo, nivo, ime, priimek, email)
							   VALUES ('" . $_POST['username'] . "', '" . $_POST['password'] . "', '0', '" . $_POST['name'] . "', '" . $_POST['lastName'] . "', '" . $_POST['email'] . "')");

	$result = mysql_query("SELECT max(id_uporabnik) FROM uporabniki");
	return mysql_result($result, 0, 0);
}
function addDriver($phone_number, $town_id, $user_id)
{
	preg_match_all('/[0-9]+/', $phone_number, $cleaned);
	foreach($cleaned[0] as $k=>$v) {
	   $phoneNumber .= $v;
	}
	if(mysql_num_rows(mysql_query("SELECT * FROM telefonske_st WHERE telefonske_st= '$phoneNumber'"))>0) 
		return "this phone number already exists";
	
	mysql_query("INSERT INTO telefonske_st (ID_user, telefonske_st)
							   VALUES ('$user_id', '$phoneNumber')");

	$result = mysql_query("SELECT max(ID_telefonske_st) FROM telefonske_st");
	$telefonska_id = mysql_result($result, 0, 0);

	mysql_query("INSERT INTO mesta_telefonske (ID_mesta, ID_telefonske)
							   VALUES ('$town_id', '$telefonska_id')");
	return $telefonska_st;
}
function addCompany($companyName, $town_id, $user_id)
{
	$companyQuery = mysql_query("SELECT id_podjetje FROM podjetje WHERE naziv='$companyName'");
	if(mysql_num_rows($companyQuery)>0) 
	{
		$companyRow = mysql_fetch_assoc($companyQuery);
		return $companyRow['id_podjetje'];
	}
	
	mysql_query("INSERT INTO podjetje (naziv, ulica, id_mesto, id_drzava, odg_oseba, tel, fax, email, www, opis, rating)
							   VALUES ('$companyName', '" . $_POST['companyStreet'] . "', '$town_id', '1', '$user_id', '" . $_POST['companyPhone'] . "', '" . $_POST['companyFax'] . "', '" . $_POST['companyMail'] . "', '" . $_POST['companyWebsite'] . "', '" . $_POST['companyDescription'] . "', '0')");

	$result = mysql_query("SELECT max(id_podjetje) FROM podjetje");
	return mysql_result($result, 0, 0);
}
function addTown($town)
{
	$town = ucfirst(strtolower($town));
	$townQuery = mysql_query("SELECT id_mesto FROM mesta WHERE mesto='$town'");
	if(mysql_num_rows($townQuery)>0) 
	{
		$townRow = mysql_fetch_assoc($townQuery);
		return $townRow['id_mesto'];
	}
	
	mysql_query("INSERT INTO mesta (mesto)
						    VALUES ('$town')");

	$townResult = mysql_query("SELECT max(id_mesto) FROM mesta");
	return mysql_result($townResult, 0, 0);
}

$id_user = addUser();
if ($_POST['cabOwner'] == "on")
{
	if ($_POST['town'] == "added") 
	{
		$id_town = addTown($_POST['townSelect']);
	}else
	{
		$id_town = addTown($_POST['newTown']);
	}
	if ($_POST['company'] == "added") 
	{
		$id_company = addCompany($_POST['companySelect'], $id_town, $id_user);
	}else
	{
		if ($_POST['companyTown'] == "added") 
		{
			$id_town2 = addTown($_POST['companyTownSelect']);
		}else
		{
			$id_town2 = addTown($_POST['newCompanyTown']);
		}
		$id_company = addCompany($_POST['companyName'], $id_town2, $id_user);
	}
	mysql_query("INSERT INTO upor_podj (id_uporabnik, id_podjetje)
								VALUES ('$id_user', '$id_company')");
	addDriver($_POST['phone'], $id_town, $id_user);
}else if ($_POST['companyOwner'] == "on")
{
	if ($_POST['company'] == "added") 
	{
		$id_company = addCompany($_POST['companySelect'], $id_town, $id_user);
	}else
	{
		if ($_POST['companyTown'] == "added") 
		{
			$id_town2 = addTown($_POST['companyTownSelect']);
		}else
		{
			$id_town2 = addTown($_POST['newCompanyTown']);
		}
		$id_company = addCompany($_POST['companyName'], $id_town2, $id_user);
	}
}
echo "done";
?>
