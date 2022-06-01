<?php
session_start();
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


// set parameters and execute
// name wird nicht getestet, weil das schon in der quiz.php passiert ist, beim Schreiben in die session
$name = $_SESSION["name"];
$hw_anforderungen = test_input($_GET["hw_anforderungen"]);
$erfahrungsgrad = test_input($_GET["erfahrungsgrad"]);
$konfigurierbarkeit = test_input($_GET["konfigurierbarkeit"]);
$aktualisierungen = test_input($_GET["aktualisierungen"]);
$secure_boot = test_input($_GET["secure_boot"]);
$packetmanager = test_input($_GET["packetmanager"]);
$quelloffen = test_input($_GET["quelloffen"]);

$sql = "INSERT INTO Nutzer (n_name, n_hw_anforderungen, n_erfahrungsgrad, n_konfigurierbarkeit, n_aktualisierungen, n_secure_boot, n_packetmanager, n_quelloffen)
VALUES ('$name', $hw_anforderungen, $erfahrungsgrad, $konfigurierbarkeit ,$aktualisierungen , $secure_boot,$packetmanager  , $quelloffen );";
echo $sql;
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
$conn->close();
?> 
