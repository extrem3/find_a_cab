<?php
require('config.php');
$id = $_POST["id"];
echo "Searched for [" . $id . "]";
echo "<br><br>";
echo "<br><br>";
echo "It's - it's not like I WANT to show you your search results..";
echo "<br>";
echo "I j-just found too much.. Baka...";
echo "<br><br>";
echo "RESULTS HERE";

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="SELECT * FROM mesta";
$result=mysql_query($query);

$town = "Celje";


// first get id of town from 'mesta', (id_mesto), where mesto = $town
// then get id_telefonske from 'mesta_telefonske', where ID_mesta = mesto
// then get phone number from 'telefonske_st', where ID_telefonske_st = id_telefonske
// 		and user_id
// then get company id from 'upor_podj', where ID_uporabnik = user_id
// then get company name and rating from 'podjetje', where company_id = id_podjetje
// 		and user_name and surname from 'uporabniki' where id_uporabnik = user_id



while ($row = mysql_fetch_assoc($result)) {
    $row_text = $row['mesto'];
 
    print "$row_text<br/>\n";
}

mysql_close();
?>
