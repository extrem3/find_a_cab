<?php
require('config.php');
require('checkLogin.php');

mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");



foreach(array_keys($_POST) as $key)
{
  $clean[$key] = mysql_real_escape_string($_POST[$key]);
}

$errorsDescriptions = array('Uporabniško ime je že v uporabi.',
                            'email_regex',
                            'email_exists',
                            'phone_regex',
                            'phone_exists',
                            'passwords do not match or are too short, ',
                            'company_mail_regex, ',
                            'company_phone_regex',
                            'username too short or empty',
                            'firstName field empty or too short',
                            'lastName field empty or too short',
                            'town is empty if user is a driver',
                            'companyName is missing',
                            'companyStreet is missing',
                            'companyInCharge is missing',
                            'newCompanyTown is missing');

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
		mysql_query("UPDATE uporabniki SET nivo='2' WHERE id_uporabnik='" . $user_id . "'");
		mysql_query("INSERT INTO podjetje (naziv, ulica, mesto, id_drzava, odg_oseba, tel, fax, email, www, opis, rating)
								   VALUES ('$companyName', '" . $clean['companyStreet'] . "', '$town_id', '1', '" . $clean['companyInCharge'] . "', '" . $clean['companyPhone'] . "', '" . $clean['companyFax'] . "', '" . $clean['companyMail'] . "', '" . $clean['companyWebsite'] . "', '" . $clean['companyDescription'] . "', '0')");

		$result = mysql_query("SELECT max(id_podjetje) FROM podjetje");
		return mysql_result($result, 0, 0);
	}
	return 0;
}

function checkUsernames($uname)
{

	$unameQuery = mysql_query("SELECT * FROM uporabniki WHERE username='" . $uname . "'");
	if(mysql_num_rows($unameQuery)>0) 
	{
		return 0;
	}
	return 1;
}


switch ($_GET['type']) {
	case 'all':
    $errors = array();
		mysql_query("UPDATE uporabniki SET ime='" . $clean['name'] . "',priimek='" . $clean['lastName'] . "' WHERE id_uporabnik='" . $user_id . "'");
		echo "name changed<br>";
		//email
		if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $clean['email']))
		{
			mysql_query("UPDATE uporabniki SET email='" . $clean['email'] . "' WHERE id_uporabnik='" . $user_id . "'");
			echo "email changed<br>";
		}
		//password
		$oldPassword_query = mysql_query("SELECT * FROM uporabniki WHERE id_uporabnik='" . $user_id . "'");
		if(mysql_num_rows($oldPassword_query)>0) 
		{
			$password_row= mysql_fetch_assoc($oldPassword_query);
			$oldPassword = $password_row['geslo'];
		}
		if($oldPassword == $clean['oldPassword'] && $clean['password'] == $clean['passwordCheck'] && strlen($clean['password']) > 4)
		{
			mysql_query("UPDATE uporabniki SET geslo='" . $clean['password'] . "' WHERE id_uporabnik='" . $user_id . "'");
			echo "password changed<br>";
		}
		if(isset($_GET['companyOwner']))
		{
			$company_id_query = mysql_query("SELECT * FROM upor_podj WHERE id_uporabnik='" . $user_id . "'");
			if(mysql_num_rows($company_id_query)>0) 
			{
				$company_row = mysql_fetch_assoc($company_id_query);
				$company_id = $company_row['id_podjetje'];
			}
			if (!empty($clean['companyName']))
			{
				mysql_query("UPDATE podjetje SET naziv='" . $clean['companyName'] . "' WHERE id_podjetje='" . $company_id . "'");
			}
			if (!empty($clean['companyTown']))
			{
				mysql_query("UPDATE podjetje SET mesto='" . $clean['companyTown'] . "' WHERE id_podjetje='" . $company_id . "'");
			}
			if (!empty($clean['companyInCharge']))
			{
				mysql_query("UPDATE podjetje SET odg_oseba='" . $clean['companyInCharge'] . "' WHERE id_podjetje='" . $company_id . "'");
			}
			if (!empty($clean['companyStreet']))
			{
				mysql_query("UPDATE podjetje SET ulica='" . $clean['companyStreet'] . "' WHERE id_podjetje='" . $company_id . "'");
			}
			if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $clean['companyMail']))
			{
				mysql_query("UPDATE podjetje SET email='" . $clean['companyMail'] . "' WHERE id_podjetje='" . $company_id . "'");
			}
			preg_match_all('/[0-9]+/', $clean['companyPhone'], $cleaned);
			$phoneNumber = "";
			foreach($cleaned[0] as $k=>$v) {
			   $phoneNumber .= $v;
			}
			if(!(strlen($phoneNumber) > 9 || strlen($phoneNumber) < 7))
			{
				mysql_query("UPDATE podjetje SET tel='" . $clean['companyPhone'] . "' WHERE id_podjetje='" . $company_id . "'");
			}
			mysql_query("UPDATE podjetje SET fax='" . $clean['companyFax'] . "',www='" . $clean['companyWebsite'] . "',opis='" . $clean['companyDescription'] . "' WHERE id_podjetje='" . $company_id . "'");
			echo "company details updated";
		}
		break;
	case 'phone':
		$phoneId_query = mysql_query("SELECT * FROM telefonske_st WHERE ID_user='" . $user_id . "' AND telefonske_st='" . $clean['phone'] . "'");
		if(mysql_num_rows($phoneId_query)>0) 
		{
			$phone_row= mysql_fetch_assoc($phoneId_query);
			$phoneId = $phone_row['ID_telefonske_st'];
      $mesto_id_query = mysql_query("SELECT * FROM mesta_telefonske WHERE ID_telefonske='" . $phoneId . "'");
      if(mysql_num_rows($mesto_id_query)>0) 
      {
        $mesto_row = mysql_fetch_assoc($mesto_id_query);
        $mesto_id = $mesto_row['ID_mesta'];
      }

      $mesto_id_query = mysql_query("SELECT * FROM mesta_telefonske WHERE ID_mesta='" . $mesto_id . "'");
      if(mysql_num_rows($mesto_id_query)==1) 
      {
        mysql_query("DELETE FROM mesta WHERE id_mesto='" . $mesto_id . "'");
      }
      mysql_query("DELETE FROM telefonske_st WHERE ID_user='" . $user_id . "' AND telefonske_st='" . $clean['phone'] . "'");
      mysql_query("DELETE FROM mesta_telefonske WHERE ID_telefonske='" . $phoneId . "'");
      echo "done";
		} else
    {
      echo "WOW HAXX0RZ";
    }

		break;
	case 'addPhone':
		preg_match_all('/[0-9]+/', $clean['phone'], $cleaned);
		$phoneNumber = "";
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
		if(strlen($clean['newTown']) <= 1)
    {
			echo "Town name too short";
			break;
    }
		
		mysql_query("INSERT INTO telefonske_st (ID_user, telefonske_st)
								   VALUES ('$user_id', '$phoneNumber')");

		$result = mysql_query("SELECT max(ID_telefonske_st) FROM telefonske_st");
		$telefonska_id = mysql_result($result, 0, 0);
		$town_id = addTown($clean['newTown']);

		mysql_query("INSERT INTO mesta_telefonske (ID_mesta, ID_telefonske)
								   VALUES ('$town_id', '$telefonska_id')");
		echo "done";
		break;
	case 'company':
		if(empty($clean['companyName']) || empty($clean['companyStreet']) || empty($clean['companyInCharge']) || empty($clean['companyTown']))
		{
			echo "some important fields are empty";
			break;
		}
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $clean['companyMail']))
		{
			echo "company mail is not cool";
			break;
		}
		preg_match_all('/[0-9]+/', $clean['companyPhone'], $cleaned);
	   $phoneNumber = "";
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
    $errors = array();
		if(empty($clean['companyName']))
			array_push($errors, 13);
		if(empty($clean['companyStreet']))
			array_push($errors, 14);
		if(empty($clean['companyInCharge']))
			array_push($errors, 15);
		if(empty($clean['companyTown']))
			array_push($errors, 16);
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $_POST['companyMail']))
			array_push($errors, 7);
		preg_match_all('/[0-9]+/', $clean['companyPhone'], $cleaned);
   $phoneNumber = '';
		foreach($cleaned[0] as $k=>$v) {
		   $phoneNumber .= $v;
		}
		if(strlen($phoneNumber) > 9 || strlen($phoneNumber) < 5)
			array_push($errors, 8);
    if (count($errors) > 0)
    {
      for ($i = 0; $i < count($errors); ++$i)
      {
        echo '<div class="error">' . $errors[$i] . '</div><div class="description">' . $errorsDescriptions[$errors[$i] - 1] . '</div>';
      }
      break;
    }
    $id_company = 0;
		if (isset($_GET['exists']))
		{
			$id_company = addCompany($clean, $clean['companySelect'], 0, $user_id, true);
			mysql_query("UPDATE uporabniki SET nivo='1' WHERE id_uporabnik='" . $user_id . "'");
		}else
		{
			$id_company = addCompany($clean, $clean['companyName'], $clean['companyTown'], $user_id, false);
			mysql_query("UPDATE uporabniki SET nivo='2' WHERE id_uporabnik='" . $user_id . "'");
		}

		$company_id_query = mysql_query("SELECT * FROM upor_podj WHERE id_uporabnik='" . $user_id . "'");
		$company_id = 0;
		if(mysql_num_rows($company_id_query)>0) 
		{
			$company_row = mysql_fetch_assoc($company_id_query);
			$company_id = $company_row['id_podjetje'];
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
			mysql_query("UPDATE upor_podj SET id_podjetje='" . $id_company . "' WHERE id_uporabnik='" . $user_id . "'");
		}else
		{

			mysql_query("INSERT INTO upor_podj (id_podjetje, id_uporabnik)
										VALUES ('$id_company', '$user_id')");
		}
    echo 'done';
		break;
	default:
		echo "NO TYPE SPECIFIED";
		break;
}
