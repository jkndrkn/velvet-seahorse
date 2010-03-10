<?php
function get_text($page) {
  require_once("db_wrapper.php");

  $db_wrapper = new db_wrapper();
  $connection = $db_wrapper->connect();
  $db_wrapper->select_db("vs");

  $query = "select pageText from pages where pageName = '$page'";
  $result = $db_wrapper->do_query($query);
  $row = $db_wrapper->fetch_array($result);
  echo $row['pageText'];

  $db_wrapper->close();
}
?>