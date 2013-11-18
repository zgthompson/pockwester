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
	// $recursive: Will run this command on each array element
	// Precondition: Both $source and $rename are both arrays
	function RenameKeys( &$source, &$rename, $recursive = true )
	{
		// Exit conditions
		if( !is_array( $source ) || !is_array( $rename ) )
		{
			return;
		}
		
		// Execute this command on each member if recursive
		if( $recursive )
		{
			foreach( $source as &$value )
			{
				if( is_array( $value ) )
				{
					RenameKeys( $value, $rename, $recursive );
				}
			}
		}
		
		// Rename any fields that need to be converted
		foreach( $rename as $key => &$value )
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
	// $recursive: Will run this command on each array element	
	// Precondition: Both $source and $combine are both arrays	
	function CombineKeys( &$source, &$combine, $recursive = true, $delimit = ' ' )
	{
		// Exit conditions
		if( !is_array( $source ) || !is_array( $combine ) )
		{
			return;
		}
		
		// If recursive run this on each element that is an array in source
		if( $recursive )
		{
			foreach( $source as &$value )
			{
				if( is_array( $value ) )
				{
					CombineKeys( $value, $combine, $recursive, $delimit );
				}
			}
		}
		
		// Combine required fields	
		foreach( $combine as $key => &$value )
		{		
			if( isset( $source[$key] ) && isset( $source[$value] ) )
			{
				$source[$key] = $source[$key] . $delimit . $source[$value];
				unset( $source[$value] );
			}
		}	
	}
	
	// Combines elements from the $source assoc array based on the $rename array
	// $combine: Is expected to be a assoc array which represents <field to keep> => <field to combine>
	// $delimit: What will be placed in between the two elements on concatenation
	// $recursive: Will run this command on each array element	
	// Precondition: Both $source and $combine are both arrays	
	function RemoveKeys( &$source, &$remove, $recursive = true )
	{
		// Exit conditions
		if( !is_array( $source ) || !is_array( $remove ) )
		{
			return;
		}
		
		// If recursive run this on each element that is an array in source
		if( $recursive )
		{
			foreach( $source as &$value )
			{
				if( is_array( $value ) )
				{
					RemoveKeys( $value, $remove, $recursive );
				}
			}
		}
		
		// Combine required fields	
		foreach( $remove as $key )
		{		
			if( isset( $source[$key] ) )
			{
				unset( $source[$key] );
			}
		}	
	}
	
	// Makes a new key based on each element in the make array. This will create the field for each key of make taking each found member of the parent array as the data
	// $make: Is expected to be a assoc array which represents <new_field> => <array,parent,fields,names>
	// $delimit: What will be placed in between the two elements on concatenation
	// $recursive: Will run this command on each array element	
	// Precondition: Both $source and $combine are both arrays	
	function MakeKeys( &$source, &$make, $recursive = true, $delimit = ' ' )
	{
		// Exit conditions
		if( !is_array( $source ) || !is_array( $make ) )
		{
			return;
		}
		
		// If recursive run this on each element that is an array in source
		if( $recursive )
		{
			foreach( $source as &$value )
			{
				if( is_array( $value ) )
				{
					MakeKeys( $value, $make, $recursive, $delimit );
				}
			}
		}
		
		// Create the new fields
		foreach( $make as $key => &$value )
		{
			$new_field = '';
			
			// Search the parent array for each element
			foreach( $value as $parent_key )
			{
					if( isset( $source[$parent_key] ) )
					{
						if( $new_field != '' ){ $new_field .= $delimit; }
						
						$new_field .= $source[$parent_key];
					}
			}
			
			//echo $new_field;
			
			// If the parent elements were found then add the new member
			if( $new_field != '' )
			{
				$source[$key] = $new_field;
			}
		}	
	}		
	
	// Returns an empty string time array
	function MakeTimeString( $char = ' ', $length = AVAL_LENGTH )
	{
		return str_repeat( $char, $length );
	}
	
	// Will alter a timestring at the day and hour position to $value
	// &$timeString: Valid timestring to be processed
	// $day:   Day of the week [0-6]
	// $hour:  Hour of the day [0-23]
	// $value: The value to sed the element to
	function AlterTimeString( &$timeString, $day, $hour, $value )
	{
		$pos = ($day%7) * 24 + ($hour%24);
		$timeString[$pos] = $value;
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
	
	// Returns a number to day string array
	function GetValueDayArray()
	{
		return array( 0 => 'Monday',1 => 'Tuesday',2 => 'Wednesday',3 => 'Thursday',4 => 'Friday',5 => 'Saturday',6 => 'Sunday');
	}

	// Returns a day to number string array
	function GetDayValueArray()
	{
		return array( 'M' => 0,'T' => 1,'W' => 2,'R' => 3,'F' => 4,'S' => 5,'U' => 6);
	}
	
	// Formats an assoc array's keys to lowercase
	// Precondition: A valid array object
	// [$recursive]: Will perform operation on every assoc array in array
	// [$format]: Function that will be called on each key of the array
	function FormatAssocKeys( &$assoc_array, $recursive = true, $format = 'FormatColumn' )
	{
		
		// Exit conditions
		if( !is_array( $assoc_array ) || count( $assoc_array ) <= 0 || ( !is_callable( $format ) && !function_exists( $format ) ) )
		{
			return false;
		}
		
		// Perform operation on each key
		foreach( $assoc_array as $key => &$value )
		{
			// If recursive then call on each array value
			if( $recursive && is_array( $value ) )
			{
				FormatAssocKeys( $value, $recursive, $format );
			}
			
			$formatted_key = $format($key);
			
			//echo "{$key},{$value}<BR/>";
			// Only format the array if there is a difference in the key value
			if( $formatted_key != $key )
			{
				$assoc_array[$formatted_key] = $value;
				unset($assoc_array[$key]);
			}
		}
		
		return true;
	}
	
	// Will execute internal PWApi command. This will alter the current post array to simulate calling the function as an individual entity
	// Precondition: A valid PWTask string
	// [$post]: New array of data for the command to use for processing
	function PWTask( $command, $post = array() )
	{
		// Save the old post array if needed
		$oldPost = $_POST;
		if( count( $post ) > 0 )
		{
			$_POST = $post;
		}
		
		// Execute the command if the command exists
		if( is_readable( LIB_PATH . CMD_PATH . $command . '.php' ) )
		{
			$result = include( LIB_PATH . CMD_PATH . $command . '.php' );
		}
		else
		{
			$result = '';
		}
		
		// Reset the post array
		$_POST = $oldPost;
		
		// Return the result
		return $result;
	}
	
	// Returns an addition to a where clause
	// Precondition: An empty string to start building the where clause or an
	//				 in process where string
	//  $new: The new boolean condition
	//  [$delimit]: The string to put in between the boolean conditions
	function WhereAdd( &$where, $new, $delimit = 'AND' )
	{
		// If the addition is empty then exit without any changes
		if( isset($new) && strlen($new) <= 0 )
		{
			return;
		}
	
		// If the string is not empty append a delimiter
		if( strlen( $where ) > 0 )
		{
			$where .= " {$delimit} ";
		}
		
		// If ther where clause is empty start the where statement
		if( strlen( $where ) <= 0 )
		{
			$where .= " WHERE";
		}
		
		// Add the new condition
		$where .= " {$new}";
	}
	
    // Updates the availability string to unset any $old_codes and set all the $cur_codes
	function UpdateAvailString ( &$avail_string, $cur_codes, $old_codes )
    {
        if ( isset($old_codes) ) {
            foreach ($old_codes as $time_code) {
                $i = intval($time_code);
                // if you were unavailable, now you are unset
                if ($avail_string[$i] == '0') {
                    $avail_string[$i] = '1';
                }
            }
        }

        foreach ($cur_codes as $time_code) {
            $i = intval($time_code);
            // all these are class times, so you are unavailable
            $avail_string[$i] = '0';
        }
    }

    // returns an array of time codes where student is available
    function GetTimeCodes( $avail_string )
    {
        $time_codes = array();

        for ($i = 0; $i < 168; $i++) {
            if ($avail_string[$i] == 2) {
                $time_codes[] = $i;
            }
        }

        return $time_codes;
    }


// Converts military time into standard time and returns a string representing the time
function ConvertMilitary( $time )
{
	if( $time >= 12.0 )
	{
		if($time >= 13.0 )
		{
			$time-=12.0;
		}
		
		return "{$time}PM";
	}
	
	return "{$time}AM";
}
?>
