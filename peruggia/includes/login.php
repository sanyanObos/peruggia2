<?php

if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){

  echo "<div align=center><h5>You are already logged in</h5></div>";

}elseif(isset($_GET['check']) && ($_GET['check']==1)){
  if($guard_auth_sqli){
    $creds = mysql_query("SELECT * FROM users WHERE username='".mysql_real_escape_string($_POST['username'])."' AND password='".md5($_POST['password'])."'", $conx);
  }else{
    $creds = mysql_query("SELECT * FROM users WHERE username='".$_POST['username']."' AND password='".md5($_POST['password'])."'", $conx);
  }
  $creds = mysql_fetch_array($creds);
  if($creds){
    if($guard_pers_xss){
      $_SESSION['username'] = htmlentities($creds['username']);
    }else{
      $_SESSION['username'] = $creds['username'];
    }
    $_SESSION['password'] = $creds['password'];
    $_SESSION['admin'] = 1;
    header("Location: ".$_SERVER['PHP_SELF']);
  }else{
    header("Location: ".$_SERVER['PHP_SELF']."?action=login");
  }

}else{

  ?>

  <div align=center>
  <fieldset style=width:300;>
  <legend><b>Login</b></legend>
  <form action=<?php echo $_SERVER['PHP_SELF']."?action=login&check=1"; ?> method=post>
  <br>
  Username: <input type=text name=username><br>
  Password: <input type=password name=password><br>
  <br><input type=submit value=Login><br>
  </form>
  </fieldset>
  </div>

  <?php

}

?>