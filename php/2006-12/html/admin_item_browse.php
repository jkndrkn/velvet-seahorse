<br />
<?php
require_once("../php/check_login.php");
require_once("../php/db_wrapper.php");

$db_wrapper = new db_wrapper();
$db_wrapper->connect();
$db_wrapper->select_db();

$itemQuery = "select itemId, items.catId, catName, itemTitle, itemThumb, itemDesc, itemPrice, itemDateAdded " .
  "from items join categories on items.catId = categories.catId " .
  "order by items.catId, itemDateAdded desc";
$itemResult = $db_wrapper->do_query($itemQuery);

$itemId = '';
$itemTitle = '';
$itemThumb = '';
$catPath = '';
$itemPrice = '';
$itemDesc = '';
$itemDateAdded = '';

while ($row = mysql_fetch_assoc($itemResult)) {
  $itemId = $row["itemId"];
  $itemTitle = $row["itemTitle"];
  $itemThumb = $row["itemThumb"];
  $catPath = $row["catName"];
  $itemPrice = $row["itemPrice"];
  $itemDesc = $row["itemDesc"];
  $itemDateAdded = $row["itemDateAdded"];
  echo "<div class=\"left\">\n";
  echo "<div class=\"galleryimg\"><img src=\"../img/shop/{$itemThumb}\" height=\"125\" width=\"125\" border=\"0\"></div>\n";
  echo "</div>\n";
  echo "<div class=\"right\">\n";
  echo "<b>$itemTitle</b><br />\n";
  echo strtoupper($catPath) . "<br />\n";
  echo "$$itemPrice<br />\n";
  echo substr($itemDesc, 0, 30) . "...<br />\n";
  $imageQuery = "select itemId, imageUrl from itemimage where itemId = '$itemId'";
  $imageResult = $db_wrapper->do_query($imageQuery);
  while ($imageRow = mysql_fetch_assoc($imageResult)) {
    $itemId = $imageRow["itemId"];
    $imageUrl = $imageRow["imageUrl"];
    echo "<a href=\"admin.php?p=image_delete&itemId={$itemId}&imageUrl={$imageUrl}&catPath={$catPath}\">$imageUrl</a> \n";
  }
  echo "<form action=\"admin.php?p=item_form&itemId=$itemId&mode=edit\" method=\"post\">\n";
  echo "<input class=\"button\" type=\"submit\" name=\"submit\" value=\"edit\">\n";
  echo "</form>\n";
  echo "<form action=\"admin.php?p=item_delete&itemId=$itemId\" method=\"post\">\n";
  echo "<input class=\"button\" type=\"submit\" name=\"submit\" value=\"delete\">\n";
  echo "</form>\n";
  echo "</div>\n";
  echo "<div class=\"footer\"></div>\n";
}

?>
