<?php
// api.php: Core file in data transfer between mobile clients and web server
// Arthur Wuterich
// 9-3-2013

// System Constants
define( 'LIB_PATH', 'lib/' );
define( 'CMD_PATH', 'command/' );
define( 'API_APIKEY', '5JrkmqFUxrf90cd' );
define( 'ERROR_INVALID_POST', 'Post array or elements are impropertly formed' );
define( 'ERROR_INVALID_KEY', 'API key is incorrect' );
define( 'ERROR_INVALID_TASK', 'API task does not exist' );

// System Variables
$API_COMMANDS = array( 'get_colleges', 'get_classes' );


// Load api libraries
include_once LIB_PATH . 'database/database.functions.php';
//include_once LIB_PATH . 'admin/insert.functions.php';

// Application Variables
DEFINE( 'APIKEY', isset($_POST['apikey'])?$_POST['apikey']:'' );
DEFINE( 'APITASK', isset($_POST['apitask'])?$_POST['apitask']:'' );

// Exit conditions that result from incomplete post data
// -Either of the two required post variables are not set
if( APIKEY == '' || APITASK == '' )
{
	exit( ERROR_INVALID_POST );
}
// -Api key is incorrect
if( APIKEY != API_APIKEY )
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

?>

