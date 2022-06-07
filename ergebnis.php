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

$servername = "localhost";
$username = "user";
$password = "password";
$dbname = "WhatstherightLinuxforme";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
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
  die("Coudnt query Nutzer");
}
// set parameters and execute
// name wird nicht getestet, weil das schon in der quiz.php passiert ist, beim Schreiben in die session
$name = $_SESSION["name"];
$curr_id = $prev_id +1;
$hw_anforderungen = test_input($_GET["hw_anforderungen"]);
$erfahrungsgrad = test_input($_GET["erfahrungsgrad"]);
$konfigurierbarkeit = test_input($_GET["konfigurierbarkeit"]);
$aktualisierungen = test_input($_GET["aktualisierungen"]);
$secure_boot = test_input($_GET["secure_boot"]);
$packetmanager = test_input($_GET["packetmanager"]);
$quelloffen = test_input($_GET["quelloffen"]);

$basic_insert = "INSERT INTO Nutzer (n_id, n_name, n_hw_anforderungen, n_erfahrungsgrad, n_konfigurierbarkeit, n_aktualisierungen, n_secure_boot, n_packetmanager, n_quelloffen)
VALUES ($curr_id, '$name', $hw_anforderungen, $erfahrungsgrad, $konfigurierbarkeit ,$aktualisierungen , $secure_boot,$packetmanager  , $quelloffen );";
echo $basic_insert;
if ($conn->query($basic_insert) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $basic_insert . "<br>" . $conn->error;
  }


$i = 0;
$insert_n_desk = "";
while(isset($_GET["desktop"][$i])){
  $curr_desk = test_input($_GET["desktop"][$i]);
  echo $curr_desk;
  $i++;
  $insert_n_desk .= "INSERT INTO Nutzer_Desktop (n_id, d_name) VALUES ($curr_id, '$curr_desk');";
}
if (mysqli_multi_query($conn, $insert_n_desk)) {
  echo "New records created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

//ab hier sind alle Daten des Nutzers in der Datenbank unter der id in curr_id
//jetzt muss das Linux gefunden werden
$search_linux = "select l_name from Linux where ";
if($hw_anforderungen == 0 || $hw_anforderungen == 2 || )
$conn->close();
?> 
