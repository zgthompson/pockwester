<?php
// help.php:	Displays help information
//				 -Expects api.php to call this file
// Arthur Wuterich
// 9-3-13

// Map for commands that have help information
$newline = '<BR/>';
$result = '';

// Add each command
foreach( $API_COMMANDS as $cmd )
{
	$help = '';
	
	// Get all of the contents from the command file
	$content = file_get_contents( LIB_PATH . CMD_PATH . $cmd .'.php' );
	
	// Get comments
	$comments = token_get_all( $content );
		
	// Find the comment line with the command name in it
	foreach( $comments as $line )
	{
		// If the comment contains the command name then use this line as the help information
		if ( stripos( $line[1], $cmd) !== FALSE ) 
		{
			// Format help line
			$help = str_replace( '//', '', $line[1] );
			break;
		}
	}
	
	// If this is a legacy command signify it
	if( isset($LEGACY_COMMANDS[$cmd]) )
	{
		$help = "{$help}*";
	}

	
	$result .= "{$help}{$newline}";
}

// Add footer information
$result .= '( * = legacy )';

exit( $result );
?>