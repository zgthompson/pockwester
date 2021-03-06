<?php
//	pw.functions.php: Global functions for use in pw web interface
//	9-17-13
//	Arthur Wuterich

// Directly include the cfg file if not already loaded
require_once( 'lib/pw.cfg.php' );

// Returns true if the page is a valid source file
// Precondition: $page is a valid string and the pw.cfg.php file has been included
function IsPageValid( $page )
{
	global $VALID_SOURCE_FILES;
	return in_array( $page, $VALID_SOURCE_FILES );
}

// Returns true if the page is in the public files array
// Precondition $page is a valid string and pw.cfg.php is included
function IsPagePublic( $page )
{
	global $PUBLIC_SOURCE_FILES;
	return in_array( $page, $PUBLIC_SOURCE_FILES );
}

// Returns true if the username, password, and email meets the standard for user na`me, password, and email
function MeetsUserStandard( $username, $email, $password )
{
	if( preg_match( "/[\ \`\~\#\$\^\&\(\)\+\{\}\:\"\<\>\-\=\[\]\\\;\'\,\/\|]/", $username.$email.$password ) )
	{
		return 'You can only use special symbols ! @ % * ? . _ ';
	}
	
	if( strlen($username) <= 0 || strlen($email) <= 0 || strlen($password) <= 0 )
	{
		return 'You need to fill out each field';
	}
	
	if( strlen( $password ) < 3 || strlen( $username ) < 3 )
	{
		if( strlen( $password ) < 3 )
		{
			return 'Passwords need to be greater than length 3';
		}
		return 'Usernames need to be greater than length 3';
	}
	
	if( !strpos( $email, '@' ) || !strpos( $email, '.' ) )
	{
		return 'Invalid email';
	}
	
	return '1';
}

// Displays the content page provided. Returns true if the operation was suscessful
// Precondtion: Assumes that $page is a valid content page and pw.cfg.php has been included
// Postcondition: $page php will be executed and html displayed
function GetPage( $page )
{
	// Find out if the page exists
	$path = SRC_PATH . $page;
	
	// If the file is not there exit
	if( !is_readable( $path ) )
	{
		return false;
	}
		
	// Body content
	include $path;

	return true;
}

// Runs a PWAPI task
// Precondition: Valid PWAPI task, and API url is defined in pw.cfg.php
//  $post: Post array that will be built and sent with the api request
function PWTask( $apiTask, $post = array() )
{

	// Add the apiTask to the post array as well as the apikey
	$post['apitask'] = $apiTask;
	$post['apikey'] = $_SERVER['API_APIKEY'];
	$post['ip'] = $_SERVER['REMOTE_ADDR'];
	
	// Open url link
	$link = curl_init();
	
	// Options
	curl_setopt($link, CURLOPT_URL, PWAPI_URL);
	curl_setopt($link, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($link, CURLOPT_CONNECTTIMEOUT, PWAPI_TIMEOUT);
	

	curl_setopt($link, CURLOPT_POSTFIELDS, $post);
	
	// Get the data
	$data = curl_exec($link);
	
	// Be nice and clean up
	curl_close($link);
	
	return $data;
}

// Returns the timevalue representation of a timeblock, 
//	this will return an array with 2n elements where the format is followed:
//															[ START1, END1, START2, END2, ..., START{n}, END{n} ]
// Precondition: Provided time is in '<DAY/S> <START_TIME>-<END_TIME>' format and pw.cfg.php defined
//  $minutes: Rounds each element in the array to force granularity to hours
//  $offset: Integer offset if required
function GetTimeValue( $time, $minutes=false, $offset=0.0 )
{
	// Mapping for day to values
	$DAY_VALUE = GetDayValueArray();
	$VALUE_DAY = GetValueDayArray();
	
	$result = array();
		
	// Seperate the days from the hours
	// -Uppercase $time to prevent case issues
	$course_components = explode( ' ', strtoupper($time) );
	
	// Remove empty first element(s) if present
	while( strlen($course_components[0]) <= 0 )
	{
		array_shift( $course_components );
	}
		
	// Pre-Termination conditions
	if( $time == '' || count( $course_components ) <= 1 )
	{
		return $result;
	}
	
	// Break apart days and add 2 elements per day *** REFACTOR ***
	while( strlen( $course_components[0] ) > 0 )
	{
		if( $course_components[0] != ' ' )
		{
			$result[] = $DAY_VALUE[$course_components[0][0]]*24;
			$result[] = $DAY_VALUE[$course_components[0][0]]*24;
		}
		
		// Break out if the day subcomponent is only 1 char long
		if( !$course_components[0] = substr( $course_components[0], 1 ) )
		{
			$course_components[0] = '';
			break;
		}
	}
	
	// Now we have an array with each day represented by their 24hr offsets
	// We need to get the start and end offsets and add each to the array respectivly
	
	// Get both of the time components
	$time_components = explode( '-', $course_components[1] );
	$offset_value = array();
	
	// Take the two time components and break apart into offsets
	for( $i = 0; $i < 2; $i++ )
	{
		// AM/PM?
		$pm = $time_components[$i][5] == 'P';
		
		// Hour, Min components
		$hour = floatval(substr( $time_components[$i], 0, 2 ));
		$mins = floatval(substr( $time_components[$i], 3, 2 ));
		
		// Compute each offset
		$offset_value[] = $hour + $mins/60 + (($pm && $hour < 12.0)?12:0) + $offset;
	}
		
	// Apply the offset array to the entire result array
	for( $i = 0; $i < count($result); $i+=2 )
	{
		$result[$i]   += $offset_value[0];
		$result[$i+1] += $offset_value[1];
	}
	
	// Round each element if omiting minutes
	if( !$minutes )
	{
		foreach( $result as &$val )
		{
			$val = round( $val );
		}
	}
	
	return $result;
}

// Converts a TimeValue into its weekly associated string 
// Precondition: A value TimeValue[0-167]
//  $day: Include day in string
function ConvertTimeValue( $timeValue, $day = false )
{
	$VALUE_DAY = GetValueDayArray();
	
	$dayKey = floor(($timeValue%168) / 24.0 );
	$day = $VALUE_DAY[$dayKey];
	$time = $timeValue%24.0;
	if($day)
	{
		return "{$time}";
	}
	else
	{
		return "{$day}, {$time}";
	}
	
}

// Converts military time into standard time and returns a string representing the time
// Precondition: A valid time value [0-23]
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

// Retirns a div with a message surrounded by a div
// if the message exists
function Message( $msg, $class = 'green_box' )
{
	if( !isset($msg) || strlen($msg) <= 0 )
	{
		return '';
	}
	
	return "<div class=\"{$class}\">{$msg}</div>";	
}

// Formats the current page title into a more human readable format
function GetTitle()
{
	// If the current page is not set then exit
	if( !isset($_SESSION['CURRENT_PAGE']))
	{
		return '';
	}

	$title = strtolower( $_SESSION['CURRENT_PAGE'] );
	$title = str_replace( '.php', '', $title );
	$title = str_replace( '_', ' ', $title );
	$title = ucwords( $title );
	
	return $title;
}

// Will return a "<Day> <Time>" for each valid position in a week
// Precondition: An integer that represents the hour of the week
function GetDayHourString( $hour )
{
	// Exit if the value is not numeric
	if( !is_numeric($hour) )
	{
		return '';
	}
	
	// Build the string components
	$VALUE_DAY = array( 0 => 'Monday',1 => 'Tuesday',2 => 'Wednesday',3 => 'Thursday',4 => 'Friday',5 => 'Saturday',6 => 'Sunday');
	$day = $VALUE_DAY[ floor($hour/24) ];
	$hour = ConvertMilitary( $hour % 24 );
	
	return "{$day} {$hour}";
	
}

// Returns the theme name
function GetThemeName( $data = '' )
{
	// If the data is not set then pull the current theme
	if( $data == '' )
	{
		$data = $_SESSION['THEME'];
	}
	
	// Get the 2nd to last element in the array to drop the .css part
	$comp = explode( '.', $data );
	$name = $comp[count($comp)-2];
	
	// Return the uppercase value
	return ucwords($name);
}

// Returns an select option
function GetOption( $value, $text = '' )
{
	if( $value == '' )
	{
		return '';
	}
	
	if( $text == '' )
	{
		$text = $value;
	}
	
	return "<option value={$value}>{$text}</option>";
}

// Returns a formatted array of themes
// Precondtion: Expects an array of filename strings from the api/lib/commands/ dir
// Postcondition: A formated array of pwapi commands that can be executed
function GetThemeArray( $cmds )
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
		if( strend( $cmd, '.css' ) !== false )
		{
			// Format the .php off of commands that do end with .php			
			$result[] = str_replace( '.php', '', $cmd );
		}
	}
	
	return $result;
}

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
























?>
