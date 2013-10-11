<?php
//	add_to_group.php: Will add the user to the specified group. If the group does not exist then will create the group.
//	$user_id: User ID to add to group
//	$group_name: The group name to add the user too
//	Arthur Wuterich
//	9-18-13
//

DB_Connect();

$user_id = Get( 'user' );
$group_name = Get( 'group_name' );

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

// Send a message to the user that they have joined the group
$post = array( 'user_id' => $user_id, 'message' => "You have joined the group {$group_name}");
PWTask( 'send_message', $post );


// Output JSON object
return( "1" );

?>