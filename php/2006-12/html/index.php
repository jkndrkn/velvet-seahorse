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
<title>Velvet Seahorse</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../css/estilo.css">
</head>
<body class="main">
<div class="wrap">
<div id="head" onClick="javascript:window.location.href='index.php'"></div>
<?php include '../html/menu.php'; ?>
<!-- begin main -->
<div class="main">
<?php

$login_ok = true;

if(!isset($_GET['p'])) {
  include "main.php";
}
else {
  switch ($_GET['p']) {
    case "main":
      include "main.php";
      break;
    case "shop":
      include "shop.php";
      break;
    case "photos":
      include "photos.php";
      break;
    case "jewelry":
      include "jewelry.php";
      break;
    case "ceramics":
      include "ceramics.php";
      break;
    case "mixed_media":
      include "mixed_media.php";
      break;
    case "garagesale":
      include "garagesale.php";
      break;
    case "about":
      include "about.php";
      break;
    case "contact":
      include "contact.php";
      break;
    case "links":
      include "links.php";
      break;
    case "resume":
      include "resume.php";
      break;
    case "faq":
      include "faq.php";
      break;
    case "login":
      include "login.php";
      break;
    case "error":
      include "error.php";
      break;
    case "gallery":
      include "gallery_item_display.php";
      break;
    default:
  	  include "main.php";
     break;
  }
}

?>
<!-- end main -->
</div>
</div>
<?php include '../html/foot.php'; ?>
</body>
</html>
