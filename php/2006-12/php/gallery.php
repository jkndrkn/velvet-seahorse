<?php
require_once("db_wrapper.php");

class gallery {
  var $catId;
  var $items;
  var $db_wrapper;
  var $img_path;
  var $cat_path;

  function gallery($catId) {
    $this->catId = $catId;
    $this->items = array();
    $this->db_wrapper = new db_wrapper();
    $this->db_wrapper->connect();
    $this->db_wrapper->select_db("vs");
    $this->img_path = "../img/shop/";

    $query = "select catName from categories where catId = " . $this->catId;

	  $result = $this->db_wrapper->do_query($query);

	  while($row = $this->db_wrapper->fetch_array($result)) {
	    $this->cat_path = $row['catName'];
	    break;
    }
  }

  function display() {
    $query = "select itemId, itemTitle, itemThumb from items where catId = " . $this->catId .
      " order by itemDateAdded desc";
    $result = $this->db_wrapper->do_query($query);

    $itemId = '';
    $itemTitle = '';
    $itemThumb = '';

    while ($row = mysql_fetch_assoc($result)) {
	    $itemId = $row["itemId"];
	    $itemTitle = $row["itemTitle"];
	    $itemThumb = $row["itemThumb"];
      echo "
        <li>
          <a href=\"?p=gallery&id=$itemId\"><img src=\"../img/shop/{$itemThumb}\"><span>$itemTitle</span></a>
        </li>
      ";
    }

    $this->db_wrapper->close();
  }
}
?>
