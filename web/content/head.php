<?php
// head.php: Global header information for pw
// 9-20-13
// Arthur Wuterich
?>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/pockwester/web/style/global.css">
<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>pw.global.css">
<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="style/lt.ie8.global.css"><![endif]-->

<!-- Theme CSS -->
<?php if( isset( $_SESSION['THEME'] ) ) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo THM_PATH . $_SESSION['THEME'] . '?=' . time(); ?>">
<?php } ?>

<!-- JAVA -->
<script type="text/javascript"> PAGE_ROOT = "<?php echo REL_CONTENT_PATH; ?>"; </script>
<script src="<?php echo JAV_PATH ?>jquery-1.10.2.js"></script>
<script src="<?php echo JAV_PATH ?>pw.global.js"></script>
<script src="<?php echo JAV_PATH ?>jquery-ui-1.10.3.custom.min.js"></script>


<title><?php echo TITLE; ?></title>
