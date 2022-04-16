<?php

$images = array_diff(scandir("images"), array(".", ".."));

if(sizeof($images) == 0){

echo "<fieldset style=width:500;>";
echo "<legend><b>No images found</b></legend>";
if(isset($_SESSION['admin'])){
  echo "<div align=center><h3><b><a href=".$_SERVER['PHP_SELF']."?action=updel>Upload</a> some pictures.</b></h3></div>";
}else{
  echo "<div align=center><h3>You can upload some images after <b><a href=".$_SERVER['PHP_SELF']."?action=login>logging in</a></b>.</h3></div>";
}
echo "</fieldset>";

}else{

?>

<table width=1000 cellpadding=10 cellspacing=10 align=center>

<?php

foreach($images as $pic){

$data = mysql_query("SELECT * FROM picdata WHERE pic LIKE '".$pic."'", $conx);
$data = mysql_fetch_array($data);

?>

<tr>
<td align=center valign=top width=40%>
<fieldset>
<br>
<a href=<?php echo "images/".$pic; ?>><img src=images/<?php echo $pic; ?> border=1></a><br>
<br>
<b>Uploaded by: <?php echo $data['uploader']; ?></b><br>
</fieldset>
</td>
<td valign=top width=60%>
<fieldset>
<legend><b>Comments</b></legend>
<br>
<?php echo $data['comments']; ?>
<br>
</fieldset>
<table width=100% cellpadding=2 cellspacing=2 align=center>
<tr><td width=50% align=left>
<a href=<?php echo $_SERVER['PHP_SELF']."?action=comment&pic_id=".$data['ID']; ?>><b>Comment on this picture</b></a>
</td>
<?php
if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){
  ?>
  <td width=50% align=right><a href=<?php echo $_SERVER['PHP_SELF']."?action=comment&del_id=".$data['ID']; ?>><b>Delete these comments</b></a></td>
  <?php
}
?>
</tr>
</table>
</td>
</tr>
<?php

}

}

?>

</table>