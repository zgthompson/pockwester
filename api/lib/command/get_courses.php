<?php
// get_courses.php:	Pulls the course information from database, formats for android client, and returns the results
//					 -Returns the classes for provided campus
//					 -Precondition: Constants in api.php are defined 
// Arthur Wuterich
// 8-3-13
//

DB_Connect();

// Get classes from db
$qHandle = DB_Query( 'SELECT * from CLASS limit 1' );

// Formatting arrays for results
$exclude = array( 'ADDED' );
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