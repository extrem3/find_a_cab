<?php
require('config.php');

mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

foreach(array_keys($_GET) as $key)
{
  $clean[$key] = mysql_real_escape_string($_GET[$key]);
}

switch ($clean['type']) {
	case 'user':
		//delete him from 'uporabniki'
		mysql_query("DELETE FROM uporabniki WHERE id_uporabnik='" . $clean['user_id'] . "'");

		$phone_id_query = mysql_query("SELECT ID_telefonske_st FROM telefonske_st WHERE ID_user='" . $clean['user_id'] . "'");
		if(mysql_num_rows($phone_id_query)>0) 
		{
			$phoneRow = mysql_fetch_assoc($phone_id_query);
			$phone_id = $phoneRow['ID_telefonske_st'];
		}
		//delete him from 'telefonske_st'
		mysql_query("DELETE FROM telefonske_st WHERE ID_user='" . $clean['user_id'] . "'");
		//check if there is more than just this user we are deleting in this town
		$mesto_id_query = mysql_query("SELECT * FROM mesta_telefonske WHERE ID_telefonske='" . $phone_id . "'");
		$mestoRow = mysql_fetch_assoc($mesto_id_query);
		$mesto_id = $mestoRow['ID_mesta'];
		$mesto_id_query = mysql_query("SELECT * FROM mesta_telefonske WHERE ID_mesta='" . $mesto_id . "'");

		echo "number of towns: " . mysql_num_rows($mesto_id_query) . "<br>";
		if(mysql_num_rows($mesto_id_query)==1) 
		{
			mysql_query("DELETE FROM mesta WHERE id_mesto='" . $mesto_id . "'");
			echo "deleted his town";
		}
		//delete him from 'mesta_telefonske' and if his phone is the only in town, delete the town?
		mysql_query("DELETE FROM mesta_telefonske WHERE ID_telefonske='" . $phone_id . "'");

		//check if there is more than just this user we are deleting in this company
		$company_id_query = mysql_query("SELECT * FROM upor_podj WHERE id_uporabnik='" . $clean['user_id'] . "'");
		$companyRow = mysql_fetch_assoc($company_id_query);
		$company_id = $companyRow['id_podjetje'];
		$company_id_query = mysql_query("SELECT * FROM upor_podj WHERE id_podjetje='" . $company_id . "'");

		echo "number of companys: " . mysql_num_rows($company_id_query) . "<br>";
		if(mysql_num_rows($company_id_query)==1) 
		{
			mysql_query("DELETE FROM podjetje WHERE id_podjetje='" . $company_id . "'");
			echo "deleted his company";
		}
		//delete him from 'upor_podj'
		mysql_query("DELETE FROM upor_podj WHERE id_uporabnik='" . $clean['user_id'] . "'");

		echo "USER DELETED!";
		break;
	default:
		echo "NO TYPE SPECIFIED";
		break;
}
