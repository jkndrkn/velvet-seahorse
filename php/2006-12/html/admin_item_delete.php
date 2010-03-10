<br />
<?php
require_once("../php/check_login.php");
require_once("../php/db_wrapper.php");

$db_wrapper = new db_wrapper();
$db_wrapper->connect();
$db_wrapper->select_db();
$itemId = $_GET['itemId'];
$do_delete = $_GET['do_delete'];

if(!isset($do_delete)) {
  echo "Are you sure you want to delete this item?";
?>

<p>
<form>
<input class="button" type="button" onclick="history.back()" value="No - Go back">
</form>
</p>

<p>
<input class="button" type="button" value="Yes - Delete item"
  onclick="location.href = 'admin.php?p=item_delete&itemId=<?=$itemId?>&do_delete=1'">
</form>
</p>

<?php
}
else {
  $catPathQuery = "
    select catName, itemThumb from items join categories where itemId = '$itemId' and items.catId = categories.catId
    order by items.catId, itemDateAdded desc
    ";

  $catPathResult = $db_wrapper->do_query($catPathQuery);
  $catRow = mysql_fetch_array($catPathResult);
  $catPath = $catRow['catName'];
  $thumbPath = $catRow['itemThumb'];

  $fileNameQuery = "select imageUrl from itemimage where itemId = '$itemId'";
  $imageUrls = $db_wrapper->do_query($fileNameQuery);
  while ($imageRow = mysql_fetch_assoc($imageUrls)) {
    $imageUrl = $imageRow["imageUrl"];
    $imagePath = "../img/shop/{$imageUrl}";
    
    if(!unlink($imagePath)) 
      echo "<b>Failed to delete image:</b> " . $imagePath . "<br /><br />\n";
    else
      echo "<b>Image deleted!</b> " . $imagePath . "<br /><br />\n";
  }

  $thumbPath = "../img/shop/{$thumbPath}";
  if(!unlink($thumbPath)) 
    echo "<b>Failed to delete thumb:</b> " . $thumbPath . "<br /><br />\n";
  else
    echo "<b>Thumb deleted!</b> " . $thumbPath . "<br /><br />\n";

  $itemQuery = "delete from items where itemId = '$itemId'";
  $db_wrapper->do_query($itemQuery);

  $imageQuery = "delete from itemimage where itemId = '$itemId'";
  $db_wrapper->do_query($imageQuery);

?>
<br />
Item deleted.

<p>
<form>
<input class="button" type="button" value="Return to Item Browse"
  onclick="location.href = 'admin.php?p=item_browse'">
</form>
</p>
<?php
}
?>
