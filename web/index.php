<?php
//	Main content wrapper
//	10/25/2013
//	Arthur Wuterich

// Library Includes
include 'lib/pw.cfg.php';
include 'lib/pw.functions.php';

// Functions

// Landing page code
session_start();

// Title of webpage
$title = 'Forge';

// Rel path to content folder
$CONTENT_PATH = '/home/content/14/11456014/html/pockwester/web/content';
define( 'CONTENT_PATH', $CONTENT_PATH );
define( 'REL_CONTENT_PATH', '/pockwester/web' );

// Break apart the URI
//echo $_SERVER['REQUEST_URI'];
$requestUrl = explode('/', $_SERVER['REQUEST_URI'] );
$page = '';

// Process the URI request
while( count( $requestUrl ) > 0 )
{
	// If any element is empty skip processing
	if( strlen( end($requestUrl)) <= 0 )
	{
		array_pop($requestUrl);
		continue;
	}
	else
	{
		$page = array_pop( $requestUrl );
		break;
	}
}

// If the user is not set then only allow access to public pages
if( !isset($_SESSION['USER']) )
{
	if( !IsPagePublic( $page ) )
	{
		$page = LOGIN_PAGE;	
	}
}

// If the page is not readable then redirect
if( strlen( $page ) <= 0 || !is_readable( "{$CONTENT_PATH}/{$page}.php" ) )
{
	if( isset($_SESSION['USER']) )
	{
		$page = DEFAULT_CONTENT;
	}
	else
	{
		$page = LOGIN_PAGE;
	}
}
else
{
	// Process the last root node's name as the title
	$pageLevels = explode( '.', $page );
	$titlePage = ucwords( str_replace( array('-','_'), ' ', end( $pageLevels ) ) );
	$title .= " {$titlePage}";
}

if( isset($_POST['bypass_needs']) )
{
	unset( $_SESSION['NEEDS'] );
}

if( $page == 'home' && isset( $_SESSION['USER']) && isset($_SESSION['NEEDS']) )
{
	$page = INFO_CONTENT;
}

$_SESSION['CURRENT_PAGE'] = $page;

?>
<!DOCTYPE html>
<html>
<head>
<?php 
	define( 'TITLE', $title );
	include "{$CONTENT_PATH}/head.php"; 
?>
</head>
<body>
<div id="page">
	<div id="main_content">
		<?php include "{$CONTENT_PATH}/{$page}.php"; ?>
	</div>
</div>
<?php 
	// Load the PW bar to allow source files that changed information to be visible immediatly
	include "{$CONTENT_PATH}/" . PW_BAR_FILE;
?>
</body>
</html>
