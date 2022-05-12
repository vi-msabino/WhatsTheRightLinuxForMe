<!DOCTYPE html>
<html lang="de">
<head> 
    <meta charset="utf-8">
    <meta name="What is the best Linux Distribution for me?">
    <title>Welcome to our Distro-Chooser</title>
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="general.js"></script>
    <script type="text/ptp" src="teilnehmer.php"></script>
</head>

<body class="COLOR">
    <header> 
        <h1 id="header">What is the best Linux Distribution for me?</h1> 
        <button id="dark" onclick="onClick('button')"><img src="dark-white.png" type="img/png" title="Umstellen auf Dark/White-Mode" height="30px"></img></button>
    </header>
    <?php 
        include("teilnehmer.php");
    ?>
<form id="vn" name ="vona" method="post">
    <main >
        <p id="eingabe"><label>Trage hier deinen Namen ein : </label><br><input id="input" type="text" name="vorname"/></p>
	  <nav id="enter">Enter drücken um den Namen einzugeben!</nav>
        <div><a href="quiz.html" class="COLOR"><img id="tux" src="Tux.svg.png" type="img/png" width="300"><br><p id="bild1">Zum Starten auf das Bild von Tux klicken</p></a></div>

    </main>
</form>
    <footer>
        <p>© Sabino, Schreckenast</p>
    </footer>
    </body>

</html>