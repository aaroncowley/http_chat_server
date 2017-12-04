<?php
ini_set('display_errors',1); error_reporting(E_ALL);
  session_start();
  if(!$_SESSION['acow_UserID']){
    header("Location: ./login.php");
    exit;
  }
  else if(date("YmdHis",time() - 5) > $_SESSION['acow_Prevtime']){
    header("Location: ./login.php?logout=true");
    exit;
  }
?>


<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
  <head>
    <title>acow chat</title>
    <style type="text/css">
      #chatContents{height:300px; width:200px;}
    </style>
<script type="text/javascript"><!--
  var cDocument;
  var cWindow;

  window.onload = chat_init;

  function chat_init(){
    var chatContents = document.getElementById("chatContents");

    //set up a reference to the window object of the IFRAME
    if(window.frames && window.frames["chatContents"]) //IE5, Konq, Safari
      cWindow = window.frames["chatContents"];
    else if(chatContents.contentWindow) //IE5.5+, Moz 1.0+, Opera
      cWindow = chatContents.contentWindow;
    else //Moz < 0.9 (Netscape 6.0)
      cWindow = chatContents;

    //set up a reference to the document object of the IFRAME
    if(cWindow.document) //Moz 0.9+, Konq, Safari, IE, Opera
      cDocument = cWindow.document;
    else //Moz < 0.9 (Netscape 6.0)
      cDocument = cWindow.contentDocument;
  }
  function insertMessages(content){
    //place the new messages in a div
    var newDiv = cDocument.createElement("DIV");
    newDiv.innerHTML = content;

    //append the messages to the contents
    cDocument.getElementById("contents").appendChild(newDiv);

    //scroll the chatContents area to the bottom
    cWindow.scrollTo(0,cDocument.getElementById("contents").offsetHeight);
  }
  function resetForm(){
    document.getElementById("message").value = "";
    document.getElementById("message").focus();
  }//-->
</script>

  </head>
  <body>
    <h1>acow chat</h1>

    <a href="login.php?logout=true">Logout</a><br />

    <iframe id="chatContents" name="chatContents" src="contents.html"></iframe>

    <form target="post" method="post" action="post.php">
      <input type="text" name="message" id="message" style="width: 250px" />
      <input type="submit" value="Send" class="submit" />
    </form>

    <iframe id="post" name="post" src="post.php"
      style="width: 0px; height: 0px; border: 0px;"></iframe>
    <iframe id="thread" name="thread" src="thread.php"
      style="width: 0px; height: 0px; border: 0px;"></iframe>
  </body>
</html>
