<?php 

require_once 'header.php';
require_once 'config.php';
require_once 'Util.php';
        
$current = Util::set('current', 1);

?>
<div id="gallery">
    <?php echo Util::generate_gallery('eyes', IMG_COUNT_EYES, $current); ?>
</div>
<?php require_once 'footer.php'; ?>
