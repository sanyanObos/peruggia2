<?php

if(!isset($_SESSION['admin'])){
  header("Location: ".$_SERVER['PHP_SELF']);
}

if(isset($_GET['changepass'])){

  if($_POST['newpass'] != $_POST['confnewpass']){
    header("Location: ".$_SERVER['PHP_SELF']."?action=account");
  }else{
    $oldpass = $_SESSION['password'];
    $newpass = md5($_POST['newpass']);
    mysql_query("UPDATE users SET password='".$newpass."' WHERE password='".$oldpass."'", $conx);
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
  }

}elseif(isset($_GET['adduser'])){

  if($guard_sqli){
    $newuser = mysql_real_escape_string($_POST['newuser']);
    $newuserpass = mysql_real_escape_string(Md5($_POST['newuserpass']));
  }else{
    $newuser = $_POST['newuser'];
    $newuserpass = md5($_POST['newuserpass']);
  }

  mysql_query("INSERT INTO users (username,password) VALUES ('".$newuser."','".$newuserpass."')", $conx);

  header("Location: ".$_SERVER['PHP_SELF']."?action=account");

}elseif(isset($_GET['deleteuser'])){

  if($_GET['deleteuser']==$_SESSION['username']){
    header("Location: ".$_SERVER['PHP_SELF']."?action=account");
  }else{
    if($guard_sqli){
      mysql_query("DELETE FROM users WHERE username='".mysql_real_escape_string($_GET['deleteuser'])."'", $conx);
    }else{
      mysql_query("DELETE FROM users WHERE username='".$_GET['deleteuser']."'", $conx);
    }
    header("Location: ".$_SERVER['PHP_SELF']."?action=account");
  }

}else{

  ?>

  <div align=center>
  <table width=1000 cellpadding=10 cellspacing=10>
  <tr>
  <td valign=top align=right>
  <fieldset style=width:300;>
  <legend><b>Change Password</b></legend>
  <form action=<?php echo $_SERVER['PHP_SELF']."?action=account&changepass=1"; ?> method=POST>
  New Password: <input type=password name=newpass><br>
  Confirm New Password: <input type=password name=confnewpass><br>
  <br><div align=center><input type=submit value=Change></div>
  </form>
  </fieldset>
  </td>
  <td valign=top align=left>
  <fieldset style=width:300;>
  <legend><b>Add User</b></legend>
  <form action=<?php echo $_SERVER['PHP_SELF']."?action=account&adduser=1"; ?> method=POST>
  New user's username: <input type=text name=newuser><br>
  New user's password: <input type=text name=newuserpass><br>
  <br><div align=center><input type=submit value=Add></div>
  </form>  
  </fieldset><br>
  <fieldset style=width:300;>
  <legend><b>Delete User</b></legend>
  <table cellpadding=2 cellspacing=2 width=100%>
  <?php

$users = mysql_query("SELECT username FROM users", $conx);

while($user = mysql_fetch_array($users)){

  echo "<tr>";
  echo "<td align=left class=box>";
  if($user['username']==$_SESSION['username']){
    echo "<b>".$user['username']."</b>";
  }else{
    echo $user['username'];
  }
  echo "</td>";
  echo "<td align=right class=box width=60>";
  if($user['username']==$_SESSION['username']){
    echo "<strike>[delete]</strike>&nbsp;";
  }else{
    echo "<a href=".$_SERVER['PHP_SELF']."?action=account&deleteuser=".$user['username'].">[delete]</a>&nbsp;";
  }  
  echo "</td>";
  echo "</tr>";

}

  ?>

  </table>
  </fieldset>
  </td>
  </tr>
  </table>

  <?php

}

?>