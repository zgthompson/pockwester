<?php
//	login_user.php: Will return a positive value if the user/password combo is valid
//	Precondition: Requires that username and password field be defined
//	$username: The username to reference password against
//	$password: Password value to check
// 9-19-13
// Arthur Wuterich

DB_Connect();

$username = strtolower( Get( 'username' ) );
$password = md5( Get( 'password' ) );

// Find if user is in the database already
$users = DB_GetArray( DB_Query( "SELECT UID from USER where NAME = '{$username}' AND PASSWORD='{$password}' LIMIT 1" ) );

// If so error out
if( count($users) <= 0 )
{
	return( 'Could not locate the user account / password.' );
}

// Return the userid
return( $users[0][0] );
?>