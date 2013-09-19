<?php
//	user_create.php: Creates a user is not already present in the system
//	Precondition: Requires that username, password, and email be defined
// 9-19-13
// Arthur Wuterich

$username = Get( 'username' );
$password = md5( Get( 'password' ) );
$email = 	Get( 'email' );


DB_Connect();

// Find if user is in the database already
$users = DB_GetArray( DB_Query( "SELECT * from USER where NAME = '{$username}'" ) );

// If so error out
if( count($users) > 0 )
{
	exit( 'User already exist' );
}

// Make the user
DB_Query( "INSERT INTO USER (NAME,PASSWORD,EMAIL) VALUES ('{$username}','{$password}','{$email}')" );
exit( '1' );

?>