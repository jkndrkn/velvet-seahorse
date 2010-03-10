<?php
require_once '../php/gallery.php';
?>

<ul id="thumbwrap">
<?php
$gallery = new gallery(5);
$gallery->display();
?>
</ul>

<img src="../img/spacer.gif" height="10" width="1"><br />
