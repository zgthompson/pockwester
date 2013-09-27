<?php

// set_user_group_flag.php: Will add the provided flags to the specified user's flags
//  $group_name: Name of the group
//  $user_id: ID of the user to alter
//  $bit_flag: Binary bit flag to set as new flag
//  [$combine]: Will or the bits if defined
//  [$remove]: Will and against not bit_flag to unset flags 
// 9/25/2013
// Arthur Wuterich

DB_Connect();

$group_name = Get( 'group_name' );
$user_id = Get( 'user_id' );
$bit_flag = intval(Get( 'bit_flag' ));
$combine = Get( 'combine', false );
$remove = Get( 'remove', false );

// Get the group_id for the group we are going to form
$groupId = DB_GetSingleArray( DB_Query( "SELECT GID FROM GROUPS WHERE NAME=\"{$group_name}\" LIMIT 1" ) );

// If there is no group of the provided name EndCommand
if( count( $groupId ) <= 0 )
{
	return( 'Group was not found' );
}

$groupId = $groupId[0];

// Find the user availability in the availability table
$userAvalDetails = DB_GetArray( DB_Query( "SELECT * FROM USER_GROUP WHERE USER_ID={$user_id} AND GROUP_ID={$groupId} LIMIT 1" ), true );

if( count( $userAvalDetails ) <= 0 )
{
	return( 'User is not part of specified group' );
}

// Update the time entry

// Combine flags if requested
if( $combine != '' )
{
	// Or the current flag with the new flag to get the combined key
	$bit_flag = $bit_flag|intval($userAvalDetails[0]['FLAGS']);
	
}
// Remove flags
elseif( $remove != '' )
{
	// And the flipped provided field with the current flag
	$bit_flag = (~$bit_flag)&intval($userAvalDetails[0]['FLAGS']);
}

// Set the flags
DB_Query( "UPDATE USER_GROUP SET FLAGS={$bit_flag} WHERE USER_ID={$user_id} AND GROUP_ID={$groupId}" );

return( '1' );































?>