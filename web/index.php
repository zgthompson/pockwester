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

// If the user is not set then only allow access to public pages
if( !isset($_SESSION['USER']) )
{
	if( !IsPagePublic( $_SESSION['CURRENT_PAGE'] ) )
	{
		$_SESSION['CURRENT_PAGE'] = LOGIN_PAGE;	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<?php GetPage( HEADER_FILE ); ?>
</head>
<body>
<?php GetPage( PW_BAR_FILE ); ?>
<div id="page">
	<div id="main_content">
		<?php
		// If the current page cannot be retrived then return the default content page
		if( !GetPage( $_SESSION['CURRENT_PAGE'] ) )
		{
			GetPage( DEFAULT_CONTENT );
			$_SESSION['CURRENT_PAGE'] = DEFAULT_CONTENT;
		}
		?>
	</div>
</div>
</body>
</html>