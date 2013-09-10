<?php
// api.php: Core file in data transfer between mobile clients and web server
// Arthur Wuterich
// 9-3-2013

// System Constants
define( 'LIB_PATH', 'lib/' );
define( 'CMD_PATH', 'command/' );

// Messahes
define( 'ERROR_INVALID_POST', 'Post array or elements are impropertly formed' );
define( 'ERROR_INVALID_KEY', 'API key is incorrect' );
define( 'ERROR_INVALID_TASK', 'API task does not exist' );
define( 'ERROR_VARIABLE_NOT_FOUND', 'A required variable was not found in the command argument array' );

// Load api libraries
require_once LIB_PATH . 'database/database.functions.php';
require_once LIB_PATH . 'pwapi.functions.php';

// System Variables
// Returns an array of the commands available in the LIB_PATH/CMD_PATH/ directory
$API_COMMANDS = GetCommandArray( scandir( LIB_PATH . CMD_PATH ) );

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
// small hack to allow 'test' to work
if( APIKEY != $_SERVER['API_APIKEY'] && APIKEY != 'test' )
{
	exit( ERROR_INVALID_KEY );
}

// -Apitask is not a recognized task
if( !in_array( $_POST['apitask'], $API_COMMANDS ) )
{	
	exit( ERROR_INVALID_TASK );
}

// Execute command script which is expected to output the required data
include( LIB_PATH . CMD_PATH . APITASK . '.php' );

exit();

?>

