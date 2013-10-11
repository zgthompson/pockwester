<?php
//	user_create.php: Creates a user is not already present in the system
//	Precondition: Requires that username, password, and email be defined
//	$username: The username to attempt to register
//	$password: The password for the new user
//	$email: The email of the new user
// 9-19-13
// Arthur Wuterich

DB_Connect();

$username = strtolower( Get( 'username' ) );
$password = md5( Get( 'password' ) );
$email = 	Get( 'email' );

// If any of the fields are empty then EndCommand
if( strlen($username)<=0 || strlen($password)<=0 || strlen($email)<=0 )
{
	return( 'Error creating user' );
}

// Find if user is in the database already
$users = DB_GetArray( DB_Query( "SELECT * from USER where NAME = '{$username}'" ) );

// If so error out
if( count($users) > 0 )
{
	return( 'User already exists' );
}

// Make the user
DB_Query( "INSERT INTO USER (NAME,PASSWORD,EMAIL) VALUES ('{$username}','{$password}','{$email}')" );


// Get the number of the newly created user
$user_id = DB_GetSingleArray( DB_Query( "SELECT UID FROM USER WHERE NAME=\"{$username}\" LIMIT 1" ) );
$user_id = $user_id[0];

// Insert a row into the user configuration database
DB_QUERY( "INSERT INTO USER_CONFIG (USER_ID) VALUES ({$user_id})" );

// Send a message to the new user
// Send a message to the user that they have left the group
$post = array( 'user_id' => $user_id, 'message' => "Welcome to Pockwester! You should add your classes and start looking for study groups.");
PWTask( 'send_message', $post );

return( '1' );

?>