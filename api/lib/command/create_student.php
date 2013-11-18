<?php
//	create_student.php: Creates a student who is not already present in the system
//	Precondition: Requires that username, password, and email be defined
//	$username: The username to attempt to register
//	$password: The password for the new user
//	$email: The email of the new user
// 10-24-13
// Zachary Thompson and Arthur Wuterich

DB_Connect();

$username = strtolower( Get( 'username' ) );
$password = md5( Get( 'password' ) );
$email = 	Get( 'email' );

// Find if user is in the database already
$users = DB_GetArray( 
    DB_Query( "SELECT * FROM student WHERE username='{$username}' OR email='{$email}'" ) );

// If so error out
if( count($users) > 0 )
{
	return( 'User or email already exists' );
}

// Make the user
DB_Query( "INSERT INTO student (username, password, email) VALUES ('{$username}','{$password}','{$email}')" );


// Get the number of the newly created user
$user_id = DB_GetSingleArray( DB_Query( "SELECT id FROM student WHERE username='{$username}' LIMIT 1" ) );
$user_id = $user_id[0];

// Send a message to the new user that they have created their account and need to setup their availability and classes
$post = array( 'user_id' => $user_id, 'message' => "Welcome to Pockwester! You should add your classes and start looking for study groups.");
PWTask( 'send_message', $post );

return( $user_id );

?>
