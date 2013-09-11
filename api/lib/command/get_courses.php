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

// Formatting arrays for results
$exclude = array( 'ADDED' );
$combine = array( 'TIME' => 'DAYS', 'COURSE_NUMBER' => 'SUBJECT' );
$rename = array( 'BUILDING' => 'LOCATION', 'SUBJECT' => 'COURSE_TYPE', 'CATALOG_NUMBER' => 'COURSE_NUMBER', 'CLASS_ID' => 'COURSE_ID' );

$resultArray = array( 'courses' => array() );

// Build the assoc. array in memory
while( $row = DB_GetRow( $qHandle, true ) )
{

	// Rename any fields that need to be converted
	RenameKeys( $row, $rename );
	
	// Combine required fields	
	CombineKeys( $row, $combine );
		
	// Push into result array
	$resultArray['courses'][] = FormatRow( $row, $exclude );
}

// Output JSON object
exit( OutputFormatting( $resultArray ) );

?>