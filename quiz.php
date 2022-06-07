<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="What is the best Linux Distribution for me?">
    <title>Welcome to our Distro-Chooser</title>
    <link rel="stylesheet" href="general.css">
    <!--link rel="stylesheet" href="quiz.css"-->
    <script type="text/javascript" src="general.js"></script>
</head>
<body>
<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

ini_set('display_errors', '1');
$_SESSION["name"] = test_input($_GET["vorname"]);
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
    <header> 
        <h1 id="header">Was ist die beste Linux Distribution für mich?</h1> 
        <button id="dark" onclick="onClick('button')"><img src="dark-white.png" type="img/png" title="Umstellen auf Dark/White-Mode" height="30px"></img></button>
    </header>
    <main>
    <form method="get" action="ergebnis.php">
    <div class="Frage" id="erfahrungsgrad">    
      <h3>Wie viel Erfahrung haben Sie im Umgang mit Computern?</h3>
      <div class="Antworten">
        <input type="radio" name="erfahrungsgrad" value="0">
        <label>Ich brauche Hilfe bei den vielen Problemen</label><br>
        <input type="radio" name="erfahrungsgrad" value="1">
        <label>Ich kann kleinere Schwierigkeiten selbst bewältigen</label><br>
        <input type="radio" name="erfahrungsgrad" value="2">
        <label>Ich komme mit Problemen gut klar</label><br>
      </div>
    </div>
    <div class="Frage" id="hw_anforderungen">
        <h3>Auf welcher Hardware soll das Linux ausgeführt werden</h3>
      <div class="Antworten">
        <input type="radio" name="hw_anforderungen" value="0">
        <label>Sehr alte Hardware mit 32 bit (Das ist bei Hardware, die jünger wie 5 Jahre ist, meist nicht der Fall)</label><br>
        <input type="radio" name="hw_anforderungen" value="1">
        <label>Schwache Hardware</label><br>
        <input type="radio" name="hw_anforderungen" value="2">
        <label>System mit den neusten technischen Spielereien</label><br>
        <input type="radio" name="hw_anforderungen" value="-1">
        <label>Ich möchte virtualisieren oder habe durchschnittliche Hardware</label><br>
      </div>
    </div>
    <div class="Frage" id="konfigurierbarkeit">    
        <h3>Ist Ihnen eine hohe Konfigurierbarkeit bei Start wichtig?</h3>
      <div class="Antworten">
        <input type="radio" name="konfigurierbarkeit" value="0">
        <label>Ja, ich möchte sehr viel beim ersten Startvorgang einstellen</label><br>
        <input type="radio" name="konfigurierbarkeit" value="1">
        <label>Nein, ich möchte mich auf Voreinstellungen verlassen</label><br>
        <input type="radio" name="konfigurierbarkeit" value="-1">
        <label>Ich habe keine Präferenz</label><br>
      </div>
    </div>
    <div class="Frage" id="Aktualisierungen">    
        <h3>Welchen Update-Rytmus bevorzugen Sie?</h3>
      <div class="Antworten">
        <input type="radio" name="aktualisierungen" value="0">
        <label>häufige Updates und neueste Software mit erhöhter Fehleranfälligkeit</label><br>
        <input type="radio" name="aktualisierungen" value="1">
        <label>jährliche große und stabile Updates mit etwas langsameren Zugang zu den neuesten Tools</label><br>
        <input type="radio" name="aktualisierungen" value="2">
        <label>Updates ohne große Änderungen und guter Unterstützung älterer Projekte, aber ohne die neuesten Tools</label><br>
        <input type="radio" name="aktualisierungen" value="-1">
        <label>Ich habe keine Präferenz</label><br>
      </div>
    </div>
    <div class="Frage" id="WinOderMac">    
        <h3>Welches Betriebssystem gefällt Ihnen optisch am besten</h3>
      <div class="Antworten">
        <input type="radio" name="winmac" value="true">
        <label>Windows</label><br>
        <input type="radio" name="winmac" value="false">
        <label>Mac OS</label><br>
        <input type="radio" name="winmac" value="null">
        <label>Ich habe keine Präferenz</label><br>
      </div>
    </div>
    <div class="Frage" id="Desktop">
    <h3>Welcher dieser Desktops gefällt Ihnen am besten?</h3>
      <div class="AntwortenMitBild" id="Win_Desktop_Antwort">
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="cinnamon">
          <img src="Bilder/cinnamon.png" alt="cinnamon" >
          <label>Cinnamon</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="KDE Plasma">
          <img src="Bilder/kde.png" alt="kde" >
          <label>KDE Plasma</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="LxQt">
          <img src="Bilder/lxqt.png" alt="lxgt" >
          <label>LxQt</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="MATE">
          <img src="Bilder/mate.png" alt="mate" >
          <label>MATE</label>
        </div>
      </div>
      <div class="AntwortenMitBild" id="Mac_Desktop_Antwort">
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="Gnome">
          <img src="Bilder/gnome.png" alt="gnome" >
          <label>Gnome</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="Pantheon">
          <img src="Bilder/pantheon.png" alt="pantheon" >
          <label>Pantheon</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="Xfce">
          <img src="Bilder/xfce.png" alt="xfce" >
          <label>Xfce</label>
        </div>
        
      </div>
      <div class="AntwortenMitBild" id="All_Desktop_Antwort">
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="Gnome">
          <img src="Bilder/gnome.png" alt="gnome" >
          <label>Gnome</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="MATE">
          <img src="Bilder/mate.png" alt="mate" >
          <label>MATE</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="Pantheon">
          <img src="Bilder/pantheon.png" alt="pantheon" >
          <label>Pantheon</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="cinnamon">
          <img src="Bilder/cinnamon.png" alt="cinnamon" >
          <label>Cinnamon</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="KDE Plasma">
          <img src="Bilder/kde.png" alt="kde" >
          <label>KDE Plasma</label>
        </div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="LxQt">
          <img src="Bilder/lxqt.png" alt="lxgt" >
          <label>LxQt</label>
        </div>
        <div></div>
        <div class="Desktop_Option">
          <input type="checkbox" name="desktop[]" value="Xfce">
          <img src="Bilder/xfce.png" alt="xfce" >
          <label>Xfce</label>
        </div>
      </div>
    </div>
    <div class="Frage" id="secure_boot">    
        <h3>Möchten Sie Secure Boot nutzen?</h3>
      <div class="Antworten">
        <input type="radio" name="secure_boot" value="true">
        <label>Ja</label><br>
        <input type="radio" name="secure_boot" value="false">
        <label>Nein</label><br>
        <input type="radio" name="secure_boot" value="null">
        <label>Ich habe keine Präferenz</label><br>
      </div>
    </div>
    <div class="Frage" id="packetmanager">    
        <h3>Welchen Packetmanager bevorzugen Sie?</h3>
      <div class="Antworten">
        <input type="radio" name="packetmanager" value="0">
        <label>APT und DEB</label><br>
        <input type="radio" name="packetmanager" value="1">
        <label>RPM</label><br>
        <input type="radio" name="packetmanager" value="2">
        <label>PACMAN</label><br>
        <input type="radio" name="packetmanager" value="-1">
        <label>Ich bin nicht sicher, was ein Packetmanager ist oder habe keine Präferenz</label><br>
      </div>
    </div>
    <div class="Frage" id="quelloffen">    
        <h3>Bevorzugen Sie offene oder proprietäre Treiber?</h3>
      <div class="Antworten">
        <input type="radio" name="quelloffen" value="true">
        <label>offene Treiber/Software</label><br>
        <input type="radio" name="quelloffen" value="false">
        <label>proprietäre Treiber und Software darf vorinstalliert sein</label><br>
        <input type="radio" name="quelloffen" value="null">
        <label>Ich habe keine Präferenz</label><br>
      </div>
    </div>
      
    <input type="button" class="button" onclick="naechsteFrage()" id="next" value=">>"/>
    <input type="button" class="button" onclick="vorherigeFrage()" id="back" value="<<"/>
    <input type="submit" id="end_button" class="button" value="Quiz beenden"/>

    </form>
  </main>
  <footer>
    <p>© Sabino, Schreckenast</p> <br>
  </footer>

<style type="text/css">
  .Frage{
    width:50%;
    height:50%;
    top:50%;
    left:50%;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    position: absolute;
    transform: translate(-50%,-50%);
    display:none;
    color:var(--tc);
    text-align: center;
  }
  #erfahrungsgrad{
    display:block;
  }
  .Antworten{
    text-align:left;
    padding:10%;
    position:absolute;
    top: 20%;
    height:80%;
    font-size: large;
  }
  .AntwortenMitBild{
    position:absolute;
    top:10%;
    height:80%;
    grid-template-columns: repeat(2, 1fr);
    left: 10%;
    width: 80%;
    display: none;
  }
  #All_Desktop_Antwort{
    grid-template-columns: repeat(3, 1fr);
  }
  #Desktop{
    top: 12%;
    height: 75%;
    left:22%;
    width: 56%;
    transform: translate(0%,0%);
  }
  .Desktop_Option{
    position: relative;
    top:0%;
    width: 100%;
    align-items: center;
  }
  img{
    width:90%;
  }
  /*img:hover{
    transform: translate(-50%,-50%);
    position:absolute;
    top:50%;
    left:50%;
    width:150%;
  }*/
  .h3{
    padding:10%;
    font-size:larger;
  }
  .button{
    position: absolute;
    top: 50%;
    transform: translate(0%, -50%);
    display: block;
    width: 5%;
    height:2.5%;
    animation: changecolor 50s infinite;
    border:2px solid var(--tc);
  }
  #next{
    left:85%;
  }
  #back{
    left:15%;
    visibility: hidden;
  }
  #end_button{
    left:85%;
    top:70%;
  }
</style>
<script type="text/javascript">

    var frage = document.getElementsByClassName('Frage')
    var vor = document.getElementById('next');
    var zurueck = document.getElementById('back');
    var cur = 0
    var anzFragen = 7;
    function naechsteFrage(a, b){
      if(frage[cur].id == "erfahrungsgrad")
        removeOrAddAdvancesQuestions();
      
      frage[cur].style.display = 'none'
      cur = cur +1
      frage[cur].style.display = 'block'
      if(frage[cur].id == "Desktop"){
        WinOderMac()
      }
      
      
      zurueck.style.visibility = 'visible'
      if(cur > anzFragen)
        vor.style.visibility = 'hidden'
    }
    function vorherigeFrage(){
      frage[cur].style.display = 'none'
      cur = cur -1
      frage[cur].style.display = 'block';
      if(frage[cur].id == "Desktop"){
        WinOderMac()
      }

      if(frage[cur].id == "erfahrungsgrad")
        removeOrAddAdvancesQuestions()
      
      vor.style.visibility = 'visible'
      if(cur == 0)
        zurueck.style.visibility = 'hidden'
    }
    function WinOderMac() {    
      var getSelectedValue = document.querySelector('input[name="winmac"]:checked')
      var mac_desktop = document.getElementById('Mac_Desktop_Antwort')
      var win_desktop = document.getElementById('Win_Desktop_Antwort')
      var all_desktop = document.getElementById('All_Desktop_Antwort')
      if(getSelectedValue != null) {  
        all_desktop.style.display = 'none'
        var winmac = getSelectedValue.value
        if(winmac == "true"){
          mac_desktop.style.display = 'none'
          win_desktop.style.display = 'grid'
        }else{
          mac_desktop.style.display = 'grid'
          win_desktop.style.display = 'none'
        }
      }   
      else {
        all_desktop.style.display = 'grid'
        mac_desktop.style.display = 'none'
        win_desktop.style.display = 'none'
      }   
    }  
    function removeOrAddAdvancesQuestions(){
      var getSelectedValue = document.querySelector('input[name="erfahrungsgrad"]:checked');
      if(getSelectedValue != null) {
        if(getSelectedValue.value == "0"){
          anzFragen = 4
          console.log("Hi")
        }else{
          anzFragen = 7
        }
      }else{
        anzFragen = 7
      }
    }
</script>
</body>
</html>

