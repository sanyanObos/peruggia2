<?php

if(!isset($_SESSION['admin'])){
  header("Location: ".$_SERVER['PHP_SELF']);
}

if(isset($_GET['pic_id'])){
  if($guard_sqli){
    $filequery = mysql_query("SELECT pic FROM picdata WHERE ID LIKE ".(int)$_GET['pic_id'], $conx);
  }else{
    $filequery = mysql_query("SELECT pic FROM picdata WHERE ID LIKE ".$_GET['pic_id'], $conx);
  }
  $delfile = mysql_fetch_array($filequery);
  unlink("images/".$delfile['pic']);
  mysql_query("DELETE FROM picdata WHERE pic LIKE '".$delfile['pic']."'", $conx);
  echo "<div align=center><h5>Picture Deleted</h5></div><br>";
}

if(isset($_GET['upload'])){
  if($guard_sqli){
    $path = "images/".mysql_real_escape_string(basename($_FILES['upfile']['name']));
    $uploader = mysql_real_escape_string($_SESSION['username']);
  }else{
    $path = "images/".basename($_FILES['upfile']['name']);
    $uploader = $_SESSION['username'];
  }
  if($guard_fuv){
    if(!eregi('image/', $_FILES['upfile']['type'])) {
      exit("<div align=center><h5>File is not a valid image</h5></div>");
	}
  }
  if($guard_pers_xss){
    $path = htmlentities($path);
  }
  move_uploaded_file($_FILES['upfile']['tmp_name'], $path);
  mysql_query("INSERT INTO picdata (pic,uploader) VALUES ('".$_FILES['upfile']['name']."', '".$uploader."')", $conx);
  if($guard_pers_xss){
    echo "<div align=center><h5>Picture \"".htmlentities(basename($_FILES['upfile']['name']))."\" Uploaded</h5></div><br>";
  }else{
    echo "<div align=center><h5>Picture \"".basename($_FILES['upfile']['name'])."\" Uploaded</h5></div><br>";
  }
}

$images = array_diff(scandir("images"), array(".", ".."));

?>

<div align=center>
<table width=1000 cellpadding=10 cellspacing=10 align=center>
<tr>
<td valign=top align=right>
<fieldset style=width:300;>
<legend><b>Upload</b></legend>
<form enctype=multipart/form-data action=<?php echo $_SERVER['PHP_SELF']."?action=updel&upload=1"; ?> method=POST>
Choose a file to upload:<br>
<br>
<input name=upfile type=file><br>
<br>
<input type=submit value=Upload>
</form>
</fieldset>
</td>
<td valign=top align=left>
<fieldset style=width:300;>
<legend><b>Delete</b></legend>
<?php
foreach($images as $pic){
$delquery = mysql_query("SELECT ID FROM picdata WHERE pic LIKE '".$pic."'", $conx);
$data = mysql_fetch_array($delquery);
?>
<a href=<?php echo "images/".$pic; ?>><img src="images/<?php echo $pic; ?>" border=1></a><br>
<a href=<?php echo $_SERVER['PHP_SELF']."?action=updel&pic_id=".$data['ID']; ?>><b>Delete this picture</b></a>
<br><br>
<?php
}
?>
</fieldset>
</td>
</tr>
</table>
</div>
