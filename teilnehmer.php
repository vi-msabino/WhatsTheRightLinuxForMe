
    <?php
    $fp =fopen('teilnehmer.txt','a+');
        if(!$fp)
        die("<h3 class='error'>Fehler: kann Datei nicht schreiben</h3>");
        
        $tn = array();

        while(!feof($fp))
            $tn[]=unserialize(fgets($fp));
            if(is_array($array))
            $tn[]=$array;


        if(!empty($_GET)){
            fputs($fp, serialize($_GET). "\n");
            $tn[]=$_GET;
        }

        if(!empty($tn)){
        echo "<select>\n";
        foreach($tn as $index => $value){
            echo "<option>",$value['vorname'],"</option>\n";
        }
        echo "<select>\n";
        }
        
        fclose($fp);
    ?>