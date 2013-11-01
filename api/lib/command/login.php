<?php
//	login.php: Will return user id if the user/password combo is valid
//	Precondition: Requires that username and password field be defined
//	$username: The username to reference password against
//	$password: Password value to check
// 10-24-13
// Arthur Wuterich and Zachary Thompson

DB_Connect();

$username = strtolower( Get( 'username', true ) );
$password = md5( Get( 'password', true ) );

// Find if user is in the database already
$users = DB_GetArray( 
    DB_Query( "SELECT id FROM student WHERE username='{$username}' AND password='{$password}' LIMIT 1" ) );

// If not error out
if( count($users) <= 0 )
{
	return( 'Invalid username/password combo' );
}

// Return the user id
return( $users[0][0] );
?>
