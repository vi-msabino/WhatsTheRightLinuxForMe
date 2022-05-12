<?php
    $vorname = '';    
    $myFile = "teilnehmer.txt";
    if(isset($_POST['vorname']) && !empty($_POST['vorname'])) {
    $vorname = $_POST['vorname'].PHP_EOL;
    }
    if($vorname) {
    $fp = fopen($myFile, 'w+') or die("can't open file"); //Make sure you have permission
    fwrite($fp, $vorname);
    fclose($fp);
    }
/*
    $fp =fopen('teilnehmer.txt','a+');
        if(!$fp)
        die("<h3 class='error'>Fehler: kann Datei nicht schreiben</h3>");
        
        $tn = array();

        while(!feof($fp))
            $tn[]=unserialize(fPOSTs($fp));
            if(is_array($array))
            $tn[]=$array;


        if(!empty($_POST)){
            fputs($fp, serialize($_POST). "\n");
            $tn[]=$_POST;
        }

        if(!empty($tn)){
        echo "<select>\n";
        foreach($tn as $index => $value){
            echo "<option>",$value['vorname'],"</option>\n";
        }
        echo "<select>\n";
        }
        
        fclose($fp);*/
?>