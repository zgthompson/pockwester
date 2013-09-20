<?php
//	login_user.php: Will return a positive value if the user/password combo is valid
//	Precondition: Requires that username and password field be defined
// 9-19-13
// Arthur Wuterich

$username = Get( 'username' );
$password = md5( Get( 'password' ) );

DB_Connect();

// Find if user is in the database already
$users = DB_GetArray( DB_Query( "SELECT UID from USER where NAME = '{$username}' AND PASSWORD='{$password}' LIMIT 1" ) );

// If so error out
if( count($users) <= 0 )
{
	exit( 'Could not locate the user account.' );
}

// Return the userid
exit( $users[0][0] );
?>