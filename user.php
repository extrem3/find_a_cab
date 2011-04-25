<?php
require('config.php');

mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

foreach(array_keys($_POST) as $key)
{
  $clean[$key] = mysql_real_escape_string($_POST[$key]);
}

$user_id = 3;

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
		$phoneId_query = mysql_query("SELECT * FROM telefonske_st WHERE ID_user='" . $user_id . "'");
		if(mysql_num_rows($phoneId_query)>0) 
		{
			$phone_row= mysql_fetch_assoc($phoneId_query);
			$phoneId = $phone_row['ID_telefonske_st'];
		}
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
		echo "phone deleted";
		break;
	default:
		echo "NO TYPE SPECIFIED";
		break;
}
