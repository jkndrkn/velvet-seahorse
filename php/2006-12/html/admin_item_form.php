<br />
<?php 
require_once("../php/check_login.php"); 
require_once("../php/db_wrapper.php");

$db_wrapper = new db_wrapper();
$db_wrapper->connect();
$db_wrapper->select_db();

$mode = $_GET['mode'];
$itemId = $_GET['itemId'];

$itemTitle = '';
$itemDesc = '';
$itemPrice = '';
$catName = '';
$numExistingImages = 0;

if ($mode == 'edit') {
  $itemQuery = "
    select items.catId, catName, itemTitle, itemDesc, itemPrice, itemDateAdded
    from items join categories on items.catId = categories.catId
    where items.itemId = '$itemId'
    ";

  $itemResult = $db_wrapper->do_query($itemQuery);

  while ($row = $db_wrapper->fetch_array($itemResult)) {
    $itemTitle = $row['itemTitle'];
    $itemDesc = $row['itemDesc'];
    $itemPrice = $row['itemPrice'];
    $catName = $row['catName'];
  }

  $imageQuery = "select count(imageUrl) from itemimage where itemId = '$itemId'";

  $imageResult = $db_wrapper->do_query($imageQuery);

  while ($row = $db_wrapper->fetch_array($imageResult)) {
    $numExistingImages = $row[0];
  }

}

?>
<form enctype="multipart/form-data" action="admin.php?p=item_modify" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="8000000" />
<input type="hidden" name="mode" value="<?=$mode?>" />
<input type="hidden" name="itemId" value="<?=$itemId?>" />

<!-- Begin select category -->
<p><b>Category:</b></p>
<select name="catId">
<?php
$numimages = 10 - $numExistingImages;
$query = "select * from categories";

$result = $db_wrapper->do_query($query);

while ($row = $db_wrapper->fetch_array($result)) {
  $id = $row['catId'];
  $category = $row['catName'];
  if ($category == $catName)
    echo "<option value=\"" . $id . "\" selected=\"selected\">$category</option><br />\n";
  else
    echo "<option value=\"" . $id . "\">$category</option><br />\n";
}
?>
</select>
<!-- End select category -->

<br />

<!-- Begin item title input field -->
<p><b>Title:</b></p>
<input type="text" name="title" value="<?=$itemTitle?>" size=\"30\">
<!-- End item title  input field -->

<br />

<!-- Begin item price input field -->
<p><b>Price:</b></p>
<input type="text" name="price" value="<?=$itemPrice?>" size=\"30\">
<!-- End item price input field -->

<br />

<p><b>Image Files</b> <?php if ($mode == 'edit') echo "<i>(Replace thumbnail or add additional images)</i>";?></p>

<!-- Begin thumbnail url input field -->
<input type="hidden" name="numimages" value="<?=$numimages?>" />
<span style="font-family: courier">T:</span> <input type="file" name="img0" size="60">
<!-- End thumbnail url input field -->

<br />

<!-- Begin image url input fields -->
<?php
for ($i = 1; $i <= $numimages; $i++) {
  $index = $i;
  if (strlen($i) == 1) $index = "$i&nbsp;";
  echo "<span style=\"font-family: courier\">$index</span> ";
  echo "<input type=\"file\" name=\"img$i\" size=\"60\"><br \>\n";
}
?>
<!-- End image url input fields -->

<!-- Begin description input field -->
<p><b>Description:</b></p>
<textarea tabindex="2" wrap="soft" style="width: 50%" name="description" rows="10" cols="20">
<?=$itemDesc?>
</textarea>
<!-- End description input field -->

<br />
<br />

<input class="button" type="submit" name="submit" value="preview">
</form>
