<?php
require('config.php');

mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$user_id = 4;

foreach(array_keys($_POST) as $key)
{
  $clean[$key] = mysql_real_escape_string($_POST[$key]);
}

function addTown($town)
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


switch ($_GET['type']) {
	case 'username':
		//delete him from 'uporabniki'
		mysql_query("UPDATE uporabniki SET username='" . $clean['username'] . "' WHERE id_uporabnik='" . $user_id . "'");
		echo "username changed";
		break;
	case 'name':
		//delete him from 'uporabniki'
		mysql_query("UPDATE uporabniki SET ime='" . $clean['name'] . "',priimek='" . $clean['lastName'] . "' WHERE id_uporabnik='" . $user_id . "'");
		echo "name changed";
		break;
	case 'email':
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $clean['email']))
		{
			echo "faulty email";
			break;
		}
		mysql_query("UPDATE uporabniki SET email='" . $clean['email'] . "' WHERE id_uporabnik='" . $user_id . "'");
		echo "email changed";
		break;
	case 'password':
		$oldPassword_query = mysql_query("SELECT * FROM uporabniki WHERE id_uporabnik='" . $user_id . "'");
		if(mysql_num_rows($oldPassword_query)>0) 
		{
			$password_row= mysql_fetch_assoc($oldPassword_query);
			$oldPassword = $password_row['geslo'];
		}
		if($oldPassword != $clean['oldPassword'])
		{
			echo "old passwords do not match";
			break;
		}
		if($clean['password'] !== $clean['passwordCheck'] || strlen($clean['password']) < 4)
		{
			echo "new passwords do not match";
			break;
		}
		mysql_query("UPDATE uporabniki SET geslo='" . $clean['password'] . "' WHERE id_uporabnik='" . $user_id . "'");
		echo "password changed";
		break;
	case 'phone':
		$phoneId_query = mysql_query("SELECT * FROM telefonske_st WHERE ID_user='" . $user_id . "' AND telefonske_st='" . $clean['phone'] . "'");
		if(mysql_num_rows($phoneId_query)>0) 
		{
			$phone_row= mysql_fetch_assoc($phoneId_query);
			$phoneId = $phone_row['ID_telefonske_st'];
		}
		echo "userId= " . $user_id. "<br>";
		echo "phoneNumber= " . $clean['phone']. "<br>";
		echo "phoneId = " . $phoneId . "<br>";
		$mesto_id_query = mysql_query("SELECT * FROM mesta_telefonske WHERE ID_telefonske='" . $phoneId . "'");
		if(mysql_num_rows($mesto_id_query)>0) 
		{
			$mesto_row = mysql_fetch_assoc($mesto_id_query);
			$mesto_id = $mesto_row['ID_mesta'];
		}
		echo "mestoId= " . $mesto_id . "<br>";

		$mesto_id_query = mysql_query("SELECT * FROM mesta_telefonske WHERE ID_mesta='" . $mesto_id . "'");
		if(mysql_num_rows($mesto_id_query)==1) 
		{
			mysql_query("DELETE FROM mesta WHERE id_mesto='" . $mesto_id . "'");
		}
		mysql_query("DELETE FROM telefonske_st WHERE ID_user='" . $user_id . "' AND telefonske_st='" . $clean['phone'] . "'");
		mysql_query("DELETE FROM mesta_telefonske WHERE ID_telefonske='" . $phoneId . "'");
		echo "phone deleted";

		break;
	case 'addPhone':
		preg_match_all('/[0-9]+/', $clean['phone'], $cleaned);
		foreach($cleaned[0] as $k=>$v) {
		   $phoneNumber .= $v;
		}
		if(strlen($phoneNumber) > 9 || strlen($phoneNumber) < 7)
		{
			echo "phone number too short or long";
			break;
		}
		if(mysql_num_rows(mysql_query("SELECT * FROM telefonske_st WHERE telefonske_st= '$phoneNumber'"))>0) 
		{
			echo "phone number already in register";
			break;
		}
		
		mysql_query("INSERT INTO telefonske_st (ID_user, telefonske_st)
								   VALUES ('$user_id', '$phoneNumber')");

		$result = mysql_query("SELECT max(ID_telefonske_st) FROM telefonske_st");
		$telefonska_id = mysql_result($result, 0, 0);
		if ($clean['town'] == "added") 
		{
			$town_id = addTown($clean['townSelect']);
		}else
		{
			$town_id = addTown($clean['newTown']);
		}

		mysql_query("INSERT INTO mesta_telefonske (ID_mesta, ID_telefonske)
								   VALUES ('$town_id', '$telefonska_id')");
		echo "phone number added";
		break;
	case 'company':
		if(empty($clean['companyName']) || empty($clean['companyStreet']) || empty($clean['companyInCharge']) || empty($clean['companyTown']))
		{
			echo "some important fields are empty";
			break;
		}
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $clean['companyMail']))
		{
			echo "company mail is not cool";
			break;
		}
		preg_match_all('/[0-9]+/', $clean['companyPhone'], $cleaned);
		foreach($cleaned[0] as $k=>$v) {
		   $phoneNumber .= $v;
		}
		if(strlen($phoneNumber) > 9 || strlen($phoneNumber) < 7)
		{
			echo "lol phone number is invalid";
			break;
		}
		$company_id_query = mysql_query("SELECT * FROM upor_podj WHERE id_uporabnik='" . $user_id . "'");
		if(mysql_num_rows($company_id_query)>0) 
		{
			$company_row = mysql_fetch_assoc($company_id_query);
			$company_id = $company_row['id_podjetje'];
		}
		mysql_query("UPDATE podjetje SET naziv='" . $clean['companyName'] . "',ulica='" . $clean['companyStreet'] . "',mesto='" . $clean['companyTown'] . "',odg_oseba='" . $clean['companyInCharge'] . "',tel='" . $clean['companyPhone'] . "',fax='" . $clean['companyFax'] . "',email='" . $clean['companyMail'] . "',www='" . $clean['companyWebsite'] . "',opis='" . $clean['companyDescription'] . "' WHERE id_podjetje='" . $company_id . "'");
		echo "company details updated";
		break;
	case 'addCompany':
		$company_id_query = mysql_query("SELECT * FROM upor_podj WHERE id_uporabnik='" . $user_id . "'");
		if(mysql_num_rows($company_id_query)>0) 
		{
			$company_row = mysql_fetch_assoc($company_id_query);
			$company_id = $company_row['id_podjetje'];
		}
		$company_id_query2 = mysql_query("SELECT * FROM upor_podj WHERE id_podjetje='" . $company_id . "'");
		if(mysql_num_rows($company_id_query2)==1) 
		{
			// check if he is the only user of that company and
			//     remove old company which id you get from upor_podj
			mysql_query("DELETE FROM podjetje WHERE id_podjetje='" . $company_id . "'");
		}else
		{
			//if there are other users in the same company
			//     select first one and make him the owner
			$users_id_query = mysql_query("SELECT * FROM upor_podj WHERE id_podjetje='" . $company_id . "' AND NOT id_uporabnik='" . $user_id . "'");
			if(mysql_num_rows($users_id_query)>0) 
			{
				$users_row = mysql_fetch_assoc($users_id_query);
				$users_id = $users_row['id_uporabnik'];
				mysql_query("UPDATE uporabniki SET nivo='2' WHERE id_uporabnik='" . $users_id . "'");
			}
		}
		if ($clean['company'] == "added")
		{
			$id_company = addCompany($clean, $clean['companySelect'], $clean['companyTown'], $user_id, true);
			mysql_query("UPDATE uporabniki SET nivo='1' WHERE id_uporabnik='" . $user_id . "'");
		}else
		{
			$id_company = addCompany($clean, $clean['companyName'], $clean['companyTown'], $user_id, false);
			mysql_query("UPDATE uporabniki SET nivo='2' WHERE id_uporabnik='" . $user_id . "'");
		}
		mysql_query("UPDATE upor_podj SET id_podjetje='" . $id_company . "' WHERE id_uporabnik='" . $user_id . "'");
		echo "moved to new company";
		break;
	default:
		echo "NO TYPE SPECIFIED";
		break;
}
