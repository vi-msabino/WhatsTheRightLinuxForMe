<?php
session_start();
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);

//ini_set('display_errors', '1');
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
    return 'null';
  }
}
function checkForBetween0And1($data){
  if($data == 0 || $data == 1){
    return $data;
  }else{
    return 'null';
  }
}
function checkForTrueOrFalse($data){
  if($data == 'true' || $data == 'false'){
    return $data;
  }else{
    return 'null';
  }
}
function clearStoredResults(){
  global $conn;
  
  do {
       if ($res = $conn->store_result()) {
         $res->free();
       }
  } while ($conn->more_results() && $conn->next_result());        
  
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
//echo $basic_insert . "<br>";
if ($conn->query($basic_insert) === TRUE) {
    //echo "Neuer Nutzer angelegt <br>";
  } else {
    echo "Error: " . $basic_insert . "<br>" . $conn->error;
  }

//insert in die Tabelle Nutzer_Desktop
$i = 0;
$desktop_selected = 'false';
$insert_n_desk = "";
while(isset($_GET["desktop"][$i])){
  $curr_desk = test_input($_GET["desktop"][$i]);
  $i++;
  if ($curr_desk == "Cinnamon" ||$curr_desk == "Gnome" ||$curr_desk == "KDE Plasma" ||$curr_desk == "LxQt" ||$curr_desk == "MATE" ||$curr_desk == "Pantheon" ||$curr_desk == "Xfce"){
    $insert_n_desk .= "INSERT INTO Nutzer_Desktop (n_id, d_name) VALUES ($curr_id, '$curr_desk');";
    $desktop_selected = 'true';
  }else{
    echo "unbekannter Desktop";
  }
}
if(!($insert_n_desk == "")){
if (mysqli_multi_query($conn, $insert_n_desk)) {
  //echo "Desktop Auswahl gespeichert <br>";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

//ab hier sind alle Daten des Nutzers in der Datenbank unter der id in curr_id
//jetzt muss das Linux gefunden werden
$priority = 9;
$linuxe = array();

while($priority > 0){
  $am_i_the_first = 'true';
$search_linux = "select l_name from Linux";
if($priority > 1){
  $search_linux .= " where ";
if($erfahrungsgrad == 0){
  $search_linux .= "l_erfahrungsgrad = 0";
  $am_i_the_first = 'false';
}
if($erfahrungsgrad == 1){
  $search_linux .= "l_erfahrungsgrad in (0, 1)";
  $am_i_the_first = 'false';
}
if($erfahrungsgrad == 2){
  $search_linux .= "l_erfahrungsgrad in (0, 1, 2)";
  $am_i_the_first = 'false';
}
}else{
  $search_linux .= ";";
}
if($priority > 2 && ($hw_anforderungen == 0 || $hw_anforderungen == 1 || $hw_anforderungen == 2)){
  if($am_i_the_first == 'false'){
    $search_linux .= " and ";
  }
  $search_linux .= "l_name in (select l_name from Linux_HW_Anforderungen where hw_id = ".$hw_anforderungen . ")";
  $am_i_the_first = 'false';
}
if($priority > 5 && ($konfigurierbarkeit == 0 || $konfigurierbarkeit == 1)){
  if($am_i_the_first == 'false'){
    $search_linux .= " and ";
  }
  $search_linux .= "l_konfigurierbarkeit = ".$konfigurierbarkeit;
  $am_i_the_first = 'false';
}
if($priority > 3 && ($aktualisierungen == 0 || $aktualisierungen == 1 || $aktualisierungen == 2)){
  if($am_i_the_first == 'false'){
    $search_linux .= " and ";
  }
  $search_linux .= "l_name in (select l_name from Linux_Aktualitaet where ak_id = ".$aktualisierungen . ")";
  $am_i_the_first = 'false';
}
//suchparameter desktop, keine Grenzwertüberprüfung, weil schon beim Einfügen passiert
if($priority > 4 && $desktop_selected){
  if($am_i_the_first == 'false'){
    $search_linux .= " and ";
  }
  $search_linux .= "l_name in (select l_name from Linux_Desktop where d_name in (select d_name from Nutzer_Desktop where n_id = ".$curr_id."))";
  $am_i_the_first = 'false';
}
if($priority > 8 && $secure_boot == 'true'){
  if($am_i_the_first == 'false'){
    $search_linux .= " and ";
  }
  $search_linux .= "l_secure_boot = true";
  $am_i_the_first = 'false';
}
if($priority > 7 && ($packetmanager == 0 || $packetmanager == 1 || $packetmanager == 2)){
  if($am_i_the_first == 'false'){
    $search_linux .= " and ";
  }
  $search_linux .= "l_packetmanager = ".$packetmanager;
  $am_i_the_first = 'false';
}
if($priority > 6 && ($quelloffen == 'true' || $quelloffen == 'false')){
  if($am_i_the_first == 'false'){
    $search_linux .= " and ";
  }
  $search_linux .= "l_quelloffen = ".$quelloffen;
  $am_i_the_first = 'false';
}
if($am_i_the_first == 'true'){
  $search_linux = "select l_name from Linux";
}
//echo $search_linux;
clearStoredResults();
$linuxe = array();
$result = $conn->query($search_linux);

if ($result->num_rows > 0) { //wenn irgendwas zurückgeliefert wird
  
  while($row = $result->fetch_assoc()) { 
    if(in_array($row["l_name"], $linuxe)){

    }else{
      $linuxe[] = array($row["l_name"], $priority);
      //echo $row["l_name"] . "   " . $priority;
    }
    
  }
  /*if(count($linuxe) > 3){
    $priority = 0;
  }else{
    $priority--;
  }*/
  $priority = 0;
} else {

  $priority--;
}

}
$conn->close();
?> 
<!DOCTYPE html>
<html lang="de">
<head> 
    <meta charset="utf-8">
    <meta name="What is the best Linux Distribution for me?">
    <title>Welcome to our Distro-Chooser</title>
    <link rel="shortcut icon" href="favicon.ico" title="ico" type="image/x-icon">
    <link rel="stylesheet" href="general.css">
    <!--link rel="stylesheet" href="style.css"-->
    <script type="text/javascript" src="general.js"></script>
</head>
<body class="COLOR">
    <header> 
        <h1 id="header">What is the best Linux Distribution for me?</h1> 
        <button id="dark" onclick="onClick('button')"><img src="dark-white.png" type="img/png" title="Umstellen auf Dark/White-Mode" height="30px"></img></button>
    </header>
    <body>
      <?php
        $values = array();
        if($erfahrungsgrad == 0 || $erfahrungsgrad == 1 || $erfahrungsgrad == 2){
          $values[] = "Erfahrungsgrad (ggf. auch für unerfahrenere Nutzer geeigent)";
        }else{
          $values[] = "-1";
        }
        if($hw_anforderungen == 0 || $hw_anforderungen == 1 || $hw_anforderungen == 2){
          $values[] = "passt zur Hardware";
        }else{
          $values[] = "-1";
        }
        if($aktualisierungen == 0 || $aktualisierungen == 1 || $aktualisierungen == 2){
          $values[] = "Update Rythmus";
        }else{
          $values[] = "-1";
        }
        if($desktop_selected == 'true'){
          $values[] = "Unterstützung min. eines  Desktops"; 
        }
        if($konfigurierbarkeit == 0 || $konfigurierbarkeit == 1){
          $values[] = "Konfigurierbarkeit bei der Installation";
        }else{
          $values[] = "-1";
        }
        if($quelloffen == 'true' || $quelloffen == 'false'){
          if($quelloffen == "true"){
            $values = "ausschlieslich von quelloffene Treiber";
          }else{
            $values = "Integration von proprietären Treibern";
          }
        }else{
          $values[] = "-1";
        }
        if($packetmanager == 0 || $packetmanager == 1 || $packetmanager == 2){
          $values[] = "Packetmanager";
        }else{
          $values[] = "-1";
        }
        if($secure_boot == 'true' || $secure_boot == "false"){
          $values[] = "Unterstützung von Secure Boot";
        }else{
          $values[] = "-1";
        }
        
        if((count($linuxe) > 1) && (count($linuxe)<5)){
          echo '<div class="grid-container" style="grid-template-columns: repeat('. count($linuxe) .', 1fr);">';
        }else if(count($linuxe)>4){
          if((count($linuxe)%2) == 0){
          echo '<div class="grid-container" style="grid-template-columns: repeat('. count($linuxe)/2 .', 1fr);">';
          }else{
            $rows_grid = count($linuxe)-1;
            echo '<div class="grid-container" style="grid-template-columns: repeat('. $rows_grid/2 .', 1fr);">';
          }
        }else{
          echo '<div class="single_distro_container"> ';
        }
        for($j=0; $j<count($linuxe); $j++){
          echo '<div class="oneCard">
                  <div class="oneCard_inner">
                    <div class="front">';
          echo '<h4>'.$linuxe[$j][0].'</h4>';
          echo        '<img class="logo" src="Bilder/' . $linuxe[$j][0] . '.png"></img>
                    </div>
                    <div class="back">
                      <h3>' . $linuxe[$j][0] . '</h3>
                    <table>';
                    for($i=0; $i<count($values); $i++){
                      if($values[$i] == "-1"){

                      }else{
                      echo '<tr> <td><img class="OKNOK" src="Bilder/';
                      echo ($linuxe[$j][1] > $i) ? 'OK.png' : 'NOK.png';
                      echo '"></img></td> <td>'. $values[$i] . '</td> </tr>';
                      }
                    }
          echo '    </table>
                    </div>
                  </div>
                </div>';
            }
                  
      echo "</div>";
      ?>
    </body>
    <footer>
        <p>© Sabino, Schreckenast</p>
    </footer>
    <style type="text/css">
      .oneCard {
        background-color: transparent;
        width: 80%;
        height: 80%;
        perspective: 1000px;
      }
      .oneCard_inner{
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s;
        transform-style: preserve-3d;
      }
      .oneCard:hover .oneCard_inner {
        transform: rotateY(180deg);
      }
      .front, .back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden; /* Safari */
        backface-visibility: hidden;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      }
      .back{
        background-color: var(--bc);
        transform: rotateY(180deg);
      }
      .front{
        background-color: var(--bc);
        text-align: center;
        justify-content: center;
      }
      .OKNOK{
        width:30px;
      }
      .logo{
        /*width:50%;*/
        top:50%;
        left:50%;
        height:55%;
        position: absolute;
        transform: translate(-50%,-50%);

      }
      .grid-container{
        display:grid;
        column-gap: 50px;
        row-gap: 50px;
        position: absolute;
        top: 12%;
        width: 90%;
        height: 70%;
        left: 5%;
      }
      .single_distro_container{
        top: 16%;
        width: 60%;
        height: 60%;
        left: 20%;
        position: absolute;
      }
      h4{
        padding: 5%;
        text-align: left;
      }
    </style>
</html>
