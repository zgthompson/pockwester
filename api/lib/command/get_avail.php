<?php
// get_avail.php: Returns the avail of a student in a timeString
//	 $user: The user_id of the user to pull availability of
//  [$db]: If set will return the time directly from the database
// Arthur Wuterich
// 9-19-13
//

DB_Connect();

$user = Get( 'user' );
$db = Get( 'db', false );

// Get all of the times that the user is available
$availResult = DB_GetSingleArray( DB_Query( "SELECT RAW_TIME FROM USER_AVAILABILITY WHERE USER_ID={$user}" ) );

// If db flag is set then return the results from the database
if( $db != '' )
{
	return( OutputFormatting( $availResult ) );
}

// Make default timeString that has no avail
$timeString = MakeTimeString( '_' );

// Change the timeString based on what is in the users avail
foreach( $availResult as $time )
{
	AlterTimeString( $timeString, floor($time/24), $time%24, '-' );
}

return( $timeString );

?>