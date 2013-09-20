<?php
// get_courses.php:	Pulls the course information from database, formats for android client, and returns the results
//					 -Returns the classes for provided campus
//					 -Precondition: Constants in api.cfg.php are defined
//					 -$last_upate: Will filter results based on the provided unix timestamp
// Arthur Wuterich
// 8-3-13
//

DB_Connect();

// Get the provided date if available 
$last_update = get( 'last_update', false );

// If we have the last update time filter the query based on the time provided
if( isset($last_update) && is_numeric($last_update) )
{
	// Get classes from db where the class updated field is greater than the provided field
	$qHandle = DB_Query( "SELECT * from CLASS where {$last_update} < unix_timestamp(UPDATED)" );
}
else
{
	// Get classes from db
	$qHandle = DB_Query( 'SELECT * from CLASS' );
}

// Formatting arrays for results
$exclude = array( 'UPDATED' );
$combine = array( 'DAYS' => 'TIME', 'SUBJECT' => 'CATALOG_NUMBER' );
$rename = array( 'BUILDING' => 'LOCATION', 'CATALOG_NUMBER' => 'COURSE_NUMBER',
		 'CLASS_ID' => 'COURSE_ID', 'DAYS' => 'TIME', 'SUBJECT' => 'COURSE_NUMBER',
		 'TYPE' => 'COURSE_TYPE' );

$resultArray = array( 'courses' => array() );

// Build the assoc. array in memory
while( $row = DB_GetRow( $qHandle, true ) )
{
	
	// Combine required fields	
	CombineKeys( $row, $combine );
	
	// Rename any fields that need to be converted
	RenameKeys( $row, $rename );	
		
	// Push into result array
	$resultArray['courses'][] = FormatRow( $row, $exclude );
}

// Output JSON object
exit( OutputFormatting( $resultArray ) );

?>
