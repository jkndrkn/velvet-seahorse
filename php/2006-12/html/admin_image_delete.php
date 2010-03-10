<br />
<?php
require_once("../php/check_login.php");
require_once("../php/db_wrapper.php");

$db_wrapper = new db_wrapper();
$db_wrapper->connect();
$db_wrapper->select_db();

$itemId = $_REQUEST['itemId'];
$imageUrl = $_REQUEST['imageUrl'];
$catPath = $_REQUEST['catPath'];
$submit = $_REQUEST['submit'];
$do_delete = $_GET['do_delete'];

if (($submit != 'delete') && ($do_delete != 1)):
?>
  <img src="../img/shop/<?=$imageUrl?>">
  <form action="admin.php?p=image_delete&itemId=<?=$itemId?>&imageUrl=<?=$imageUrl?>&catPath=<?=$catPath?>" method="post">
  <input class="button" type="submit" name="submit" value="delete">
  </form>
<?php
  elseif ($do_delete != 1):
?>
Are you sure?

<p>
<form>
<input class="button" type="button" onclick="history.back()" value="No - Go back">
</form>
</p>

<p>
<input class="button" type="button" value="Yes - Delete image"
  onclick="location.href = 'admin.php?p=image_delete&itemId=<?=$itemId?>&imageUrl=<?=$imageUrl?>&catPath=<?=$catPath?>&do_delete=1'">
</form>
</p>

<?php
else:
  $imagePath = "../img/shop/{$imageUrl}";
  
  if(!unlink($imagePath)) 
    echo "<b>Failed to delete image:</b> " . $imagePath . "<br /><br />\n";
  else
    echo "<b>Image deleted!</b> " . $imagePath . "<br /><br />\n";

  $imageQuery = "delete from itemimage where itemId = '$itemId' and imageUrl = '$imageUrl' limit 1";
  $db_wrapper->do_query($imageQuery);
  echo "Image deleted.";
?>

<p>
<input class="button" type="button" value="Return to Browse Items" onclick="location.href = 'admin.php?p=item_browse'">
</form>
</p>

<?php 
endif;
?>
