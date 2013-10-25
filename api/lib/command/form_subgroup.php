<?php

//	form_subgroup.php: Will attempt to form a subgroup out of the provided group. If this results in failure will return an error message, else will return the new group name
// $group_name: The group name for which a subgroup will be formed
// 9/24/2013
// Arthur Wuterich

DB_Connect();

$group_name = Get( 'group_name' );

// Get the group_id for the group we are going to form
$groupId = DB_GetSingleArray( DB_Query( "SELECT GID FROM GROUPS WHERE NAME=\"{$group_name}\" LIMIT 1" ) );

// If there is no group of the provided name EndCommand
if( count( $groupId ) <= 0 )
{
	return( 'Group was not found' );
	return;
}

$groupId = $groupId[0];

// Get all of the user_ids in the group we are forming a subgroup from 
// where the user flags signify they are looking for a group
$groupPeople = DB_GetSingleArray( DB_Query( "SELECT UID FROM USER, USER_GROUP WHERE UID = USER_ID AND GROUP_ID = {$groupId} AND FLAGS&".USER_LOOKING_FOR_GROUP."=".USER_LOOKING_FOR_GROUP  ) );
$peopleInGroup = count( $groupPeople );

// If there are no people in the group then EndCommand
if( $peopleInGroup <= 0 )
{
	return( 'Group was empty' );
}
elseif( $peopleInGroup <= 2 )
{
	return( 'There were not enough people to form a group' );
}

// Generate the compound where clause
$where = '';
foreach( $groupPeople as $userId )
{
	WhereAdd( $where, "USER_ID={$userId}", 'OR' );
}

// Get all of the availability and user_ids for all users in the group
$groupAvailability = DB_GetSingleArray( DB_Query( "SELECT RAW_TIME, USER_ID FROM USER_AVAILABILITY {$where}" ) );

// Create a mapping of availability times to frequency
$availabilityMap = array();

// Take each availability time and user to compute a mapping of availability times to user_ids
for( $i = 0; $i < count( $groupAvailability ); $i+=2 )
{
	// Create the array if not already created
	if( !is_array($availabilityMap[$groupAvailability[$i]]) )
	{
		$availabilityMap[$groupAvailability[$i]] = array();
	}
	
	// Added the user_id to the array at the timeslot
	$availabilityMap[$groupAvailability[$i]][] = $groupAvailability[$i+1];
}

// Prune off the groupings that do not meet the minimum number of students
foreach( $availabilityMap as $time => &$grp )
{
	if( count($grp) < MINIMUM_GROUP_SIZE )
	{
		unset( $availabilityMap[$time] );
	}
}

// If the availabilityMap is empty there was not 
// enough overlap between the availability of all of the students
if( count( $availabilityMap ) <= 0 )
{
	return( 'Meeting times are too restrictive to generate a complete group' );
}
die();
// If there is anything in the availabilityMap at this point there will be a group formed
// Operates on the availabilityMap until all group possibilitys are removed
while( count( $availabilityMap ) > 0 )
{
	// Generate the new group name *** REFACTOR SILLY CODE! ***
	$newGroupName = '+' . $group_name . (time()%1000);

	// Create the new group
	DB_Query( "INSERT INTO GROUPS (NAME) VALUES (\"{$newGroupName}\")" );

	// Get the newly generated groups id
	$newGroupID = DB_GetSingleArray( DB_Query( "SELECT GID FROM GROUPS WHERE NAME=\"{$newGroupName}\" LIMIT 1" ) );
	$newGroupID = $newGroupID[0];
	
	// Get the meeting time. This returns the first key value in the array
	reset($availabilityMap);
	$meetingTime = key($array);
	
	// Get an array of each student serviced in this iteration, add each one to the new group,
	// and unset their lfg flag in their old group
	$servicedUsers = array();
	foreach( $availabilityMap[$meetingTime] as $user_id )
	{
		$servicedUsers[] = $user_id;
		
		// Add to new group
		DB_Query( "INSERT INTO USER_GROUP (USER_ID,GROUP_ID,FLAGS) VALUES ({$user_id},{$newGroupID},".USER_DEFAULT.")" );		
		
		// Remove lfg flag from old group
		$post = array( 'user_id' => $user_id, 'group_name' => $group_name, 'bit_flag' => 1, 'remove' => 1);
		PWTask('set_user_group_flag', $post);		
	}
		
	// Insert the meeting time into the group_availability table for the newly created group
	DB_Query( "INSERT INTO GROUP_AVAILABILITY (GROUP_ID,RAW_TIME) VALUES ({$newGroupID},{$meetingTime})" );	
	
	// Remove any availabilityTimes that have any of the servicedUsers contained
	
	// Prune off the groupings that do not meet the minimum number of students
	foreach( $availabilityMap as $time => &$grp )
	{
		// Check each user serviced
		foreach( $servicedUsers as $user_id )
		{
			// If the availability array contains that user_id then
			// remove it
			if( in_array( $user_id, $grp ) )
			{
				unset( $availabilityMap[$time] );
				break;
			}
		}
	}
}


/*
// Generate the new group name *** REFACTOR SILLY CODE! ***
$newGroupName = '+' . $group_name . (time()%1000);

// Create the new group
DB_Query( "INSERT INTO GROUPS (NAME) VALUES (\"{$newGroupName}\")" );

// Get the newly generated groups id
$newGroupID = DB_GetSingleArray( DB_Query( "SELECT GID FROM GROUPS WHERE NAME=\"{$newGroupName}\" LIMIT 1" ) );

// If the new group_id is not found then EndCommand
if( count( $newGroupID ) <= 0 )
{
	return( 'Could not generate dynamic group' );
}

$newGroupID = $newGroupID[0];

// Insert the meeting time into the group_availability table for the newly created group
DB_Query( "INSERT INTO GROUP_AVAILABILITY (GROUP_ID,RAW_TIME) VALUES ({$newGroupID},{$meetingTime})" );

// Add each user to the new group
// Unset the lfg flag for each user added in this manner
foreach( $groupPeople as $userId )
{
	DB_Query( "INSERT INTO USER_GROUP (USER_ID,GROUP_ID,FLAGS) VALUES ({$userId},{$newGroupID},".USER_DEFAULT.")" );
	$post = array( 'user_id' => $userId, 'group_name' => $group_name, 'bit_flag' => 1, 'remove' => 1);
	PWTask('set_user_group_flag', $post);
}
*/

return( 1 );





























?>
