<?php
session_start();
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);

ini_set('display_errors', '1');
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if($data == null){
        $data = 'null';
    }
    return $data;
}

function checkForBetween0And2($data){
  if($data == 0 || $data == 1 || $data== 2){
    return $data;
  }else{
    return '-1';
  }
}
function checkForBetween0And1($data){
  if($data == 0 || $data == 1){
    return $data;
  }else{
    return '-1';
  }
}
function checkForTrueOrFalse($data){
  if($data == 'true' || $data == 'false'){
    return $data;
  }else{
    return 'null';
  }
}
$servername = "localhost";
$username = "user";
$password = "password";
$dbname = "WhatstherightLinuxforme";

// DB Verbindung herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// und überprüfen
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//naechste id für primärschlüssel suchen
$prev_id = '1000';
$result = $conn->query("SELECT max(n_id) FROM Nutzer;");

if ($result->num_rows > 0) { //wenn irgendwas zurückgeliefert wird
  while($row = $result->fetch_assoc()) { //while Schleife, weil bei mir die mysql_fetch_assoc Variante nicht mag
    $prev_id = $row["max(n_id)"]; //die aktuell hoechste ID speichern
  }
} else {
  die("Couldn't query Nutzer"); // wenn ich gar keine ID kriege, ist was größer schiefgelaufen
}

// name wird nicht getestet, weil das schon in der quiz.php passiert ist, beim Schreiben in die session
$name = $_SESSION["name"];
$curr_id = $prev_id +1;
//zeug aus der url lesen und überprüfen
$hw_anforderungen = checkForBetween0And2(test_input($_GET["hw_anforderungen"]));
$erfahrungsgrad = checkForBetween0And2(test_input($_GET["erfahrungsgrad"]));
$konfigurierbarkeit = checkForBetween0And1(test_input($_GET["konfigurierbarkeit"]));
$aktualisierungen = checkForBetween0And2(test_input($_GET["aktualisierungen"]));
$secure_boot = checkForTrueOrFalse(test_input($_GET["secure_boot"]));
$packetmanager = checkForBetween0And2(test_input($_GET["packetmanager"]));
$quelloffen = checkForTrueOrFalse(test_input($_GET["quelloffen"]));

//insert in die Tabelle Nutzer
$basic_insert = "INSERT INTO Nutzer (n_id, n_name, n_hw_anforderungen, n_erfahrungsgrad, n_konfigurierbarkeit, n_aktualisierungen, n_secure_boot, n_packetmanager, n_quelloffen)
VALUES ($curr_id, '$name', $hw_anforderungen, $erfahrungsgrad, $konfigurierbarkeit ,$aktualisierungen , $secure_boot,$packetmanager  , $quelloffen );";
echo $basic_insert;
if ($conn->query($basic_insert) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $basic_insert . "<br>" . $conn->error;
  }

//insert in die Tabelle Nutzer_Desktop
$i = 0;
$insert_n_desk = "";
while(isset($_GET["desktop"][$i])){
  $curr_desk = test_input($_GET["desktop"][$i]);
  $i++;
  if ($curr_desk == "Cinnamon" ||$curr_desk == "Gnome" ||$curr_desk == "KDE Plasma" ||$curr_desk == "LxQt" ||$curr_desk == "MATE" ||$curr_desk == "Pantheon" ||$curr_desk == "Xfce"){
    $insert_n_desk .= "INSERT INTO Nutzer_Desktop (n_id, d_name) VALUES ($curr_id, '$curr_desk');";
  }else{
    echo "unbekannter Desktop";
  }
}
if (mysqli_multi_query($conn, $insert_n_desk)) {
  echo "New records created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//ab hier sind alle Daten des Nutzers in der Datenbank unter der id in curr_id
//jetzt muss das Linux gefunden werden
$end = 9;
while($end > 0){
$search_linux = "select l_name from Linux";
if($end > 1){
  $search_linux .= " where ";
if($erfahrungsgrad == 0){
  $search_linux .= "l_erfahrungsgrad = 0";
  
}
if($erfahrungsgrad == 1){
  $search_linux .= " and ";
  $search_linux .= "l_erfahrungsgrad in (0, 1)";
}
if($erfahrungsgrad == 2){
  $search_linux .= " and ";
  $search_linux .= "l_erfahrungsgrad in (0, 1, 2)";
}
}else{
  $search_linux .= ";";
}
if($end > 1 && ($hw_anforderungen == 0 || $hw_anforderungen == 1 || $hw_anforderungen == 2)){
  $search_linux .= " and ";
  $search_linux .= "l_name in (select l_name from Linux_HW_Anforderungen where hw_id = ".$hw_anforderungen . ")";
}
if($end > 5 && ($konfigurierbarkeit == 0 || $konfigurierbarkeit == 1)){
  $search_linux .= " and ";
  $search_linux .= "l_konfigurierbarkeit = ".$konfigurierbarkeit;
}
if($end > 3 && ($aktualisierungen == 0 || $aktualisierungen == 1 || $aktualisierungen == 2)){
  $search_linux .= " and ";
  $search_linux .= "l_name in (select l_name from Linux_Aktualitaet where ak_id = ".$aktualisierungen . ")";
}
//suchparameter desktop, keine Grenzwertüberprüfung, weil schon beim Einfügen passiert
if($end > 4){
  $search_linux .= " and l_name in (select l_name from Linux_Desktop where d_name in (select d_name from Nutzer_Desktop where n_id = ".$curr_id."))";
}
if($end > 8 && $secure_boot == 'true'){
  $search_linux .= " and ";
  $search_linux .= "l_secure_boot = true";
}
if($end > 7 && ($packetmanager == 0 || $packetmanager == 1 || $packetmanager == 2)){
  $search_linux .= " and ";
  $search_linux .= "l_konfigurierbarkeit = ".$konfigurierbarkeit;
}
if($end > 6 && ($quelloffen == 'true' || $quelloffen == 'false')){
  $search_linux .= " and ";
  $search_linux .= "l_quelloffen = ".$quelloffen;
}

$search_linux .= ";";
echo $search_linux . "<br>";
$result = $conn->query($search_linux);

if ($result->num_rows > 0) { //wenn irgendwas zurückgeliefert wird
  while($row = $result->fetch_assoc()) { 
    echo ($row["l_name"]); 
  }
  $end = 0;
} else {
  echo("nix gefunden"); 
  $end--;
}
}
$conn->close();
?> 
