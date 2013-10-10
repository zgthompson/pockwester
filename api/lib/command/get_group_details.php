<?php
//	get_group_details.php: Returns the details about a group
//	$group_name: The group name of the group to return details about
// 10-02-2013
// Arthur Wuterich

DB_Connect();

$group_name = Get( 'group_name' );

// Result array
$result = array();

// Get the number of people in the group
$members = DB_GetSingleArray( DB_Query( "SELECT COUNT(*) FROM USER_GROUP WHERE GROUP_ID = ( SELECT GID FROM GROUPS WHERE NAME = \"{$group_name}\" LIMIT 1)" ) );
$result['NUMBER_OF_MEMBERS'] = $members[0];

// Get any meeting times of the group
$meetingTimes = DB_GetSingleArray( 
DB_Query( "
SELECT RAW_TIME FROM GROUP_AVAILABILITY
WHERE GROUP_ID = ( SELECT GID FROM GROUPS WHERE NAME = \"{$group_name}\" LIMIT 1)" ) );

$result['MEETING_TIMES'] = $meetingTimes;

return OutputFormatting( $result );
?>
