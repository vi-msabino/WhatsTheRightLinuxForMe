<?php
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);

//ini_set('display_errors', '1');
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
//Anzahl der Zeilen berechnen
$result = $conn->query("select count(*) from Nutzer_Linux;");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all = $row["count(*)"];
    }
} else {
    die("Couldn't query Nutzer");
}
$linuxe = array("Linux Mint", "Ubuntu", "MX Linux", "elementary OS", "Debian", "Manjaro", "Arch Linux", "Fedora", "openSUSE Tumbleweed");
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="Was ist die beste Linux Distribution für mich?">
    <title>Distro-Chooser</title>
    <link rel="shortcut icon" href="favicon.ico" title="ico" type="image/x-icon">
    <link rel="stylesheet" href="general.css">
    <script type="text/javascript" src="general.js"></script>
</head>

<body class="COLOR">
    <header>
        <h1 id="header">Was ist die beste Linux Distribution für mich?</h1>
        <button id="dark" onclick="onClick('button')"><img src="dark-white.png" type="img/png" title="Umstellen auf Dark/White-Mode" height="30px"></img></button>
    </header>
    <table class="linuxe">
    
    <?php
    
    for ($i = 0; $i < count($linuxe); $i++) {
        echo "<tr>";
        $result = $conn->query("select count(*) from Nutzer_Linux where l_name = '" . $linuxe[$i] . "';");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $curr = $row["count(*)"];
            }
        } else {
            die("Couldn't query Nutzer");
        }

        echo "<td>" . $linuxe[$i] . "</td><td> " . '<meter value="' . $curr . '" min="0" max="' . $all . '">25%</meter></td><td>' .  round($curr / $all * 100) . '%</td>';
        echo "</tr>";
    }
    ?>
    </table>
    <div class="second_box">
        <select name="fragen" id="fragen" form="fragen_auswaehlen">
            <option value="hw_anforderungen">Hareware Anforderungen</option>
            <option value="erfahrungsgrad">Erfahrungsgrad</option>
            <option value="konfigurierbarkeit">Konfigurierbarkeit</option>
            <option value="aktualisierungen">Update Zyklus</option>
            <option value="secure_boot">Secure Boot</option>
            <option value="packetmanager">Packetmanager</option>
            <option value="quelloffen">quelloffene Treiber</option>
            <option value="desktop">Desktop</option>
        </select>
        <form id="fragen_auswaehlen" method="get"><input type="submit" class="button" id="submit_Form_Button" value="Statistik zeigen" /></form>
        <div class="Linux_Fragen">
            <h3>Antwortverteilung bei den Distributionen</h3>
            <table>
                <?php
                $sql_linux = array(
                    "hw_anforderungen" => "select count(*) from Linux_HW_Anforderungen where hw_id = ",
                    "erfahrungsgrad" => "select count(*) from Linux where l_erfahrungsgrad = ",
                    "konfigurierbarkeit" => "select count(*) from Linux where l_konfigurierbarkeit = ",
                    "aktualisierungen" => "select count(*) from Linux_Aktualitaet where ak_id = ",
                    "secure_boot" => "select count(*) from Linux where l_secure_boot = ",
                    "packetmanager" => "select count(*) from Linux where l_packetmanager = ",
                    "quelloffen" => "select count(*) from Linux where l_quelloffen = ",
                    "desktop" => "select count(*) from Linux_Desktop where d_name = '"
                );
                $antwort = array(
                    "hw_anforderungen" => array("0", "1", "2"),
                    "erfahrungsgrad" => array("0", "1", "2"),
                    "konfigurierbarkeit" => array("0", "1"),
                    "aktualisierungen" => array("0", "1", "2"),
                    "secure_boot" => array("true", "false"),
                    "packetmanager" => array("0", "1", "2"),
                    "quelloffen" => array("true", "false"),
                    "desktop" => array("Cinnamon'", "Gnome'", "KDE Plasma'", "LxQt'", "MATE'", "Pantheon'", "Xfce'")
                );
                $antwort_lang = array(
                    "hw_anforderungen" => array("Uralt PCs", "Schwache Hardware", "Brandaktuelle Hardware"),
                    "erfahrungsgrad" => array("Anfänger", "Fortgeschritten", "Profi"),
                    "konfigurierbarkeit" => array("wenig Einstellungen", "viele Einstellungen"),
                    "aktualisierungen" => array("Rolling Release", "jährlich Updates", "Long time support"),
                    "secure_boot" => array("wird unterstützt", "wird nicht unterstützt"),
                    "packetmanager" => array("APT + DEB ", "RPM", "Packman"),
                    "quelloffen" => array("quelloffene Treiber", "proprietäre Treiber"),
                    "desktop" => array("Cinnamon", "Gnome", "KDE Plasma", "LxQt", "MATE", "Pantheon", "Xfce")
                );
                $relevant = $_GET["fragen"];
                $result = $conn->query("select count(*) from Linux;");
                
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $all_Linux = $row["count(*)"];
                        }
                    } else {
                        die("Couldn't query Nutzer");
                    }

                    $curr_antwort = $antwort[$relevant];
                    for ($i = 0; $i < count($curr_antwort); $i++) {
                        $result = $conn->query($sql_linux[$relevant] . $antwort[$relevant][$i] . ";");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $curr = $row["count(*)"];
                            }
                        } else {
                            die("Couldn't query Nutzer");
                        }
                        echo "<tr><td>" . $antwort_lang[$relevant][$i] . "</td><td> " . '<meter value="' . $curr . '" min="0" max="' . $all_Linux . '">25%</meter></td><td>' . round($curr / $all_Linux * 100) . '%</td></tr>';
                    }
                
                ?>
            </table>
        </div>
        <div class="Nutzer_Fragen">
            <h3>Antwortverteilung bei den Nutzern</h3>
            <table>
                <?php
                $sql_nutzer = array(
                    "hw_anforderungen" => "select count(*) from Nutzer where n_hw_anforderungen = ",
                    "erfahrungsgrad" => "select count(*) from Nutzer where n_erfahrungsgrad = ",
                    "konfigurierbarkeit" => "select count(*) from Nutzer where n_konfigurierbarkeit = ",
                    "aktualisierungen" => "select count(*) from Nutzer where n_aktualisierungen = ",
                    "secure_boot" => "select count(*) from Nutzer where n_secure_boot = ",
                    "packetmanager" => "select count(*) from Nutzer where n_packetmanager = ",
                    "quelloffen" => "select count(*) from Nutzer where n_quelloffen = ",
                    "desktop" => "select count(*) from Nutzer_Desktop where d_name = '"
                );
                $result = $conn->query("select count(*) from Nutzer;");

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $all_Nutzer = $row["count(*)"];
                    }
                } else {
                    die("Couldn't query Nutzer");
                }

                $curr_antwort = $antwort[$relevant];
                for ($i = 0; $i < count($curr_antwort); $i++) {
                    $result = $conn->query($sql_nutzer[$relevant] . $antwort[$relevant][$i] . ";");

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $curr = $row["count(*)"];
                        }
                    } else {
                        die("Couldn't query Nutzer");
                    }
                    echo "<tr><td>" . $antwort_lang[$relevant][$i] . "</td><td> " . '<meter value="' . $curr . '" min="0" max="' . $all_Nutzer . '">25%</meter></td><td>' .  round($curr / $all_Nutzer * 100) . '%</td></tr>';
                }
                ?>
            </table>
        </div>
        <p> <i> Hinweis: die Prozentangaben erreichen nicht immer 100%, <br> da manche Nutzer nicht alle Fragen beantworten <br> oder manche Distributionen mehrere Antwortmöglichkeiten unterstützen<i></p>
    </div>
    <footer>
        <p>© Sabino, Schreckenast</p>
    </footer>
    <style type="text/css">
        .linuxe {
            top: 45%;
            left: 10%;
            transform: translate(0%, -50%);
            position: absolute;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            padding: 4%;
            border-spacing: 10px;
        }

        .second_box {
            top: 45%;
            left: 50%;
            transform: translate(0%, -50%);
            position: absolute;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            padding: 4%;
        }

        .button {
            animation: changecolor 50s infinite;
            border: 2px solid var(--tc);
            left: 50%;
            color: var(--tc);
            position: relative;
        }

        select {
            background-color:var(--bc);
            color: var(--tc);
            border: 1px solid var(--tc);
            border-radius: 0px;
        }
    </style>
</body>

</html>