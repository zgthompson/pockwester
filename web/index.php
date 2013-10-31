<?php
// Landing page for the pockwester project web interface
// 9-17-13
// Arthur Wuterich

// Library include
require_once( 'lib/pw.cfg.php' );
require_once( 'lib/pw.functions.php' );

// Landing page code
session_start();

// Theme code
if( isset($_SESSION['THEME']) && !is_readable( THM_PATH . $_SESSION['THEME'] ) )
{
	unset($_SESSION['THEME']);
}


// If the post variable 'goto' is set then try to route to that page
if( isset( $_POST['goto'] ) )
{

	// Go back a page in history
	if( $_POST['goto'] == 'back' )
	{
		// Remove the last element because this is the old current page
		array_pop( $_SESSION['PAGE_HISTROY'] );
		$_SESSION['CURRENT_PAGE'] = end( $_SESSION['PAGE_HISTROY'] );
	}
	else
	// Goto page directly and save history
	{
		$_SESSION['CURRENT_PAGE'] = $_POST['goto'];
		
		// Only add a history element if it is unique
		if( count($_SESSION['PAGE_HISTROY']) <= 0 || end( $_SESSION['PAGE_HISTROY'] ) != $_POST['goto'] )
		{
			$_SESSION['PAGE_HISTROY'][] = $_POST['goto'];
		}
		
		// Maintain length of history to less than 5
		while( count( $_SESSION['PAGE_HISTROY'] ) > 5 )
		{
			array_shift( $_SESSION['PAGE_HISTROY'] );
		}
	}
	
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
<?php 
	// Load the PW bar to allow source files that changed information to be visible immediatly
	GetPage( PW_BAR_FILE );
?>
</body>
</html>