<?php

if(isset($_GET['del_id'])){

  if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){
    if($guard_sqli){
	  mysql_query("UPDATE picdata SET comments = '' WHERE ID LIKE ".(int)$_GET['del_id'], $conx);
	}else{
      mysql_query("UPDATE picdata SET comments = '' WHERE ID LIKE ".$_GET['del_id'], $conx);
	}
    header("Location: ".$_SERVER['PHP_SELF']);
  }else{
    header("Location: ".$_SERVER['PHP_SELF']);
  }

}

if(isset($_GET['postcomment'])){

  if($guard_pers_xss){
    $comment = htmlentities($_POST['comment'])."<br><br>";
  }else{
    $comment = $_POST['comment']."<br><br>";
  }
  if($guard_sqli){
    $comment = mysql_real_escape_string($comment);
  }
  if($guard_sqli){
    $crntquery = mysql_query("SELECT comments FROM picdata WHERE ID LIKE ".(int)$_GET['pic_id'], $conx);
  }else{
    $crntquery = mysql_query("SELECT comments FROM picdata WHERE ID LIKE ".$_GET['pic_id'], $conx);
  }
  $crntcomm = mysql_fetch_array($crntquery);
  $save = $crntcomm['comments'].$comment;
  if($guard_sqli){
    mysql_query("UPDATE picdata SET comments = '".$save."' WHERE ID LIKE ".(int)$_GET['pic_id'], $conx);
  }else{
    mysql_query("UPDATE picdata SET comments = '".$save."' WHERE ID LIKE ".$_GET['pic_id'], $conx);
  }
  header("Location: ".$_SERVER['PHP_SELF']);
  
}else{

?>

<div align=center>
<fieldset style=width:300;>
<legend><b>Add Comment</b></legend>
<br>
<?php

if($guard_sqli){
  $picquery = mysql_query("SELECT pic FROM picdata WHERE ID = ".(int)$_GET['pic_id'], $conx);
}else{
  $picquery = mysql_query("SELECT pic FROM picdata WHERE ID = ".$_GET['pic_id'], $conx);
}
$data = mysql_fetch_array($picquery);

echo "<img src=images/".$data['pic']." border=1><br>";

?>
<br>
<form action=<?php 
if($guard_refl_xss){
  echo $_SERVER['PHP_SELF']."?action=comment&pic_id=".htmlentities($_GET['pic_id'])."&postcomment=1";
}else{
  echo $_SERVER['PHP_SELF']."?action=comment&pic_id=".$_GET['pic_id']."&postcomment=1";
}
?> method=POST>
<textarea name=comment cols=50 rows=10>
</textarea><br>
<br>
<input type=submit value=Post>
</fieldset>
</div>

<?php

}

?>