<?php
require('config.php');

mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$id_user;
$id_town;
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
echo "name: " . $_POST['username'] . "<br>";
echo "pass: " . $_POST['password'] . "<br>";
echo "pass2: " . $_POST['passwordCheck'] . "<br>";
echo "Name: " . $_POST['name'] . "<br>";
echo "Last: " . $_POST['lastName'] . "<br>";
echo "mail: " . $_POST['email'] . "<br>";
if ($_POST['cabOwner'] == "on")
{
	echo "<br>";
	echo "is a driver" . "<br>";
	echo "Phone: " . $_POST['phone'] . "<br>";
	echo "town is " . $_POST['town'] . "<br>";
	if ($_POST['town'] == "added") 
	{
		echo "	town: " . $_POST['townSelect'] . "<br>";
	}else
	{
		echo "	town: " . $_POST['newTown'] . "<br>";
	}
	if (!$_POST['companyOwner'] == "on")
	{
		if ($_POST['company'] == "added") 
		{
			echo "	companyName: " . $_POST['companySelect'] . "<br>";
		}else
		{
			echo "	companyName: " . $_POST['companyName'] . "<br>";
			echo "	companyStreet: " . $_POST['companyStreet'] . "<br>";
			echo "	companyInCharge: " . $_POST['companyInCharge'] . "<br>";
			echo "	companyPhone: " . $_POST['companyPhone'] . "<br>";
			echo "	companyMail: " . $_POST['companyMail'] . "<br>";
			echo "	companyWebsite: " . $_POST['companyWebsite'] . "<br>";
			echo "	companyDescription: " . $_POST['companyDescription'] . "<br>";
			echo "companyTown: " . $_POST['companyTown'] . "<br>";
			if ($_POST['companyTown'] == "added") 
			{
				echo "	town: " . $_POST['companyTownSelect'] . "<br>";
			}else
			{
				echo "	town: " . $_POST['newCompanyTown'] . "<br>";
			}
		}
	}
}else
{
	echo "is NOT a driver <br>";
}

if ($_POST['companyOwner'] == "on")
{
	echo "<br>";
	echo "is a company owner <br>";
	echo "company is " . $_POST['company'] . "<br>";

	if ($_POST['company'] == "added") 
	{
		echo "	companyName: " . $_POST['companySelect'] . "<br>";
	}else
	{
		echo "	companyName: " . $_POST['companyName'] . "<br>";
		echo "	companyStreet: " . $_POST['companyStreet'] . "<br>";
		echo "	companyInCharge: " . $_POST['companyInCharge'] . "<br>";
		echo "	companyPhone: " . $_POST['companyPhone'] . "<br>";
		echo "	companyMail: " . $_POST['companyMail'] . "<br>";
		echo "	companyWebsite: " . $_POST['companyWebsite'] . "<br>";
		echo "	companyDescription: " . $_POST['companyDescription'] . "<br>";
		echo "companyTown: " . $_POST['companyTown'] . "<br>";
		if ($_POST['companyTown'] == "added") 
		{
			echo "	town: " . $_POST['companyTownSelect'] . "<br>";
		}else
		{
			echo "	town: " . $_POST['newCompanyTown'] . "<br>";
		}
	}
}else
{
	echo "is NOT a company owner";
}
echo "<br>";
echo "<br>";
echo "<br>";
$id_user = addUser();
echo $id_user . "<br>";
if ($_POST['town'] == "added") 
{
	$id_town = addTown($_POST['townSelect']);
}else
{
	$id_town = addTown($_POST['newTown']);
}
echo "town id is: " . $id_town . "<br>";
if ($_POST['company'] == "added") 
{
	$id_company = addCompany($_POST['companySelect'], $id_town, $id_user);
}else
{
	$id_company = addCompany($_POST['companyName'], $id_town, $id_user);
}
mysql_query("INSERT INTO upor_podj (id_uporabnik, id_podjetje)
						    VALUES ('$id_user', '$id_company')");
addDriver($_POST['phone'], $id_town, $id_user)
