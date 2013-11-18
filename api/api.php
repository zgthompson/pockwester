<?php
// api.php: Core file in data transfer between mobile clients and web server
// Arthur Wuterich
// 9-3-2013

// Paths
define( 'LIB_PATH', 'lib/' );
define( 'CMD_PATH', 'command/' );

// Logging
if( LOGGING )
{
	$start = microtime( true );
}


// Load api libraries
require_once LIB_PATH . 'database/database.functions.php';
require_once LIB_PATH . 'pwapi.functions.php';

// Load config file
require_once LIB_PATH . 'pwapi.cfg.php';

// Application Variables
define( 'APIKEY', $_POST['apikey'] );
define( 'APITASK', $_POST['apitask'] );
define( 'DEBUG', true );

// Exit conditions that result from incomplete post data
// -Either of the two required post variables are not set
if( !APIKEY || !APITASK )
{
	exit( ERROR_INVALID_POST );
}
// -Api key is incorrect				
if( APIKEY != $_SERVER['API_APIKEY'] && ( DEBUG && APIKEY != 'test' ) )
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
$result = include( LIB_PATH . CMD_PATH . $Apitask . '.php' );

// Logging
if( LOGGING )
{
	DB_Connect();
	$end = microtime( true );
	$seconds = $end - $start;
	$ip = isset($_POST['ip'])?$_POST['ip']:$_SERVER['REMOTE_ADDR'];
	DB_Query( "INSERT INTO API_LOG(COMMAND,IP,SECONDS,START,END)VALUES(\"{$Apitask}\",\"{$ip}\",\"{$seconds}\",\"{$start}\",\"{$end}\")");
}

exit( $result );

?>

