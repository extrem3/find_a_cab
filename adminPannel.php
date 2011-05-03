<?php
	require('config.php');
	require('checkLogin.php');
	if($_SESSION['user_level'] <= 2)
	{
		header("Location: loginPannel.php");
	}
?>
<html>
<head>
	<title>Admin pannel</title>
	<script type="text/javascript" src="scr/jquery-1.5.1.js"></script>
</head>
<body>
	<div class="content">
		<div class="removeUser">Remove User:<br>
		<?php
			mysql_connect($location,$username,$password);
			@mysql_select_db($database) or die( "Unable to select database");
			
			$result = mysql_query("SELECT * FROM uporabniki ORDER BY username");
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
		</div>
	</div>
</body>
</html>
