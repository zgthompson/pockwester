<?php
//	login_user.php: Will return a positive value if the user/password combo is valid
//	Precondition: Requires that username and password field be defined
// 9-19-13
// Arthur Wuterich

$username = Get( 'username' );
$password = md5( Get( 'password' ) );

DB_Connect();

// Find if user is in the database already
$users = DB_GetArray( DB_Query( "SELECT * from USER where NAME = '{$username}' AND PASSWORD='{$password}'" ) );

// If so error out
if( count($users) <= 0 )
{
	exit( '-1' );
}
exit( '1' );
?>