<?php
//	remove_from_group.php: Will attempt to remove a user from a group
//	$user: User name to remove from group
//	$group_name: The group name to remove the user from
//	Arthur Wuterich
//	10-02-13
//

DB_Connect();

$user = Get( 'user' );
$group_name = Get( 'group_name' );

// Attempt to remove user from the group
print_r( DB_Query( "
DELETE FROM USER_GROUP 
WHERE USER_ID = ( SELECT UID FROM USER WHERE NAME = \"{$user}\") AND
GROUP_ID = ( SELECT GID FROM GROUPS WHERE NAME = \"{$group_name}\")" ));

return '1';

/*

// Get groups from db
$groups = DB_GetSingleArray( DB_Query( 'SELECT NAME from GROUPS' ) );

// Make the group if it has not been created yet
if( !in_array( $group_name, $row ) )
{
	DB_Query( "INSERT INTO GROUPS (NAME) VALUES (\"{$group_name}\")" );
}

// Get the group ID of the group

$group_id = DB_GetSingleArray(DB_Query( "SELECT GID from GROUPS WHERE NAME=\"{$group_name}\"" ));

$group_id = $group_id[0];

// Add the user to the created group
DB_Query( "INSERT INTO USER_GROUP (USER_ID, GROUP_ID, FLAGS) VALUES (\"{$user_id}\", \"{$group_id}\", ".USER_DEFAULT.")" );

// Output JSON object
return( "1" );
return;

*/

?>
