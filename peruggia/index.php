<?php

session_start();

include("conf.php");
include("includes/mysql.php");

?>

<html>
<head>
<title><?php echo $title." ".$version; ?></title>
</html>
<link rel=stylesheet type=text/css href=style.css>
</head>
<body>
<div align=center>
<!--<fieldset class=body_container id=body_container>-->
<table cellspacing=5 cellpadding=5>
<tr>
<td>
<img src=logo.png height=150 width=90 border=0>
</td>
<td>
<hr>
<h1><?php echo $title." ".$version; ?></h1><br>
<h2>By Andrew Kramer</h2>
<hr>
</td>
</tr>
</table>
<hr width=1000 size=5>

<?php

if(isset($_SESSION['admin']) && (isset($_SESSION['admin']) && ($_SESSION['admin']==1))){
  echo "<h3>Welcome ";
  if($guard_pers_xss){
    echo htmlentities($_SESSION['username']);
  }else{
    echo $_SESSION['username'];
  }
  echo " | <a href=".$_SERVER['PHP_SELF']."?action=account>Account</a> | <a href=".$_SERVER['PHP_SELF']."?action=updel>Upload/Delete</a> | <a href=".$_SERVER['PHP_SELF']."?action=logout>Logout</a> | <a href=".$_SERVER['PHP_SELF'].">Home</a> | <a href=".$_SERVER['PHP_SELF']."?action=license>About</a> | <a href=".$_SERVER['PHP_SELF']."?action=learn>Learn</a></h3>";
}else{
  echo "<h3>Welcome Guest | <a href=".$_SERVER['PHP_SELF']."?action=login>Login</a> | <a href=".$_SERVER['PHP_SELF'].">Home</a> | <a href=".$_SERVER['PHP_SELF']."?action=license>About</a> | <a href=".$_SERVER['PHP_SELF']."?action=learn>Learn</a></h3>";
}

?>

<hr width=1000 size=5>
<br>

<?php
if(isset($_GET['action'])){
switch($_GET['action']){
  case("updel"):
    if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){
	  include("includes/updel.php");
    }else{
      header("Location: ".$_SERVER['PHP_SELF']);
    }
  break;
  case("login"):
	include("includes/login.php");
  break;
  case("license"):
	include("about.html");
  break; 
  case("learn"):
	include("includes/learn.php");
  break; 
  case("comment"):
    include("includes/comment.php");
  break;
  case("account"):
    if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){
      include("includes/account.php");
    }else{
      header("Location: ".$_SERVER['PHP_SELF']);
    }
  break;
  case("logout"):
    if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){
      session_destroy();
      header("Location: ".$_SERVER['PHP_SELF']);
    }else{
      header("Location: ".$_SERVER['PHP_SELF']);
    }
  break;
  default:
    if($guard_lfi){
	  header("Location: ".$_SERVER['PHP_SELF']);
	}else{
      include("includes/".$_GET['action'].".php");
	}
}
}else{
include("includes/main.php");
}

?>

<br>
<hr width=1000 size=5>
<div align=center>
<b>Peruggia <?php echo $version; ?><b> <a href=https://sourceforge.net/projects/peruggia/>https://sourceforge.net/projects/peruggia/</a><br>
<b>Developed by Andrew Kramer<b>
<!--</fieldset>-->
</div>
</body>
</html>