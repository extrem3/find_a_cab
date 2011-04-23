<?php
require('config.php');

$type = "asdf";

mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

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

switch ($type) {
	case 'company':
		//add a company and all the data

		$id_user = "23";
		$company_name = "2taxi1";
		$street = "2ulica";
		$person = "2ime pa priimek";
		$phone = "23131313";
		$fax = "/";
		$mail = "r2somemail@somewhere.com";
		$website = "w2somewhere.com";
		$description = "lol";
		$rating = "4";
		$id_town = '4';

		mysql_query("INSERT INTO podjetje (naziv, ulica, id_mesto, id_drzava, odg_oseba, tel, fax, email, www, opis, rating)
								   VALUES ('$company_name', '$street', '$id_town', '1', '$person', '$phone', '$fax', '$mail', '$website', '$description', '0')");
		//dobis id_podjetje, v naslednjem stringu uporabis pri ID_user

		$result = mysql_query("SELECT max(id_podjetje) FROM podjetje");
		$id_company = mysql_result($result, 0, 0);
		echo $id_company;

		mysql_query("INSERT INTO telefonske_st (ID_user, telefonske_st)
								   VALUES ('$id_user', '$phone')");
		mysql_query("INSERT INTO upor_podj (id_uporabnik, id_podjetje)
								   VALUES ('$id_user', '$id_company')");
		//dobis ID_telefonske
		$result = mysql_query("SELECT max(ID_telefonske_st) FROM telefonske_st");
		$id_phone = mysql_result($result, 0, 0);
		//ID_mesta dobis iz 'mesta'

		mysql_query("INSERT INTO mesta_telefonske (ID_mesta, ID_telefonske)
								   VALUES ('$id_town', '$id_phone')");
		break;
	case 'phoneNumber':
		//add another phone number

		$id_user = "23";
		$phone = "0123556";
		$id_town = '4';

		mysql_query("INSERT INTO telefonske_st (ID_user, telefonske_st)
								   VALUES ('$id_user', '$phone')");
		$result = mysql_query("SELECT max(ID_telefonske_st) FROM telefonske_st");
		$id_phone = mysql_result($result, 0, 0);
		//ID_mesta dobis iz 'mesta'

		mysql_query("INSERT INTO mesta_telefonske (ID_mesta, ID_telefonske)
								   VALUES ('$id_town', '$id_phone')");
		break;
	case 'test':
		$town = "celJe";
		if(mysql_num_rows(mysql_query("SELECT * FROM mesta WHERE mesto= '$town'"))>0) 
		{
			echo "already in";
		}else
		{
			echo "not in yet";
		}
		break;
	default:
		echo "type not specified";
		break;
}
echo "done";

?>
