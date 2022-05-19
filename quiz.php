<?php
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
// define variables and set to empty values
$erfahrung = $hardware = $anpassung = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $erfahrung = test_input($_POST["erfahrung"]);
  $hardware = test_input($_POST["hardware"]);
  $anpassung = test_input($_POST["anpassung"]);
}

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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="Frage" id="Erfahrung">    
      <h3>Wie viel Erfahrung haben Sie im Umgang mit Computern?</h3>
      <div class="Antworten">
        <input type="radio" name="erfahrung" value="0">
        <label>Ich brauche Hilfe bei den vielen Problemen</label><br>
        <input type="radio" name="erfahrung" value="1">
        <label>Ich kann kleinere Schwierigkeiten selbst bewältigen</label><br>
        <input type="radio" name="erfahrung" value="2">
        <label>Ich komme mit Problemen gut klar</label><br>
      </div>
    </div>

    <div class="Frage" id="Hardware">
        <h3>Auf welcher Hardware soll das Linux ausgeführt werden</h3>
      <div class="Antworten">
        <input type="radio" name="hardware" value="0">
        <label>Sehr alte Hardware mit 32 bit (Das ist bei Hardware, die jünger wie 5 Jahre ist, meist nicht der Fall)</label><br>
        <input type="radio" name="hardware" value="1">
        <label>Schwache Hardware</label><br>
        <input type="radio" name="hardware" value="2">
        <label>System mit den neusten technischen Spielereien</label><br>
      </div>
    </div>
    <div class="Frage" id="Anpassbarkeit">    
        <h3>Ist Ihnen eine hohe Konfigurierbarkeit bei Start wichtig?</h3>
      <div class="Antworten">
        <input type="radio" name="anpassung" value="0">
        <label>Ja, ich möchte sehr viel beim ersten Startvorgang einstellen</label><br>
        <input type="radio" name="anpassung" value="1">
        <label>Nein, ich möchte mich auf Voreinstellungen verlassen</label><br>
      </div>
    </div>
      

<input type="button" class="button" onclick="naechsteFrage()" id="next" value=">>"/>
<input type="button" class="button" onclick="vorherigeFrage()" id="back" value="<<"/>
<input type="submit" id="end_button" class="button" value="Quiz beenden"/>

    </form>
    </main>
    <footer>
        <p>© Sabino, Schreckenast</p> <br>
        
<?php
echo "<p>";
echo $_SESSION['name'];
echo "s Input:";
echo $erfahrung;
echo $hardware;
echo $anpassung;
echo "</p>"
?>
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
#Erfahrung{
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
  border:2px solid black;
}
#next{
  left:85%;
}
#back{
  left:15%;
  display:none;
}
#end_button{
  left:85%;
  top:70%;
}
</style>
<script type="text/javascript">

    /*function naechsteFrage(nextId, curId){
        let curForm = document.getElementById(curId);
        let nextForm = document.getElementById(nextId);
        curForm.style.display = 'none';
        nextForm.style.display = 'block';
        console.log(curForm);
        console.log(nextForm);
    }*/

    var frage = document.getElementsByClassName('Frage')
    var vor = document.getElementById('next');
    var zurueck = document.getElementById('back');
    var cur = 0
   
      
    function naechsteFrage(a, b){
      frage[cur].style.display = 'none'
      cur = cur +1
      frage[cur].style.display = 'block'
      
      zurueck.style.display = 'block'
      if(cur > 9)
        vor.style.display = 'none'
    }
    function vorherigeFrage(){
      frage[cur].style.display = 'none'
      cur = cur -1
      frage[cur].style.display = 'block'
      
      vor.style.display = 'block'
      if(cur == 0)
        zurueck.style.display = 'none'
    }
</script>
</body>
</html>
