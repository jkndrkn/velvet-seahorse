<?php
require_once("db_wrapper.php");

class gallery_item {
  var $catId;
  var $title;
  var $price;
  var $numimages;
  var $images;
  var $description;
  var $itemId;
  var $valid;
  var $db_wrapper;

  function gallery_item($catId, $title, $price, $numimages, $images, $description) {
    $this->catId = $catId;
    $this->title = $title;
    $this->price = $price;
    $this->numimages = $numimages;
    $this->images = $images;
    $this->description = $description;
    $this->valid = false;
  }

  function validate($skipImages = FALSE) {
    $valid = true;
    $this->valid = true;
    $msg = array();
    $price_regexp = '/^\s*[$]?\s*\d+(\.\d{2})?\s*$/';
    if(!$this->catId) {
      $msg[] = 'catID';
    }
    if(!$this->title) {
      $msg[] = 'title';
    }
    if(!$this->price) {
      $msg[] = 'price';
    }
    elseif(!preg_match($price_regexp, $this->price, $matches)) {
      $msg[] = 'price';
    }
    if(!$this->numimages) {
      $msg[] = 'numimages';
    }
    if(!$this->description) {
      $msg[] = 'description';
    }
    if((!$this->images[0]) and !$skipImages) {
      $msg[] = 'thumbnail';
    }
    if((count($this->images) < 2) and !$skipImages) {
      $msg[] = 'images';
    }
    if($msg) {
      echo "<p><b>Empty or invalid fields: ";
      for($i = 0; $i < count($msg); $i++) {
        echo "$msg[$i]";
        if ($i < count($msg) - 1) echo ", ";
      }
      echo "</b></p>\n";
      $valid = false;
      $this->valid = false;
    }
    return $valid;
  }

  function display() {
    $firstIteration = true;
    echo "<div>\n";
    echo "<h2>$this->title</h2>\n";
    echo "<p>Price: <b>$this->price</b></p>\n";
    echo "<p>\n";
    echo "$this->description\n";
    echo "</p>\n";
    echo "</div>\n";
    echo "<div>\n";
    foreach($this->images as $image) {
      if(!$firstIteration) {
        echo "<img src=\"$image\" style=\"padding-right:5px;padding-top:5px;\"><br />\n";
      }
      $firstIteration = false;
    }
    echo "</div>\n";
  }

  function connect_db() {
    $this->db_wrapper = new db_wrapper();
    $this->db_wrapper->connect();
    $this->db_wrapper->select_db("vs");
  }

  function insert($updateItem = FALSE) {
    $this->connect_db();

    $thumb_path = $this->images[0];
    $thumb_array = explode("/", $thumb_path);
    $thumb_name = $thumb_array[count($thumb_array) - 1];

    $query = "select max(itemId) from items";
    $result = $this->db_wrapper->do_query($query);
	  while ($row = $this->db_wrapper->fetch_array($result)) {
	    $itemId = $row[0];
	    echo "<pre>\n";
	    $itemId++;
	    echo $itemId;
	    echo "</pre>\n";
    }

    if ($updateItem && $this->valid) {
      echo "Ready to update!\n";
      $query2 = "update items set " .
                  "catId = '$this->catId', " .
                  "itemTitle = '$this->title', " .
                  "itemPrice = '$this->price', " .
                  "itemDesc = '$this->description', " .
      $query2 .= (!empty($thumb_name)) ? "itemThumb = '$thumb_name', " : '';
      $query2 .=   "itemDateAdded = now() " .
                "where " .
                  "itemId = '$this->itemId' " .
                  "limit 1";
      echo "$query2\n";
      $this->db_wrapper->do_query($query2);
      echo "Updated!\n";
    }
    elseif($this->valid) {
      echo "Ready to insert!\n";
      $query = "insert into items " .
                  "(itemId, " .
                  "catId, " .
                  "itemTitle, " .
                  "itemPrice, " .
                  "itemDesc, " .
                  "itemThumb, " .
                  "itemDateAdded) " .
                "values " .
                  "('$itemId', " .
                  "'$this->catId', " .
                  "'$this->title', " .
                  "'$this->price', " .
                  "'$this->description', " .
                  "'$thumb_name', " .
                  "now())";
      echo "$query\n";
      $this->db_wrapper->do_query($query);
      echo "Inserted!\n";
    }
    else {
      echo "Not ready!\n";
      return;
    }
     
    if (!empty($thumb_name)) {
      unset($this->images[0]);
    }

    foreach($this->images as $image) {
      $image_array = explode("/", $image);
      $image_name = $image_array[count($image_array) - 1];
      echo "$image_name: <br />\n";
      $query3 = '';
      $query3 = "insert into itemimage " .
                 "(itemId, imageUrl) " .
                 "values " .
      $query3 .= ($updateItem) ? "('$this->itemId', " : "('$itemId', ";
      $query3 .= "'$image_name')";
      echo "<br />$query3\n";
      $this->db_wrapper->do_query($query3);
      echo "Inserted!\n";
    }
  }
}

?>
