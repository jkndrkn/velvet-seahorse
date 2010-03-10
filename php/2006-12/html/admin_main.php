<br />
<?php require_once("../php/check_login.php"); ?>
<p><b>Admin Main</b></p>
<!-- Begin page selection menu -->
Edit page:
<form action="admin.php?p=page_edit" method="post">
<select name="page">
<?php
$query = "select pageName from pages";

$result = $db_wrapper->do_query($query);

while($row = $db_wrapper->fetch_array($result)) {
  $page = $row['pageName'];
  echo "<option value=\"" . $page . "\">$page</option><br />\n";
}
?>
</select>
<input class="button" type="submit" name="submit" value="edit">
</form>
<!-- End page selection menu -->

<br />

<!-- Begin modify items -->
Browse item:
<form>
<input class="button" type="button" value="browse" onclick="location.href = 'admin.php?p=item_browse'">
</form>
<!-- End modify items -->

<br />

<!-- Begin add item -->
Add item:
<form>
<input class="button" type="button" value="add" onclick="location.href = 'admin.php?p=item_form'">
</form>
<!-- End add item -->
