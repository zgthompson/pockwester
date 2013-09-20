<?php
// add_to_group.php: Will add the user to the specified group. If the group does not exist then will create the group.
// Arthur Wuterich
// 9-18-13
//

$user_id = Get( 'user' );
$group_name = Get( 'group_name' );

DB_Connect();

// Get groups from db
$groups = DB_GetArray( DB_Query( 'SELECT NAME from GROUPS' ) );

$make_group = true;

// Search to see if the group has been created
foreach( $groups as $row )
{
	if( in_array( $group_name, $row ) )
	{
		$make_group = false;
	}
}

// Make the group
if( $make_group )
{
	DB_Query( "INSERT INTO GROUPS (NAME) VALUES (\"{$group_name}\")" );
}

// Get the group ID of the group

$group_id = DB_GetArray(DB_Query( "SELECT GID from GROUPS WHERE NAME=\"{$group_name}\"" ));

$group_id = $group_id[0][0];

// Add the user to the created group
DB_Query( "INSERT INTO USER_GROUP (USER_ID, GROUP_ID) VALUES (\"{$user_id}\", \"{$group_id}\")" );


// Output JSON object
exit( "1" );

?>