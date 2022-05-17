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
    <header> 
        <h1 id="header">What is the best Linux Distribution for me?</h1> 
        <button id="dark" onclick="onClick('button')"><img src="dark-white.png" type="img/png" title="Umstellen auf Dark/White-Mode" height="30px"></img></button>
    </header>
<?php 
      $hardware = $_POST["hardware"];
      $design = $_POST["design"];
      $secureboot = $_POST["secureboot"];
      echo $vorname;
?>

<form class="Frage" id="Erfahrung" method="post" action="<?php $erfahrung = $_POST["erfahrung"]; ?>">
      <h3>Frage zu Erfahrung</h3>
      <div class="Antworten">
      <input type="radio" name="erfahrung" value="0">
      <label>anfänger</label><br>
      <input type="radio" name="erfahrung" value="1">
      <label>fortgeschritten</label><br>
      <input type="radio" name="erfahrung" value="2">
      <label>profi</label><br>
      </div>
      <input type="submit" value="Submit" class="next">
</form>
<form class="Frage" id="Hardwareanforderungen" method="post">
      <h3>Frage zu Hardware</h3>
      <input type="radio" name="hardware" value="0">
      <label>Uralt PCs</label><br>
      <input type="radio" name="hardware" value="1">
      <label>fortgeschritten</label><br>
      <input type="radio" name="hardware" value="2">
      <label>profi</label><br>
      <input type="submit" value="Submit" class="next">
</form>
<form class="Frage" id="Desktop-Design" method="post">
      <h3>Frage zu Design</h3>
      <input type="radio" name="design" value="0">
      <label>Windows</label><br>
      <input type="radio" name="design" value="1">
      <label>Mac</label><br>
      <input type="submit" value="Submit" class="next">
</form>
<form class="Frage" id="Secure Boot" method="post">
      <h3>Frage zu Secure Boot</h3>
      <input type="radio" name="secureboot" value="0">
      <label>Will ich</label><br>
      <input type="radio" name="secureboot" value="1">
      <label>Will ich nicht</label><br>
      
      <input type="submit" value="Submit" class="next">
</form>
<form class="Frage" id="Aktualitaet" method="post" action="<?php $aktuell = $_POST["update"]; ?>">
      <h3>Frage zu Erfahrung</h3>
      <input type="radio" name="update" value="0">
      <label>a</label><br>
      <input type="radio" name="update" value="1">
      <label>fortgeschritten</label><br>
      <input type="radio" name="update" value="2">
      <label>profi</label><br>
      <input type="submit" value="Submit" class="next">
</form>

<?php
      //$con = mysqli_connect('localhost', 'root', '985237985237','Whatsthrrightlinuxforme');

?>
<footer>
        <p>© Sabino, Schreckenast</p>
    </footer>
    
</body>
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
    border:1p solid green;
}
.h3{
    padding:10%;
    font-size:larger;
}
.input{
    padding: 50px;
}
.label{
    padding:50px:
}
</style>
<script type="text/javascript">
    let fragen = document.getElementsByTagName('form');
    let fragen_button = document.getElementsByClassName('next');
    /*fragen.forEach((item) => {
        let fragen_button = fragen.getElementsByClassName("next")
        fragen_button.addEventListener('click', () => {
            item.style.display='none'
            console.log("ich mache was")
        })
    })*/
    for (var i = 0; i < fragen.length-1; i++) {
        console.log(fragen[i].id)
        fragen_button[i].addEventListener('click', () => {
            fragen[i].style.display='none';
            var j = i+1;
            console.log(j)
            fragen[j].style.display = 'block';
            console.log("ich mache was")
        })
    }

</script>
</html>