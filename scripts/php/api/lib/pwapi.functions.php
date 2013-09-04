<?php
// pwapi.functions.php: Core functions for the pwapi
// Arthur Wuterich
// 9-3-13

	// Returns a formatted array of commands
	// Precondtion: Expects an array of filename strings from the api/lib/commands/ dir
	// Postcondition: A formated array of pwapi commands that can be executed
	function GetCommandArray( $cmds )
	{
		// Exit conditions
		if( !is_array( $cmds ) || count( $cmds ) <= 0 )
		{
			return array('');
		}
		
		$result = array();
		
		// Loop over each command in the cmds array
		foreach( $cmds as $cmd )
		{
			$cmd = strtolower( $cmd );
			
			// Skip commands that do not contain with .php
			if( strpos( $cmd, '.php' ) !== false )
			{
				// Format the .php off of commands that do end with .php			
				$result[] = str_replace( '.php', '', $cmd );
			}
		}
		
		return $result;
	}
?>