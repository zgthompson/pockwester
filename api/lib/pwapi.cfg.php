<?php
// pwapi.cfg.php: Defines constants and configuration variables
// Arthur Wuterich
// 9/11/13

// Include core functions
require_once 'pwapi.functions.php';

// If true then legacy commands will execute, else the legacy commands will be redirected to 
// the most current command
define( 'LEGACY', true );

// Logging commands and runtimes
define( 'LOGGING', true );

// System Constants
// Messages
define( 'ERROR_INVALID_POST', 'Post array or elements are impropertly formed' );
define( 'ERROR_INVALID_KEY', 'API key is incorrect' );
define( 'ERROR_INVALID_TASK', 'API task does not exist' );
define( 'ERROR_VARIABLE_NOT_FOUND', 'A required variable was not found in the command argument array' );

// System Variables
// Returns an array of the commands available in the LIB_PATH/CMD_PATH/ directory
$API_COMMANDS = GetCommandArray( scandir( LIB_PATH . CMD_PATH ) );

// Group forming constants
define( 'MINIMUM_GROUP_SIZE', 3 );

// Length of availability strings
define( 'AVAL_LENGTH', 168 );

// Defines legacy commands and which function will be called on redirect
$LEGACY_COMMANDS = array( 'get_classes' => 'get_courses' );

// User flags
// Binary flags: 8765 4321
//	1: Looking for group
define( 'USER_DEFAULT', 0 );
define( 'USER_LOOKING_FOR_GROUP', 1 );

?>