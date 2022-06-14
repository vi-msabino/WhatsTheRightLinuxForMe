<!DOCTYPE html>
<html lang="de">
<head> 
    <meta charset="utf-8">
    <meta name="Was ist die beste Linux Distribution für mich?">
    <title>Distro-Chooser</title>
    <link rel="stylesheet" href="general.css">
    <script type="text/javascript" src="general.js"></script>
</head>
<body class="COLOR">
    <header> 
        <h1 id="header">Was ist die beste Linux Distribution für mich?</h1> 
        <button id="dark" onclick="onClick('button')"><img src="Bilder/dark-white.png" type="img/png" title="Umstellen auf Dark/White-Mode" height="30px"></img></button>
    </header>
    <form method="GET" action="quiz.php">
        <label id="text">Trage hier deinen Namen ein : </label><br>
        <input type="text" name="vorname" id="textInput" placeholder="Name eingeben"/>
	    <nav id="enter">Enter drücken um den Namen einzugeben!</nav>
        <input type="image" src="Bilder/Tux.svg.png" id="bild"/><br>
        <p id="bild1">Zum Starten auf das Bild von Tux klicken</p>
    </form>
    <footer>
        <p>© Sabino, Schreckenast</p>
    </footer>
    <style type="text/css">
        form{
            position:absolute;
            left: 50%;
            top: 10%;
            height: 80%;
            width: 100%;
            text-align: center;
            transform: translate(-50%, 0%);
        }
        #bild1{
            top:60%;
            left:50%;
            position: absolute;
            transform: translate(-50%,-50%);
        }
        #bild{
            top: 40%;
            left:50%;
            width: 10%;
            position: absolute;
            transform: translate(-50%,-50%);
        }
        #text{
            position:relative;
            top:6%;
        }
        #textInput{
            top:8%;
            position: relative;
        }
        #enter{
            top:10%;
            position:relative;
        }
    </style>
</body>
</html>