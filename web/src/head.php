<?php
// head.php: Global header information for pw
// 9-20-13
// Arthur Wuterich
?>
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>pw.global.css">
<?php if( isset( $_SESSION['THEME'] ) ) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo THM_PATH . $_SESSION['THEME']; ?>">
<?php } ?>
<script src="<?php echo JAV_PATH ?>jquery-1.10.2.js"></script>
<script src="<?php echo JAV_PATH ?>pw.global.js"></script>
<title>Forge</title>
