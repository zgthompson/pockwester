<?php
// get_courses.php:	Command for the pockwester api
//					 -Returns the classes for provided campus
//					 -Precondition: Constants in api.php are defined 
// Arthur Wuterich
// 8-3-13
//

DB_Connect();

// Get classes from db
$qHandle = DB_Query( 'SELECT * from CLASS' );

$exclude = array( 'CLASS_ID', 'ADDED' );
$combine = array( 'DAYS' => 'TIME', 'COURSE_NUMBER' => 'SUBJECT' );
$rename = array( 'BUILDING' => 'LOCATION', 'SUBJECT' => 'COURSE_TYPE', 'CATALOG_NUMBER' => 'COURSE_NUMBER' );

$resultArray = array( 'courses' => array() );

// Build the assoc. array in memory
while( $row = DB_GetRow( $qHandle, true ) )
{
	// Format the array with key => value pairings
	$formattedArray = array();
	
	// Rename any fields that need to be converted
	foreach( $rename as $key => $value )
	{
		if( isset( $row[$key] ) )
		{
			$row[$value] = $row[$key];
			unset( $row[$key] );
		}
	}
	
	// Combine required fields	
	foreach( $combine as $key => $value )
	{
		if( isset( $row[$key] ) && isset( $row[$value] ) )
		{
			$row[$key] = $row[$key] . ' ' . $row[$value];
		}
	}
	
	// Build the formatted array
	foreach( $row as $key => $val )
	{
		// Only include elements that are not excluded
		if( !in_array( $key, $exclude ) )
		{
			$formattedArray[FormatColumn($key)] = $val;
		}
	}
	
	// Push into result array
	$resultArray['courses'][FormatColumn($row['CLASS_ID'])] = $formattedArray;
}

// Output JSON object
exit( OutputFormatting( $resultArray ) );

?>