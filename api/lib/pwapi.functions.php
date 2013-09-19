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
	
	// Returns an assoc array prepared for JSON conversion
	// $formatFunction: Function that will format the keys of the returned assoc array
	//  formatFunction Precondition: Accepts one string value and returns a string
	// Precondition: $source and $exclude are both valid arrays
	function FormatRow( &$source, &$exclude, $formatFunction = 'FormatColumn' )
	{
	
		$resultArray = array();	
	
		// Exit conditions
		// If $source or $exclude are not arrays
		// If $formatFunction is not callable *** not a function *** 
		// If $formatFunction is not a function name
		if( !is_array( $source ) || !is_array( $exclude ) || ( !is_callable( $formatFunction ) && !function_exists( $formatFunction ) ) )
		{
			return $resultArray;
		}	
	
		foreach( $source as $key => $val )
		{
			// Only include elements that are not excluded
			if( !in_array( $key, $exclude ) )
			{
				$resultArray[$formatFunction($key)] = $val;
			}
		}
		
		return $resultArray;
	}
	
	// Renames elements from the $source assoc array based on the $rename array
	// $rename: Is expected to be a assoc array which represents <name to change> => <new name>
	// Precondition: Both $source and $rename are both arrays
	function RenameKeys( &$source, &$rename )
	{
		// Exit conditions
		if( !is_array( $source ) || !is_array( $rename ) )
		{
			return;
		}
		
		// Rename any fields that need to be converted
		foreach( $rename as $key => $value )
		{
			if( isset( $source[$key] ) )
			{
				$source[$value] = $source[$key];
				unset( $source[$key] );
			}
		}		
		
	}
	
	// Combines elements from the $source assoc array based on the $rename array
	// $combine: Is expected to be a assoc array which represents <field to keep> => <field to combine>
	// $delimit: What will be placed in between the two elements on concatenation
	// Precondition: Both $source and $combine are both arrays	
	function CombineKeys( &$source, &$combine, $delimit = ' ' )
	{
		// Exit conditions
		if( !is_array( $source ) || !is_array( $combine ) )
		{
			return;
		}
		
		// Combine required fields	
		foreach( $combine as $key => $value )
		{
			if( isset( $source[$key] ) && isset( $source[$value] ) )
			{
				$source[$key] = $source[$key] . $delimit . $source[$value];
				unset( $source[$value] );
			}
		}	
	}
	
	// Returns the associated file in the post array or ends execution if the variable is required and not present
	function Get( $postVariable, $required = true )
	{

		
		return str_replace( ';', '', $_POST[$postVariable]||!$required)?$_POST[$postVariable]:exit( ERROR_VARIABLE_NOT_FOUND . ": {$postVariable}" );

	}
	// Returns a database column header formatted
	function FormatColumn( $value )
	{
		return strtolower( $value );
	}
	
	// Returns a formatted object for API output
	function OutputFormatting( $value )
	{
		return json_encode( $value );
	}
?>
