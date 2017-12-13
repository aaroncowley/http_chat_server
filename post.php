<?php
session_start();
if(isset($_SESSION['name']) && $_SESSION['room']){
    $text = $_POST['text'];
    $command = explode(" ",$_POST['text']);

    $contents;
    $dir = 'images/';
    if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
          $contents .=  $file.", ";
      }
    }
    if ($_SESSION['room'] == '1'){ 
        $fp = fopen("log.html", 'a');
    }
    else if($_SESSION['room'] == '2'){
        $fp = fopen("log2.html", 'a');
    }
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    if ($command[0] == "/get"){
        if (sizeof($command) != 2){
            fwrite($fp, "<div class='help'>your available files to /get are: ".$contents." and your text file is text.txt</div>");
        }else if($command[1] != 'text.txt'){
            fwrite($fp, "<div class='image'> <img src='images/".$command[1]."' alt='maymay'></div>"); 
        }else{
	    $output = "";
            $fh = fopen('text.txt','r');
            while ($line = fgets($fh)) {
                $output .= $line;
            }
            fclose($fh);
            fwrite($fp, "<div class='text'>".$output."</div>");
	}
    }    
    fclose($fp);
}
?>
