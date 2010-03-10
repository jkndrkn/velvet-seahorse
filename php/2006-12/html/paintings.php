<?php
require_once '../php/gallery.php';
?>

<p class="heading">PAINTINGS</p>


<div class="thumbwrap">
<?php
$gallery = new gallery(4);
$gallery->display();
?>
</div>

<img src="../img/spacer.gif" height="10" width="1"><br />
