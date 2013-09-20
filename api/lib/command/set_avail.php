<?php
// set_avail.php: Sets the availibility entries for the user
// Arthur Wuterich
// 9-18-13
//

$timeString = Get( 'time_string' );
$user = Get( 'user' );

DB_Connect();

$timeStringSize = strlen($timeString);

// Get all of the times that the user is available
$availResult = DB_GetArray( DB_Query( "SELECT TIME FROM USER_AVAILABILITY WHERE USER_ID={$user}" ) );

$availArray = array();

foreach( $availResult as $row )
{
	$availArray[] = $row[0];
}

for( $i = 0; $i < $timeStringSize; $i++ )
{
	// Add availibility
	if($timeString[$i] == '-' )
	{
		DB_Query( "INSERT INTO USER_AVAILABILITY (USER_ID,TIME) VALUES ({$user},{$i})" );
	}
	
	// Remove availability from the database is the user is available and
	// the timeString claims otherwise
	if($timeString[$i] == '_' && in_array( $i, $availArray ) )
	{
		DB_Query( "DELETE FROM USER_AVAILABILITY WHERE USER_ID = {$user} AND TIME = {$i}" );
	}	
}

//$groups = DB_GetArray( DB_Query( "UPDATE USER SET AVAILABILITY = \"{$timeString}\" WHERE UID = \"{$user_id}\" " ) );

exit( "1" );

?>