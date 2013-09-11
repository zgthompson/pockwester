<?php
// api.php: Core file in data transfer between mobile clients and web server
// Arthur Wuterich
// 9-3-2013

// Paths
define( 'LIB_PATH', 'lib/' );
define( 'CMD_PATH', 'command/' );

// Load api libraries
require_once LIB_PATH . 'database/database.functions.php';
require_once LIB_PATH . 'pwapi.functions.php';

// Load config file
require_once LIB_PATH . 'pwapi.cfg.php';

// Application Variables
DEFINE( 'APIKEY', $_POST['apikey'] );
DEFINE( 'APITASK', $_POST['apitask'] );

// Exit conditions that result from incomplete post data
// -Either of the two required post variables are not set
if( !APIKEY || !APITASK )
{
	exit( ERROR_INVALID_POST );
}
// -Api key is incorrect
if( APIKEY != $_SERVER['API_APIKEY'] && APIKEY != 'test' )
{
	exit( ERROR_INVALID_KEY );
}

// -Apitask is not a recognized task
if( !in_array( $_POST['apitask'], $API_COMMANDS ) )
{	
	exit( ERROR_INVALID_TASK );
}

$Apitask = APITASK;

// Check if the Apitask is a legacy task
// -Redirect to modern command if Apitask is legacy and the redirect command exists
if( !LEGACY && isset( $LEGACY_COMMANDS[APITASK] ) && in_array( $LEGACY_COMMANDS[APITASK], $API_COMMANDS ) )
{
	$Apitask = $LEGACY_COMMANDS[APITASK];
}

// Execute command
include( LIB_PATH . CMD_PATH . $Apitask . '.php' );

exit();

?>

