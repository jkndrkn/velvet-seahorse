<?php
require_once("../php/check_login.php");
require_once("../php/gallery_item.php");

$catId = $_POST['catId'];
$title = $_POST['title'];
$price = $_POST['price'];
$numimages = $_POST['numimages'];
$description = $_POST['description'];
$images = $_POST['images'];
$mode = $_POST['mode'];
$itemId = $_POST['itemId'];

echo "<b>CATID</b> $catId<br />\n";
echo "<b>TITLE</b> $title<br />\n";
echo "<b>PRICE:</b> $price<br />\n";
echo "<b>MAX IMAGES:</b> $numimages <br />\n";
echo "<b>DESCRIPTION:</b> $description<br />\n";
echo "<b>IMAGES:</b>  <br />\n";

echo "<pre>";
$images = unserialize(base64_decode($images));
echo "</pre>";

$item = new gallery_item($catId, $title, $price, $numimages, $images, $description);
$updateItem = ($mode == 'edit') ? TRUE : FALSE;
if ($mode == 'edit') {
  $item->itemId = $itemId;
  $item->validate($updateItem);
  $item->insert($updateItem);
}
else {
$item->validate();
$item->insert();
}
?>

<?php 
if ($mode == 'edit'):
?>
<p>
<input class="button" type="button" value="Return to Browse Items" onclick="location.href = 'admin.php?p=item_browse'">
</form>
</p>
<?php
else:
?>
<p>
<input class="button" type="button" value="Add another Item" onclick="location.href = 'admin.php?p=item_form'">
</form>
</p>
<p>
<input class="button" type="button" value="Return to Admin Main" onclick="location.href = 'admin.php?p=admin'">
</form>
</p>
<?php
endif;
?>
