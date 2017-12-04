<?php
  require_once('init.php');
  
  if($_GET['logout']){ //they are logging out
      mysqli_query($dbhandle,"DELETE FROM acow_users WHERE UserID = " . $_SESSION['acow']);
      $_SESSION = array();
      if(isset($_COOKIE[session_name()])){
          setcookie(session_name(), '', 1, '/');
          unset($_COOKIE[session_name()]);
      }
      session_destroy(); // To delete the old session file
      header("Location: ./login.php");
      exit;
  }

    if(sizeof($_POST)){
        $expiretime = date("YmdHis", time() - 5);
        echo $expiretime;        
        //if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($_POST['who']){
                $result = mysqli_query($dbhandle,"SELECT UserID FROM acow_users WHERE UserName = '".mysqli_real_escape_string($dbhandle,$_POST['who'])."' AND LastUpdate > " . $expiretime);
                if(!mysqli_fetch_array($result)){
                mysqli_query($dbhandle,"DELETE FROM acow_users WHERE LastUpdate <= " .$expiretime);
                mysqli_query($dbhandle,"DELETE FROM acow_Messages WHERE Posted <= " . $expiretime);
                mysqli_query($dbhandle,"INSERT INTO acow_users (UserName,LastUpdate) VALUES ('".mysqli_real_escape_string($dbhandle,$_POST['who'])."'," . date("YmdHis",time()).")");
                $_SESSION['acow'] = mysqli_insert_id($dbhandle);
                $_SESSION['acow_Prevtime'] = date("YmdHis",time());
                header("Location: ./chat.php");
                exit;
                } else {
                    $error = "A user with the same handle is currently in the chat room. Please try a different handle.";
                }
            } else {
                $error = "Handles may only contain letters, numbers, hyphens and dashes.";
            }
       // } else {
         //   $error = "You must enter a handle (screen name) to enter the chat room.";
       // }
   }
?>
<!DOCTYPE html>
<?php $error ="hi";?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
  <head>
    <title>acow</title>
  </head>
  <body>
    <h1>acow chatroom</h1>
    <form method="post" action="login.php">
      Login<br>
      <label for="who">Handle: </label><input type="text" id="who" name="who">
      <input type="submit" value="Join Chat" class="submit" />
    </form>
    <div class="error">
      <?php echo $error; ?>
    </div>
  </body>
</html>
