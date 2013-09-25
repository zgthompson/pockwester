<?php

//	form_subgroup.php: Will attempt to form a subgroup out of the provided group. If this results in failure will return an error message, else will return the new group name
// $group_name: The group name for which a subgroup will be formed
// 9/24/2013
// Arthur Wuterich


$group_name = Get( 'group_name' );

DB_Connect();

// Get the group_id for the group we are going to form
$groupId = DB_GetSingleArray( DB_Query( "SELECT GID FROM GROUPS WHERE NAME=\"{$group_name}\" LIMIT 1" ) );

// If there is no group of the provided name exit
if( count( $groupId ) <= 0 )
{
	exit( 'Group was not found' );
}

$groupId = $groupId[0];

//Get all of the user_ids in the group we are forming a subgroup from
$groupPeople = DB_GetSingleArray( DB_Query( "SELECT UID FROM USER, USER_GROUP WHERE UID = USER_ID AND GROUP_ID = {$groupId}" ) );
$peopleInGroup = count( $groupPeople );

// If there are no people in the group then exit
if( $peopleInGroup <= 0 )
{
	exit( 'Group was empty' );
}

// Generate the compound where clause
$where = '';
foreach( $groupPeople as $userId )
{
	if( $where != '' )
	{
		$where .= ' AND';
	}
	
	$where .= " USER_ID={$userId}";
}

// Get all of the availability for all users in the group
$groupAvailability = DB_GetSingleArray( DB_Query( "SELECT RAW_TIME FROM USER_AVAILABILITY WHERE {$where}" ) );

// Create a mapping of availability times to frequency
$availabilityMap = array();

// Take each availability time and count based on the time
foreach( $groupAvailability as $availability_time );
{
	$availabilityMap[$availability_time]++;
}

// Now all we have to do if find any value in the map that is
// equal to the amount of users in the group and we have a compatible time
$meetingTime = '';
foreach( $availabilityMap as $key => $value )
{
	if( $value >= $peopleInGroup )
	{
		//Match!
		$meetingTime = $key;
		break;
	}
}

// If there is a no meeting time then the students availability is too restrictive
if( $meetingTime == '' )
{
	exit( 'Meeting times are too restrictive to generate a complete group' );
}

// Generate the new group name *** REFACTOR SILLY CODE! ***
$newGroupName = '+' . $group_name . (time()%1000);

// Create the new group
DB_Query( "INSERT INTO GROUPS (NAME) VALUES (\"{$newGroupName}\")" );

// Get the newly generated groups id
$newGroupID = DB_GetSingleArray( DB_Query( "SELECT GID FROM GROUPS WHERE NAME=\"{$newGroupName}\" LIMIT 1" ) );

// If the new group_id is not found then exit
if( count( $newGroupID ) <= 0 )
{
	exit( 'Could not generate dynamic group' );
}

$newGroupID = $newGroupID[0];

// Insert the meeting time into the group_availability table for the newly created group
DB_Query( "INSERT INTO GROUP_AVAILABILITY (GROUP_ID) VALUES ({$newGroupID})" );

// Add each user to the new group
foreach( $groupPeople as $userId )
{
	DB_Query( "INSERT INTO USER_GROUP (USER_ID,GROUP_ID) VALUES ({$userId},{$newGroupID})" );
}

exit( $newGroupName );





























?>