<?php
require('config.php');

mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

//it would be better to user prepared statements, yet i am not sure if they are enabled on the server :(

//user mysql_real_escape_string to clean the user input
foreach(array_keys($_POST) as $key)
{
  $clean[$key] = mysql_real_escape_string($_POST[$key]);
}

$id_user;
$id_town;
$id_town2;
$id_company;

//error messages: 1-username, 2-email_regex, 3-email_exists, 4-phone_regex, 5-phone_exists, 6-passwords do not match or are too short, 7-empty fields somewhere, 8-company_mail_regex, 9-company_phone_regex

function checkErrors($clean)
{
	if(empty($clean['username']) || empty($clean['name']) || empty($clean['lastName']) || ($clean['cabOwner'] == "on" && $clean['town'] == "notAdded" && empty($clean['newTown'])) || ($clean['companyOwner'] == "on" && $clean['company'] == "notAdded" && (empty($clean['companyName']) || empty($clean['companyStreet']) || empty($clean['companyInCharge']) || empty($clean['newCompanyTown']))))
		return 7;
	//users cannot have same username or email
	if(mysql_num_rows(mysql_query("SELECT * FROM uporabniki WHERE username= '" . $clean['username'] . "'"))>0) 
		return 1;
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['email']))
		return 2;
	if(mysql_num_rows(mysql_query("SELECT * FROM uporabniki WHERE email= '" . $clean['email'] . "'"))>0) 
		return 3;
	if ($clean['companyOwner'] == "on" && $clean['company'] == "notAdded")
	{
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['companyMail']))
			return 8;
		preg_match_all('/[0-9]+/', $_POST['phone'], $cleaned);
		foreach($cleaned[0] as $k=>$v) {
		   $phoneNumber .= $v;
		}
		if(strlen($phoneNumber) > 9 || strlen($phoneNumber) < 5)
			return 9;
	}
	// drivers cannot have the same mobile phone number
	if ($clean['cabOwner'] == "on")
	{
		preg_match_all('/[0-9]+/', $_POST['phone'], $cleaned);
		foreach($cleaned[0] as $k=>$v) {
		   $phoneNumber2 .= $v;
		}
		// return $phoneNumber2;
		if(strlen($phoneNumber2) > 9 || strlen($phoneNumber2) < 5)
			return 4;
		if(mysql_num_rows(mysql_query("SELECT * FROM telefonske_st WHERE telefonske_st= '$phoneNumber'"))>0) 
			return 5;
	}
	if($clean['password'] !== $clean['passwordCheck'] || strlen($_POST['password']) < 4)
		return 6;
	return 0;
}

function addUser($clean)
{
	//password checking and hashing to be added still!!!
	mysql_query("INSERT INTO uporabniki (username, geslo, nivo, ime, priimek, email)
							   VALUES ('" . $clean['username'] . "', '" . $clean['password'] . "', '0', '" . $clean['name'] . "', '" . $clean['lastName'] . "', '" . $clean['email'] . "')");

	$result = mysql_query("SELECT max(id_uporabnik) FROM uporabniki");
	return mysql_result($result, 0, 0);
}
function addDriver($clean, $phone_number, $town_id, $user_id)
{
	preg_match_all('/[0-9]+/', $phone_number, $cleaned);
	foreach($cleaned[0] as $k=>$v) {
	   $phoneNumber .= $v;
	}
	
	mysql_query("INSERT INTO telefonske_st (ID_user, telefonske_st)
							   VALUES ('$user_id', '$phoneNumber')");

	$result = mysql_query("SELECT max(ID_telefonske_st) FROM telefonske_st");
	$telefonska_id = mysql_result($result, 0, 0);

	mysql_query("INSERT INTO mesta_telefonske (ID_mesta, ID_telefonske)
							   VALUES ('$town_id', '$telefonska_id')");
	mysql_query("UPDATE uporabniki SET naziv='1' WHERE id_uporabnik='" . $user_id . "'");
	return $telefonska_st;
}
function addCompany($clean, $companyName, $town_id, $user_id, $exists)
{
	// two companys can have the same name so if the user wants to create a new one, let him create it
	if($exists)
	{
		$companyQuery = mysql_query("SELECT id_podjetje FROM podjetje WHERE naziv='$companyName'");
		if(mysql_num_rows($companyQuery)>0) 
		{
			$companyRow = mysql_fetch_assoc($companyQuery);
			return $companyRow['id_podjetje'];
		}
	}else
	{
		$town_id = ucfirst(strtolower($town_id));
		mysql_query("UPDATE uporabniki SET naziv='2' WHERE id_uporabnik='" . $user_id . "'");
		mysql_query("INSERT INTO podjetje (naziv, ulica, mesto, id_drzava, odg_oseba, tel, fax, email, www, opis, rating)
								   VALUES ('$companyName', '" . $clean['companyStreet'] . "', '$town_id', '1', '" . $clean['companyInCharge'] . "', '" . $clean['companyPhone'] . "', '" . $clean['companyFax'] . "', '" . $clean['companyMail'] . "', '" . $clean['companyWebsite'] . "', '" . $clean['companyDescription'] . "', '0')");

		$result = mysql_query("SELECT max(id_podjetje) FROM podjetje");
		return mysql_result($result, 0, 0);
	}
	return 0;
}
function addTown($clean, $town)
{
	// we dont care if the town already exists or not, so we can return the id of existing one or make a new entry
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

$errors = checkErrors($clean);
if ($errors)
{
	echo "error " . $errors;
}else
{
	$id_user = addUser($clean);
	if ($clean['cabOwner'] == "on")
	{
		$id_town = addTown($clean, $clean['newTown']);
		if ($clean['company'] == "added") 
		{
			$id_company = addCompany($clean, $clean['companySelect'], $id_town, $id_user, true);
		}else
		{
			$id_company = addCompany($clean, $clean['companyName'], $clean['newCompanyTown'], $id_user, false);
		}
		mysql_query("INSERT INTO upor_podj (id_uporabnik, id_podjetje)
									VALUES ('$id_user', '$id_company')");
		addDriver($clean, $clean['phone'], $id_town, $id_user);
	}else if ($clean['companyOwner'] == "on")
	{
		if ($clean['company'] == "added") 
		{
			$id_company = addCompany($clean, $clean['companySelect'], $id_town, $id_user, true);
		}else
		{
			$id_company = addCompany($clean, $clean['companyName'], $clean['newCompanyTown'], $id_user, false);
		}
	}
	echo "done";
}
?>
