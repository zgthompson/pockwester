<?php
//	send_message.php: Will send a message to a user
//	$user_id: The id of the user.
//	$message: The message to send to the user
//	[$sender]: The user that has sent the message.
//	[$sender_id]: The id of the sender
// 10-10-2013
// Arthur Wuterich

DB_Connect();

$user_id = Get( 'user_id' );
$sender = Get( 'sender', false, '' );
$sender_id = Get( 'sender_id', false, 0 );
$message = htmlspecialchars( Get( 'message' ) );

// Make sure the user exists to send the message
$user = DB_GetSingleArray( DB_Query( "SELECT * FROM USER WHERE UID={$user_id}" ) );

// If the user was not found then exit
if( count( $user ) <= 0 )
{
	if( !isset( $user ) )
	{
		return "The user_id '{$user_id}' was not found";
	}
	return "The user '{$user}' was not found";
}

// If the sender id is present then try to get the name of the user
if( $sender_id != 0 )
{
	$sender_result = DB_GetSingleArray( DB_Query( "SELECT NAME FROM USER WHERE UID={$sender_id} LIMIT 1" ) );
		
	// There is a user with the uid = $sender, set to the name of the user
	if( count( $sender_result ) >= 0 )
	{
		$sender	= $sender_result[0];
	}
}

// Insert the new message into the database
DB_Query( "INSERT INTO USER_MESSAGE (USER_ID_RCV,USER_ID_SND,SENDER_NAME,MESSAGE) VALUES ({$user_id},{$sender_id},\"{$sender}\",\"{$message}\")" );

return '1';






































?>