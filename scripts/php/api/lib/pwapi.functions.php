<?php
// pwapi.functions.php: Core functions for the pwapi
// Arthur Wuterich
// 9-3-13


	// Returns true if the haystack ends with the needle
	// Precondition: $haystack and $needle are both strings and $needle is less than or equal to the size of $haystack
	function strend( $haystack, $needle )
	{
		// Exit conditions
		if( !is_string( $haystack ) || !is_string( $needle ) || strlen( $haystack ) <= strlen( $needle ) )
		{
			return false;
		}
		
		// Get the start position of the comparison
		$needleLength = strlen( $needle );
		$haystackStartPos = strlen( $haystack ) - $needleLength;
				
		// Check each element of the needle string against the end of the haystack if there is a discrepancy return false
		for( $i = 0; $i < $needleLength; $i++ )
		{
			// If an element does not match then exit
			if( $haystack[$haystackStartPos+$i] !== $needle[$i] )
			{
				return false;
			}
		}
		
		return true;
	}

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
			if( strend( $cmd, '.php' ) !== false )
			{
				// Format the .php off of commands that do end with .php			
				$result[] = str_replace( '.php', '', $cmd );
			}
		}
		
		return $result;
	}
	
	// Returns the associated file in the post array or ends execution if the variable is required and not present
	function Get( $postVariable, $required = true )
	{
		return ($_POST[$postVariable]||!$required)?$_POST[$postVariable]:exit( ERROR_VARIABLE_NOT_FOUND . ": {$postVariable}" );
	}
?>