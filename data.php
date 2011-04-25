<?php
require('config.php');
mysql_connect($location,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

// returns username
function getUsername($user_id)
{
	$query = mysql_query("SELECT * FROM uporabniki WHERE id_uporabnik='" . $user_id . "'");
	if(mysql_num_rows($query)>0) 
	{
			$query_row= mysql_fetch_assoc($query);
			return $query_row['username'];
	}
	return "";
}
// returns email address
function getEmail($user_id)
{
	$query = mysql_query("SELECT * FROM uporabniki WHERE id_uporabnik='" . $user_id . "'");
	if(mysql_num_rows($query)>0) 
	{
			$query_row= mysql_fetch_assoc($query);
			return $query_row['email'];
	}
	return "";
}
// returns array with phone numbers and town names, where array[n][0] = phoneNumber and array[n][1] = townName
function getPhoneNumbers($user_id)
{
	$resultsArray = array();
	$query = mysql_query("SELECT * FROM telefonske_st WHERE ID_user='" . $user_id . "'");
	while($query_row = mysql_fetch_array($query))
	{
		$query2 = mysql_query("SELECT * FROM mesta_telefonske WHERE ID_telefonske='" . $query_row['ID_telefonske_st'] . "'");
		if(mysql_num_rows($query2)>0) 
		{
				$query_row2= mysql_fetch_assoc($query2);
				$query3 = mysql_query("SELECT * FROM mesta WHERE id_mesto='" . $query_row2['ID_mesta'] . "'");
				if(mysql_num_rows($query3)>0) 
				{
						$query_row3= mysql_fetch_assoc($query3);
						array_push($resultsArray, array($query_row['telefonske_st'], $query_row3['mesto']));
				}
		}
	}
	return (array)$resultsArray;
}
function getTowns()
{
	$resultsArray = array();
	$query = mysql_query("SELECT * FROM mesta ORDER BY mesto");
	while($query_row = mysql_fetch_array($query))
	{
		array_push($resultsArray, $query_row['mesto']);
	}
	return (array)$resultsArray;
}
/*

		<?php
			$user_id = 3;
			require('config.php');
			require('data.php');
			mysql_connect($location,$username,$password);
			@mysql_select_db($database) or die( "Unable to select database");
			
			$result = mysql_query("SELECT * FROM uporabniki WHERE id_uporabnik='" . $user_id . "'");
			while($row = mysql_fetch_array($result))
			{
				$company_id_query = mysql_query("SELECT id_podjetje FROM upor_podj WHERE id_uporabnik='" . $row['id_uporabnik'] . "'");
				if(mysql_num_rows($company_id_query)>0) 
				{
					$companyRow = mysql_fetch_assoc($company_id_query);
					$companyId = $companyRow['id_podjetje'];

					$company_query = mysql_query("SELECT * FROM podjetje WHERE id_podjetje='" . $companyId . "'");
					if(mysql_num_rows($company_query)>0) 
					{
						$realCompanyRow = mysql_fetch_assoc($company_query);
						$companyTitle = $realCompanyRow['naziv'];
					}
				}
				echo "<form action=\"admin.php?type=user&user_id=" . $row['id_uporabnik'] . "\" method=\"POST\" accept-charset=\"utf-8\">";
				echo "<div class=\"name\">User: " . $row['username'] . "[" . $row['ime'] . " " . $row['priimek'] . "]</div>";
				echo "<div class=\"email\">Email: " . $row['email'] . "</div>";
				$result2 = mysql_query("SELECT * FROM telefonske_st WHERE ID_user='" . $row['id_uporabnik'] . "'");
				while($townRow = mysql_fetch_array($result2))
				{
					$phone_id_query = mysql_query("SELECT ID_mesta FROM mesta_telefonske WHERE ID_telefonske='" . $townRow['ID_telefonske_st'] . "'");
					if(mysql_num_rows($phone_id_query)>0) 
					{
						$phoneRow = mysql_fetch_assoc($phone_id_query);
						$mestoId = $phoneRow['ID_mesta'];

						$town_id_query = mysql_query("SELECT mesto FROM mesta WHERE id_mesto='" . $mestoId . "'");
						if(mysql_num_rows($town_id_query)>0) 
						{
							$townRow2 = mysql_fetch_assoc($town_id_query);
							echo "<div class=\"phone\">Phone: " . $townRow['telefonske_st'] . " [" . $townRow2['mesto'] .  "]" . "</div>";
						}
					}
				}
				echo "<div class=\"company\">Company: " . $companyTitle . "</div>";
				echo "<input type=\"submit\" value=\"SAKUJO!!!\">";
				echo "</form><br>";
			}
		?>
*/
?>
