<?php
require_once("../php/check_login.php");
require_once("../php/gallery_item.php");

$catId = $_POST['catId'];
$title = $_POST['title'];
$price = $_POST['price'];
$mode = $_POST['mode'];
$itemId = $_POST['itemId'];
$numimages = $_POST['numimages'];
$images = array();
$description = $_POST['description'];


function check_images($upload_dir, $numimages) {
  $validImages = true;
  global $images;

  for ($i = 0; $i <= $numimages; $i++) {
    if (is_uploaded_file($_FILES["img$i"]['tmp_name'])) {
      $filename = basename($_FILES["img$i"]['name']);
      $images[$i] = $upload_dir . $filename;

      if (file_exists($images[$i])) {
        if ($i == 0) echo "<p><b>THUMBNAIL: </b>";
        else echo "<p><b>IMAGE $i: </b>";

        echo "$images[$i] . <br />\n";

        echo "File <b>$filename</b> already exists on server!";
        $validImages = false;
        echo "<br /></p>\n";
      }
    }
  }

  return $validImages;
}

function upload_images($upload_dir, $numimages) {
  $uploadSuccess = true;
  global $images;

  for ($i = 0; $i <= $numimages; $i++) {
    if (is_uploaded_file($_FILES["img$i"]['tmp_name'])) {

      if ($i == 0) echo "<p><b>THUMBNAIL: </b>";
      else echo "<p><b>IMAGE $i: </b>";

      echo "$images[$i] . <br />\n";

      if (move_uploaded_file($_FILES["img$i"]['tmp_name'], $images[$i])) {
        echo "...Uploaded!";
      }
      else {
        echo "...Failed upload!";
        $uploadSuccess = false;
      }

      echo "<br /></p>\n";
    }
  }

  return $uploadSuccess;
}

/* Upload files here */
$validItem = true;

$upload_dir = "../img/shop/";

echo "<b>CATID</b> $catId<br />\n";
echo "<b>TITLE</b> $title<br />\n";
echo "<b>PRICE:</b> $price<br />\n";
echo "<b>MAX IMAGES:</b> $numimages <br />\n";

if (!check_images($upload_dir, $numimages)) {
  $validItem = false;
}

$item = new gallery_item($catId, $title, $price, $numimages, $images, $description);


$skipImages = ($mode == 'edit') ? TRUE : FALSE;

if ($item->validate($skipImages) && $validItem) {
  if (!upload_images($upload_dir, $numimages)) {
    "<p><b>ERROR!</b> Images did not upload! Critical server error!</p>\n";
    $validItem = false;
  }
}
else {
  $validItem = false;
}

echo "<b>DESCRIPTION:</b> $description<br /><br />\n";

if($validItem) {
  echo "<b>ITEM VALID!</b><br />\n";
  echo "<hr>\n";
  $item->display();
  echo "<div class=\"footer\">\n";
  echo "<hr>\n";
  echo "<form enctype=\"multipart/form-data\" action=\"admin.php?p=item_add\" method=\"post\">\n";
  echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"8000000\" />\n";
  echo "<input class=\"button\" type=\"submit\" name=\"submit\" value=\"add item\">\n";
  echo "<input type=\"hidden\" name=\"catId\" value=\"$catId\" />\n";
  echo "<input type=\"hidden\" name=\"title\" value=\"$title\" />\n";
  echo "<input type=\"hidden\" name=\"price\" value=\"$price\" />\n";
  echo "<input type=\"hidden\" name=\"numimages\" value=\"$numimages\" />\n";
  echo "<input type=\"hidden\" name=\"description\" value=\"$description\" />\n";
  echo "<input type=\"hidden\" name=\"mode\" value=\"$mode\" />\n";
  echo "<input type=\"hidden\" name=\"itemId\" value=\"$itemId\" />\n";
  echo "<input type=\"hidden\" name=\"images\" value=\"" . base64_encode(serialize($images)) . "\" />\n";
  echo "</form>\n";
  echo "</div>\n";
}
else {
  echo "<b>ITEM INVALID!</b><br />\n";
  echo "<i>Please go back and check your input fields!</i><br />\n";
}


?>
