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

// Returns true if the username, password, and email meets the standards for users
function MeetsStandards( $username, $email, $password )
{
	if( !isset($username) || !isset($email) || !isset($password) )
	{
		return false;
	}
	
	if( strlen( $password ) < 3 || strlen( $username ) < 3 )
	{
		return false;
	}
	
	if( !strpos( $email, '@' ) || !strpos( $email, '.' ) )
	{
		return false;
	}
	
	return true;
}

// Displays the content page provided
// Precondtion: Assumes that $page is a valid content page and pw.cfg.php has been included
// Postcondition: $page php will be executed and html displayed
function GetPage( $page )
{
	// Header information
	echo DOC_TYPE, '<html>', GLOBAL_HEAD, '<body>';
	
	// Body content
	include SRC_PATH . $page;
	
	// Closing tags
	echo '</body>', '</html>';
}

// Runs a PWAPI task
// Precondition: Valid PWAPI task, and API url is defined in pw.cfg.php
//  $post: Post array that will be built and sent with the api request
function PWTask( $apiTask, $post = array() )
{

	// Add the apiTask to the post array as well as the apikey
	$post['apitask'] = $apiTask;
	$post['apikey'] = $_SERVER['API_APIKEY'];
	
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
	global $DAY_VALUE;
	
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
	global $VALUE_DAY;
	
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

// Returns a html schedule outline
// Precondition: Requires a valid schedule array with TimeValue objects
function FormatSchedule( $times )
{
	global $VALUE_DAY;
	
	// Collect information based on day
	$schedule = array
	(
		0 => '',
		1 => '',
		2 => '',
		3 => '',
		4 => '',
		5 => '',
		6 => ''
	);
	
	// For each time block, add to the day that time block belongs to
	foreach( $times as $time_block )
	{
		$key = floor($time_block[0]/24.0)%168;
		$begin = ConvertMilitary(ConvertTimeValue($time_block[0]));
		$end = ConvertMilitary(ConvertTimeValue($time_block[1]));
		
		// Add commas if needed
		if( $schedule[$key] != '' )
		{
			$schedule[$key] .= ', ';
		}
		
		$schedule[$key] .= "{$begin}-{$end}";
	}
		
	// Format the schedule
	$format_schedule = '';
	foreach( $schedule as $key => $day_block )
	{
		$format_schedule .= "<day_block><day>{$VALUE_DAY[$key]}</day>:<BR/><time_value>{$day_block}</time_value></day_block><BR/>";
	}
	
	return $format_schedule;
	
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






























?>