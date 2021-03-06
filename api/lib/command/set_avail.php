<?php
//	set_avail.php: Sets the availibility entries for the user
//	$time_string: A timeString of the users availability
//	 EX: ----___---_--_
//	$user: The user who the timeString represents
//	Arthur Wuterich
//	9-18-13

DB_Connect();

$timeString = Get( 'time_string' );
$user = Get( 'user' );

$timeStringSize = strlen($timeString);
$VALUE_TO_DAY = GetValueDayArray();

// Get all of the times that the user is available
$availResult = DB_GetSingleArray( DB_Query( "SELECT RAW_TIME FROM USER_AVAILABILITY WHERE USER_ID={$user}" ) );
$deleteTime = array();

for( $i = 0; $i < $timeStringSize; $i++ )
{
	// Add availibility
	if($timeString[$i] == '-' )
	{
		$day = $VALUE_TO_DAY[floor($i/24)];
		$hour = $i%24;
		DB_Query( "INSERT INTO USER_AVAILABILITY (USER_ID,RAW_TIME,DAY,HOUR) VALUES ({$user},{$i},\"{$day}\",\"{$hour}\")" );
	}
	
	// Remove availability from the database is the user is available and
	// the timeString claims otherwise
	if($timeString[$i] == '_' && in_array( $i, $availResult ) )
	{
		$deleteTime[] = $i;
	}	
}

// Run the sql to remove all of the time entries. We do this to prevent
// running more querys than required
if( count($deleteTime) > 0 )
{
	// Form the composite OR clause
	$orClause = "";
	foreach( $deleteTime as $time )
	{
		// First insertion
		if( $orClause == "" )
		{
			$orClause .= " ( RAW_TIME = {$time}";
			continue;
		}
		
		// Multiple 
		$orClause .= " OR RAW_TIME = {$time}";
		
	}
	
	// Close off the time clause and formulate the sql
	$orClause .= ' )';
	
	$sql = "DELETE FROM USER_AVAILABILITY WHERE USER_ID = {$user} AND {$orClause} ";
	// Delete!
	DB_Query( $sql );
}

return( "1" );

?>
