<br />
<?php
require_once("../php/check_login.php");
if(isset($_POST["page"])) {
 $page = $_POST["page"];
 echo "<p><b>EDITING " . strtoupper($page) . "</b></p>\n";

 $query = "select pageDate, pageText from pages where pageName = '$page'";

 $result = $db_wrapper->do_query($query);
?>
<form action="admin.php?p=page_edit" method="post">
<textarea tabindex="2" wrap="soft" style="width: 100%" name="pageText" rows="20" cols="50">
<?php
$row = $db_wrapper->fetch_array($result);
echo $row['pageText'];
?>
</textarea>
<br />
<p>
<input class="button" type="submit" name="submit" value="submit changes">
<input type="hidden" name="pageFinal" value="<?php echo $page; ?>">
<input type="hidden" name="submit" value="true">
</form>
<?php
}
else if(isset($_POST["submit"])) {
  $pageText = $_POST["pageText"];
  $pageText = stripslashes($pageText);
  $page = $_POST["pageFinal"];
  echo "<p><b>CHANGE SUBMITTED - " . strtoupper($page) . "</b></p>\n";
  echo $pageText . "<br />\n";
  //if ($db_wrapper->$host == 'localhost') $pageText = addslashes($pageText);
  $query = "update pages set pageText = '$pageText' where pageName = '$page'";
  $db_wrapper->do_query($query);
?>
</p>
<p>
<form>
<input class="button" type="button" onclick="history.back()" value="make more changes">
</form>
</p>
<p>
<form>
<input class="button" type="button" onclick="location.href = 'admin.php'" value="done">
<input type="hidden" name="preview" value="submit">
</form>
</p>
<?php
}
?>
