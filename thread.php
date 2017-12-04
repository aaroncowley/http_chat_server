<?php
require_once('init.php');

  /* make sure the person is logged in. */
  if(!isset($_SESSION['acow_UserID']))
    exit;

  $currtime = date("YmdHis",time());

  /* maintains this user's state as active. */
  mysqli_query("UPDATE acow_users SET LastUpdate = '" . $currtime . "'
                WHERE UserID = " . $_SESSION['acow_UserID']);

  /* grab any messages posted since the last time we checked.
  Notice we say >= and <. This is to guarantee that we don't miss any
  messages that are posted at the same instant this query is
  executed.*/
  $sql = "SELECT Message,UserName
          FROM acow_Messages
          INNER JOIN " . "acow_users
            ON acow_Messages.UserID = acow_users.UserID 
          WHERE Posted >= '" . $_SESSION['acow_Prevtime'] . "' 
            AND Posted < '" . $currtime . "'
          ORDER BY Posted";
  $res = mysqli_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
  <head></head>
  <body>
  <?php
    if(mysqli_num_rows($res)){
      echo '<div id="contents">';
      while($row = mysqli_fetch_array($res)){
        echo '<div><strong>' .
              htmlspecialchars($row['UserName']) . ': </strong>' .
              htmlspecialchars($row['Message']) . '</div>';
      }
      echo '</div>';
    }
    $_SESSION['acow_Prevtime'] = $currtime;
  ?>
<script type="text/javascript"><!--
  if(parent.insertMessages && document.getElementById("contents"))
    parent.insertMessages(document.getElementById("contents").innerHTML);

  setTimeout("getMessages()",1000); //poll server again in one second
  function getMessages(){
    document.location.reload();
  }
  //-->
</script>
  </body>
</html>
