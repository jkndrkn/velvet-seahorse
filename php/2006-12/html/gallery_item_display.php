<?php
require_once("../php/db_wrapper.php");

$itemId = $_GET["id"];
$db_wrapper = new db_wrapper();
$db_wrapper->connect();
$db_wrapper->select_db();

$itemQuery = "select items.catId, catName, itemTitle, itemThumb, itemDesc, itemPrice, itemDateAdded " .
  "from items join categories where items.catId = categories.catId and itemId = '$itemId'";
$itemResult = $db_wrapper->do_query($itemQuery);

$imageQuery = "select imageUrl from itemimage where itemId = '$itemId'";

$imageResult = $db_wrapper->do_query($imageQuery);

$itemTitle = '';
$itemThumb = '';
$catPath = '';
$itemPrice = '';
$itemDesc = '';
$itemDateAdded = '';

while ($itemRow = mysql_fetch_assoc($itemResult)) {
  $itemId = $itemRow["itemId"];
  $itemTitle = $itemRow["itemTitle"];
  $itemThumb = $itemRow["itemThumb"];
  $catPath = $itemRow["catName"];
  $itemPrice = $itemRow["itemPrice"];
  $itemDesc = $itemRow["itemDesc"];
  $itemDateAdded = $itemRow["itemDateAdded"];
  echo "<div>\n";
  echo "<h2>$itemTitle</h2>\n";
  echo "<p>Price: <b>$$itemPrice</b></p>\n";
  echo "<p>$itemDesc</p>\n";
  echo "</div>\n";
  echo "<div>\n";
  while ($imageRow = mysql_fetch_assoc($imageResult)) {
    $imageUrl = $imageRow["imageUrl"];
    echo "<div class=\"galleryimg\"><img src=\"../img/shop/{$imageUrl}\"></div><br />\n";
  }
  echo "</div>\n";
  echo "<div class=\"footer\"></div>\n";
  break;
}

?>
