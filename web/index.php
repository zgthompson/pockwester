<?php
// Landing page for the pockwester project web interface
// 9-17-13
// Arthur Wuterich

// Library include
require_once( 'lib/pw.cfg.php' );
require_once( 'lib/pw.functions.php' );

// Landing page code
session_start();

// If the current page is valid route to that page
// else goto home
if( IsPageValid( $_SESSION['CURRENT_PAGE'] ) )
{
	GetPage( $_SESSION['CURRENT_PAGE'] );
}
else
{
	GetPage( DEFAULT_CONTENT );
}
?>