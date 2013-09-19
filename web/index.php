<?php
// Landing page for the pockwester project web interface
// 9-17-13
// Arthur Wuterich

// Library include
require_once( 'lib/pw.cfg.php' );
require_once( 'lib/pw.functions.php' );

// Landing page code
session_start();


// If the post variable 'goto' is set then try to route to that page
if( isset( $_POST['goto'] ) )
{
	$_SESSION['CURRENT_PAGE'] = $_POST['goto'];
}

// Only allow the user to access the login page and the create account page
// if they are not logged in
if( !isset($_SESSION['USER']) )
{
	if( !IsPagePublic( $_SESSION['CURRENT_PAGE'] ) )
	{
		$_SESSION['CURRENT_PAGE'] = LOGIN_PAGE;	
	}
}

// If the current page is valid route to that page
// else goto home
if( IsPageValid( $_SESSION['CURRENT_PAGE'] ) )
{
	GetPage( $_SESSION['CURRENT_PAGE'] );
}
else
{
	GetPage( DEFAULT_CONTENT );
	$_SESSION['CURRENT_PAGE'] = DEFAULT_CONTENT;
}
?>