
<?php
session_start();

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', '1');
/*echo "<p>";
echo $_SESSION["name"];
echo "s Input:";
echo $_GET["erfahrung"];
echo $_GET["hardware"];
echo $_GET["anpassung"];

echo "</p>";*/

$db = mysqli_connect('localhost','root', '985237985237','WhatstherightLinuxforme')
or die('Error connecting to MySQL server.');
$query = "insert into Nutzer (n_name, n_hw_anforderungen, n_erfahrungsgrad, n_konfigurierbarkeit, n_aktualisierungen, n_secure_boot, n_packetmanager, n_quelloffen) values ("$_SESSION["name"]", "$_GET["hw_anforderungen"]", "$_GET["erfahrungsgrad"]", "$_GET["konfigurierbarkeit"]", "$_GET["aktualisierungen"]", "$_GET["secure_boot"]", "$_GET["packetmanager"]", "$_GET["quelloffen"]");";
echo $query;
//mysqli_query($db, $query) or die('Error querying database.');
/*$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);

while ($row = mysqli_fetch_array($result)) {
 echo $row['d_name'] . ' ' . $row['d_pfad_bild'] . ': ' . $row['d_windows_look'] .'<br />';
}*/
mysqli_close($db);
?>