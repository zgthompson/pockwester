<?php
// help.php:	Displays help information
//				 -Expects api.php to call this file
// Arthur Wuterich
// 9-3-13

// Map for commands that have help information
$info = array
(
	'cmds' =>			'Displays the loaded commands for pwapi',
	'help' => 			'Help information for the commands in the pwapi',
	'get_classes' => 	'Returns an JSON object with the classes',
	'get_colleges' => 	'Returns an JSON object with colleges'
);

$newline = '<BR/>';

$result = '';

// Add each command
foreach( $API_COMMANDS as $cmd )
{
	$help = (isset($info[$cmd]))?$info[$cmd]:'';
	$result .= "{$cmd}: {$help}{$newline}";
}

exit( $result );
?>