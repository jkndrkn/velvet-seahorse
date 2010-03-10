<?php
ob_start("ob_gzhandler");
require_once("../php/db_wrapper.php");
$db_wrapper = new db_wrapper();
$db_wrapper->set_log("../php/errorlog.txt");
$db_wrapper->connect();
$db_wrapper->select_db();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Velvet Seahorse - Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../css/estilo.css">
</head>
<body class="admin">
<?php
require_once("../php/check_login.php");
include "head_admin.html";
?>
<!-- begin main -->

<?php
if(!isset($_GET['p'])) {
  include "admin_main.php";
}
else {
  switch ($_GET['p']) {
    case "admin":
      include "admin_main.php";
      break;
    case "item_browse":
      include "admin_item_browse.php";
      break;
    case "item_form":
      include "admin_item_form.php";
      break;
    case "page_edit":
      include "admin_page_edit.php";
      break;
    case "image_delete":
      include "admin_image_delete.php";
      break;
    case "item_modify":
      include "admin_item_modify.php";
      break;
    case "item_add":
      include "admin_item_add.php";
      break;
    case "item_delete":
      include "admin_item_delete.php";
      break;
    case "logout":
      include "logout.php";
      break;
    default:
  	  include "admin_main.php";
      break;
  }
}
?>

<!-- end main -->
<?php $db_wrapper->close(); ?>
</body>
</html>
