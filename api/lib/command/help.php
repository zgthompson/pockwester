<?php
// help.php:	Displays help information
//				 -Expects api.php to call this file
// Arthur Wuterich
// 9-3-13

// Map for commands that have help information
$newline = '<BR/>';
$tab = '<span style="margin-left:30px;"></span>';
$result = '';

// Add each command
foreach( $API_COMMANDS as $cmd )
{
	$help = '';
	
	// Get all of the contents from the command file
	$content = file_get_contents( LIB_PATH . CMD_PATH . $cmd .'.php' );
	
	// Get comments
	$comments = token_get_all( $content );
	
	$copyComments = false;
	
	// Find the comment line with the command name in it
	foreach( $comments as $line )
	{
		
		if( $copyComments && stripos( $line[1], '//') !== FALSE )
		{
			if( strlen( $line[1] ) > 3 )
			{
				$help .= $newline . $tab . str_replace( array( '.php', '//', '/*', '*/', '* ', '\t' ), '', $line[1] ) ;
			}
		}
		else if( $copyComments )
		{
			break;
		}
		
		// If the comment contains the command name then use this line as the help information
		if ( !$copyComments && stripos( $line[1], $cmd) !== FALSE ) 
		{
			// Format help line
			$copyComments = true;
			$help = '<b>' . str_replace( array( '.php', '//', '/*', '*/', '* ', '\t' ), '', $line[1] ) . '</b>';
			continue;
		}
	}
	
	// If there is no help information signify that
	if( $help == '' )
	{
		$help = "{$cmd}: No help data for command.";
	}
		
	$result .= "{$help}{$newline}";
}

return( $result );
?>