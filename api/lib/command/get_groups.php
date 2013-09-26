<?php
//	get_groups.php: Returns the groups in the PWAPI. A user can be specified and will return all the groups that the user is a part of.
//  [$user]: Only return the groups that $user is a part of
// 9-19-2013
// Arthur Wuterich

$user = Get( 'user', false );

DB_Connect();

if( isset($user) )
{
	// Get groups from db that belong to user
	$groups = DB_GetArray( 
	DB_Query( "
	SELECT DISTINCT(g.NAME) 
	FROM USER as u, USER_GROUP as ug, GROUPS as g 
	WHERE u.UID = ug.USER_ID and ug.GROUP_ID = g.GID and u.UID = \"{$user}\"
	ORDER BY g.NAME" ) );
}
else
{
	// Get groups from db
	$groups = DB_GetArray( 
	DB_Query( '
	SELECT DISTINCT(g.NAME) 
	FROM GROUPS as g
	ORDER BY g.NAME' ) );
}

// Output JSON object
return( json_encode( $groups ) );

?>