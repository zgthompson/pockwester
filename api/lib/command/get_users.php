<?php
//	get_users.php: Will return all of the users in a provided group
//  $group: Name of the group to pull the user names from
// 9/25/2013
// Arthur Wuterich

$group = Get( 'group' );

DB_Connect();

// Get the group id number
$groupId = DB_GetSingleArray( DB_Query( "SELECT GID FROM GROUPS WHERE NAME=\"{$group}\"" ) );

if( count( $groupId ) <= 0 )
{
	exit( 'Could not find group' );
}

$groupId = $groupId[0];

// Get all user numbers that are part of the group
$users = DB_GetSingleArray( DB_Query( "SELECT USER_ID FROM USER_GROUP WHERE GROUP_ID={$groupId}" ) );

// If there are no users exit empty array
if( count($users) <= 0 )
{
	return '[]';
}

// Get the names of each person in the group

// Compound where clause
$where = '';
foreach( $users as $user )
{
	if( $where != '' )
	{
		$where .= ' OR';
	}
	
	$where .= " UID={$user}";
}

// Get names where uid=uid
$names = DB_GetSingleArray( DB_Query( "SELECT NAME FROM USER WHERE {$where} ORDER BY NAME" ) );


exit( OutputFormatting( $names ) );





















?>