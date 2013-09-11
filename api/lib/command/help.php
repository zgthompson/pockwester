<?php
// help.php:	Displays help information
//				 -Expects api.php to call this file
// Arthur Wuterich
// 9-3-13

// Map for commands that have help information
$info = array
(
	'cmds' 			=>	'Displays the loaded commands for pwapi',
	'help' 			=>	'Help information for the commands in the pwapi',
	'get_classes' 	=> 	'Returns an JSON object with the classes',
	'get_courses' 	=> 	'Returns an JSON object with the classes formatted for Android client',
	'get_colleges' 	=> 	'Returns an JSON object with colleges',
	'test_post' 	=> 	'Requires and returns the post variable \'cat\'',
	'test_cmd' 		=> 	'Testing grounds for new commands and revisions'
);

$newline = '<BR/>';

$result = '';

// Add each command
foreach( $API_COMMANDS as $cmd )
{
	$help = (isset($info[$cmd]))?$info[$cmd]:'';
	if( isset($LEGACY_COMMANDS[$cmd]) )
	{
		$result .= "*{$cmd}: {$help}{$newline}";
	}
	else
	{
		$result .= "{$cmd}: {$help}{$newline}";
	}
}

$result .= '( * = legacy )';

exit( $result );
?>