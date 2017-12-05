<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
    $command = explode(" ",$_POST['text']);

    $contents;
    $dir = 'images/';
    if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
          $contents .=  $file.", ";
      }
    }
     
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    if ($command[0] == "/get"){
        if (sizeof($command) != 2){
            fwrite($fp, "<div class='help'>your available files to /get are: ".$contents."</div>");
        }else{
            fwrite($fp, "<div class='image'> <img src='images/".$command[1]."' alt='maymay'></div>"); 
        }
    }    
    fclose($fp);
}
?>
