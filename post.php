<?php
  require_once('init.php');

  /* make sure the person is logged in. */
  if(!isset($_SESSION['UserID']))
    exit;
  
  /* make sure something was actually posted. */
  if(sizeof($_POST)){
    $expiretime = date("YmdHis",time() - 30);

    /* delete expired messages. */
    mysqli_query($dbhandle,"DELETE FROM acow_Messages 
                 WHERE Posted <= '" . $expiretime . "'"); 
    /* delete inactive participants. */
    mysqli_query($dbhandle,"DELETE FROM acow_users 
                 WHERE LastUpdate <= '" . $expiretime. "'"); 
    /* post the message. */
    mysqli_query($dbhandle,"INSERT INTO acow_Messages (UserID,Posted,Message)
                 VALUES(
                  " . $_SESSION['acow_UserID'] . ",
                  '" . date("YmdHis", time()) . "',
                  '" . mysqli_real_escape_string(strip_tags($_POST['message'])) . "'
                 )");
  
    header("Location: post.php");
    exit;
  }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
  <head>
    <script type="text/javascript"><!--
      if(parent.resetForm)
        parent.resetForm();
      //-->
    </script>
  </head>
</html>
