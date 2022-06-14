<?php
session_start();
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);

//ini_set('display_errors', '1');
$config = parse_ini_file("config.ini",true);

$database = $config["database"];
$servername = $database["servername"];
$username = $database["username"];
$password = $database["password"];
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
  while ($row = $result->fetch_assoc()) { //while Schleife, weil bei mir die mysql_fetch_assoc Variante nicht mag
    $prev_id = $row["max(n_id)"]; //die aktuell hoechste ID speichern
  }
} else {
  die("Couldn't query Nutzer"); // wenn ich gar keine ID kriege, ist was größer schiefgelaufen
}
$name = $_SESSION["name"];
$curr_id = $prev_id + 1;

$tre_val = array('0', '1', '2');
$hw_anforderungen = new Node($_GET["hw_anforderungen"], "passt zur Hardware", "l_name in (select l_name from Linux_HW_Anforderungen where hw_id = ", ")", $tre_val, 2);
$erfahrungsgrad = new Node($_GET["erfahrungsgrad"], "Erfahrungsgrad", "l_erfahrungsgrad in (", ")", $tre_val, 1);
$konfigurierbarkeit = new Node($_GET["konfigurierbarkeit"], "Konfigurierbarkeit bei der Installation", "l_konfigurierbarkeit = ", "", array('0', '1'), 5);
$aktualisierungen = new Node($_GET["aktualisierungen"], "Updatezyklus", "l_name in (select l_name from Linux_Aktualitaet where ak_id = ", ")", $tre_val, 3);
$secure_boot = new Node($_GET["secure_boot"], "Unterstützung von Secure Boot", "l_secure_boot = ", "", array('true', 'false'), 8);
$packetmanager = new Node($_GET["packetmanager"], "Packetmanager", "l_packetmanager = ", "", $tre_val, 7);
$quelloffen = new Node($_GET["quelloffen"], "quelloffene vs. proprietäre Treiber", "l_quelloffen = ", "", array('true', 'false'), 6);
$fragen = array($hw_anforderungen, $erfahrungsgrad, $konfigurierbarkeit, $aktualisierungen, $secure_boot, $packetmanager, $quelloffen);
//insert in die Tabelle Nutzer
$basic_insert = "INSERT INTO Nutzer (n_id, n_name, n_hw_anforderungen, n_erfahrungsgrad, n_konfigurierbarkeit, n_aktualisierungen, n_secure_boot, n_packetmanager, n_quelloffen)
VALUES ($curr_id, '$name', " . $fragen[0]->getVal() . ", " . $fragen[1]->getVal() . ", " . $fragen[2]->getVal() . ", " . $fragen[3]->getVal() . ", " . $fragen[4]->getVal() . ", " . $fragen[5]->getVal() . ", " . $fragen[6]->getVal() . ");";

if ($conn->query($basic_insert) === TRUE) {
  //echo "Neuer Nutzer angelegt <br>";
} else {
  //echo "Error: " . $basic_insert . "<br>" . $conn->error;
}

//insert in die Tabelle Nutzer_Desktop
$i = 0;
$desktop_selected = 'false';
$insert_n_desk = "";
while (isset($_GET["desktop"][$i])) {
  $curr_desk = htmlspecialchars($_GET["desktop"][$i]);
  $i++;
  if ($curr_desk == "Cinnamon" || $curr_desk == "Gnome" || $curr_desk == "KDE Plasma" || $curr_desk == "LxQt" || $curr_desk == "MATE" || $curr_desk == "Pantheon" || $curr_desk == "Xfce") {
    $insert_n_desk .= "INSERT INTO Nutzer_Desktop (n_id, d_name) VALUES ($curr_id, '$curr_desk');";

    $desktop_selected = 'true';
  } 
}
if (!($insert_n_desk == "")) {
  mysqli_multi_query($conn, $insert_n_desk);
}

//select Staement zum Nutzer suchen
$desktop_respected = "false";
$priority = 9;
$linuxe = array();
while ($priority > 0) {
  $am_i_the_first = 'true';
  $search_linux = "select l_name from Linux where ";
  for ($i = 0; $i < count($fragen); $i++) {
    $select = $fragen[$i]->get_select($priority, $am_i_the_first);
    if ($select == "") {
    } else {
      $search_linux .= $select;
      $select = "";
      $am_i_the_first = "false";
    }
  }
  if ($priority > 4 && $desktop_selected == 'true') {
    if ($am_i_the_first == 'false') {
      $search_linux .= " and ";
    }
    $search_linux .= "l_name in (select l_name from Linux_Desktop where d_name in (select d_name from Nutzer_Desktop where n_id = " . $curr_id . "))";
    $am_i_the_first = 'false';
    $desktop_respected = "true";
  }
  if ($am_i_the_first == 'true') {
    $search_linux = "select l_name from Linux;";
  }
  do {
    if ($res = $conn->store_result()) {
      $res->free();
    }
  } while ($conn->more_results() && $conn->next_result());

  $result = $conn->query($search_linux);
  if ($result->num_rows > 0) { //wenn irgendwas zurückgeliefert wird

    while ($row = $result->fetch_assoc()) {
      $curr_linux = $row["l_name"];

      if (in_array($curr_linux, $linuxe)) {
      } else {

        $linuxe[] = $curr_linux;
        $insert_nutzer_linux = "INSERT INTO Nutzer_Linux (n_id, l_name) VALUES ($curr_id, '$curr_linux');";

        $conn->query($insert_nutzer_linux);
        
      }
    }
    $priority = 0;
  } else {
    $desktop_respected = "false";
    for ($i = 0; $i < count($fragen); $i++) {
      $fragen[$i]->reset_used();
    }
    $priority--;
  }
}
$conn->close();

class Node
{
  public $sql_search = "";
  public $sql_search_end = "";
  public $curr_val = "";
  public $valid_val = array();
  public $output = "";
  public $prio = 0;
  public $used = 'false';

  function __construct($value, $new_output, $new_sql_search, $new_sql_search_end, $new_valid_val, $new_priority)
  {
    $this->output = $new_output;
    $this->sql_search = $new_sql_search;
    $this->sql_search_end = $new_sql_search_end;
    $this->valid_val = $new_valid_val;
    $this->prio = $new_priority;
    $this->curr_val = $this->testInput($value);
  }
  function testInput($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if (in_array($data, $this->valid_val)) {
      return $data;
    } else {
      return 'null';
    }
  }

  function get_select($curr_prio, $is_First)
  {
    if ($this->curr_val == 'null' || $this->prio > $curr_prio) {
      $this->used = 'false';
      return "";
    } else {
      $erg = "";
      if ($is_First == 'false') {
        $erg = " and ";
      }
      if ($this->output == 'Erfahrungsgrad') {
        if ($this->curr_val == 0) {
          $erg .= "l_erfahrungsgrad = 0";
        } else if ($this->curr_val == 1) {
          $erg .= "l_erfahrungsgrad in (0, 1)";
        } else if ($this->curr_val == 2) {
          $erg .= "l_erfahrungsgrad in (0, 1, 2)";
        } else {
        }
      } else if ($this->output == "Unterstützung von Secure Boot") {
        if ($this->curr_val == "false") {
          $erg = "";
        } else {
          $erg .= $this->sql_search . "true ";
        }
      } else {
        $erg .= $this->sql_search;
        $erg .= $this->curr_val;
        $erg .= $this->sql_search_end;
      }
      $this->used = 'true';
      return $erg;
    }
  }
  function reset_used()
  {
    $this->used = 'false';
  }
  function display()
  {
    if ($this->curr_val == 'null') {
      return "-1";
    } else if ($this->used == 'false') {
      return "-2";
    } else {
      return $this->output;
    }
  }

  function getVal()
  {
    return $this->curr_val;
  }
  function getOutput()
  {
    return $this->output;
  }
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="What is the best Linux Distribution for me?">
  <title>Welcome to our Distro-Chooser</title>
  <link rel="stylesheet" href="general.css">
  <script type="text/javascript" src="general.js"></script>
</head>

<body class="COLOR" >
  <header>
    <h1 id="header">Ergebnis</h1>
    <button id="dark" onclick="onClick('button')"><img src="Bilder/dark-white.png" type="img/png" title="Umstellen auf Dark/White-Mode" height="30px"></img></button>
  </header>

  <body>
    <?php
    if ($desktop_selected == 'true') {
      if ($desktop_respected == "false") {
        $values[] = "-2";
      } else {
        $values[] = "Unterstützung min. eines  Desktops";
      }
    }

    $links = array(
      "Linux Mint" => "https://linuxmint.com/",
      "Ubuntu" => "https://ubuntu.com/",
      "Debian" => "https://www.debian.org/",
      "Manjaro" => "https://manjaro.org/",
      "Fedora" => "https://getfedora.org/de/",
      "elementary OS" => "https://elementary.io/de/",
      "MX Linux" => "https://mxlinux.org/",
      "Arch Linux" => "https://archlinux.org/",
      "openSUSE Tumbleweed" => "https://get.opensuse.org/tumbleweed/"
    );
    if ((count($linuxe) > 1) && (count($linuxe) < 5)) {
      echo '<div class="grid-container" style="grid-template-columns: repeat(' . count($linuxe) . ', 1fr);">';
    } else if (count($linuxe) > 4) {
      echo '<div class="grid-container" style="grid-template-columns: repeat(' . round(count($linuxe) / 2) . ', 1fr);">';
    } else {
      echo '<div class="single_distro_container"> ';
    }
    for ($j = 0; $j < count($linuxe); $j++) {
      echo '<div class="oneCard">
                  <div class="oneCard_inner">
                    <div class="front">';
      echo '<h4>' . $linuxe[$j] . '</h4>';
      echo '<img class="logo" src="Bilder/' . $linuxe[$j] . '.png"></img>
                    </div>
                    <div class="back">
                      <h3>' . $linuxe[$j] . '</h3>
                    <table>';
      for ($i = 0; $i < count($fragen); $i++) {
        if ($fragen[$i]->display() == "-1") {
        } else if ($fragen[$i]->display() == "-2") {
          echo '<tr> <td><img class="OKNOK" src="Bilder/NOK.png"></img></td> <td>' . $fragen[$i]->getOutput() . '</td> </tr>';
        } else {
          echo '<tr> <td><img class="OKNOK" src="Bilder/OK.png"></img></td> <td>' . $fragen[$i]->getOutput() . '</td> </tr>';
        }
      }
      echo '    </table>';
      echo '<a href="' . $links[$linuxe[$j]] . '"> >>Zur Website </a>
                    </div>
                  </div>
                </div>';
    }

    echo "</div>";
    ?>
    <a class="button" href="auswertung.php?fragen=hw_anforderungen">Zur Auswertung</a>
  </body>
  <footer>
    <p>© Sabino, Schreckenast</p>
  </footer>
  <style type="text/css">
    .oneCard {
      background-color: transparent;
      width: 80%;
      height: 80%;
      left: 10%;
      top: 10%;
      position: relative;
      perspective: 1000px;
    }

    .oneCard_inner {
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

    .front,
    .back {
      position: absolute;
      width: 90%;
      height: 100%;
      left: 5%;
      background-color: var(--bc);
      -webkit-backface-visibility: hidden;
      /* Safari */
      backface-visibility: hidden;

    }

    .back {

      background-color: var(--bc);
      transform: rotateY(180deg);
    }

    .front {
      background-color: var(--bc);
      text-align: center;
      justify-content: center;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .OKNOK {
      width: 30px;
    }

    .logo {
      top: 50%;
      left: 50%;
      height: 55%;
      position: absolute;
      transform: translate(-50%, -50%);

    }

    .grid-container {
      display: grid;
      column-gap: 50px;
      row-gap: 50px;
      position: absolute;
      top: 12%;
      width: 90%;
      height: 70%;
      left: 5%;
    }

    .single_distro_container {
      top: 20%;
      width: 50%;
      height: 50%;
      left: 50%;
      transform: translate(-50%, 0%);
      position: absolute;
    }

    .button {
      position: absolute;
      top: 80%;
      left: 50%;
      transform: translate(-50%, 0%);
      width: 7%;
      height: 2.5%;
      color: var(--tc);
      animation: changecolor 50s infinite;
      border: 2px solid var(--tc);
    }

    h4 {
      padding: 5%;
      text-align: left;
    }

    table {
      padding: 5%;
    }

    a {
      color: var(--tc);
    }
  </style>

</html>