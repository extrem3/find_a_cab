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
echo "<br><br>";

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="SELECT * FROM mesta";
$result=mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
    $row_text = $row['mesto'];
 
    print "$row_text<br/>\n";
}

?>
