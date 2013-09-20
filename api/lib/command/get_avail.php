<?php
// get_avail.php: Returns the avail of a student in a timeString
// 	$user: The userid of the user
//  [$db]: If defined will return the database entries 
// Arthur Wuterich
// 9-19-13
//

$user = Get( 'user' );
$db = Get( 'db' );

DB_Connect();

// Get all of the times that the user is available
$availResult = DB_GetSingleArray( DB_Query( "SELECT TIME FROM USER_AVAILABILITY WHERE USER_ID={$user}" ) );

// Make default timeString that has no avail
$timeString = MakeTimeString( '_' );

foreach( $availResult as $time )
{
	AlterTimeString( $timeString, floor($time/24), $time%24, '-' );
}

exit( $timeString );

?>