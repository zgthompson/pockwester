<?php
//	send_message.php: Will send a message to a user or group. Either $user_id or $group_id needs to be set
//	$user_id: The id of the user.
//	$group_id: The id of the group.
//	$message: The message to send to the user
//	[$sender]: The user that has sent the message.
//	[$sender_id]: The id of the sender
// 10-10-2013
// Arthur Wuterich

DB_Connect();

$message = htmlspecialchars( Get( 'message' ) );

$group_id = Get( 'group_id', false );
$user_id = Get( 'user_id', false );

if( !isset($group_id) && !isset($user_id) )
{
	return 'Either group_id or user_id needs to be set';
}

$sender = Get( 'sender', false, '' );
$sender_id = Get( 'sender_id', false, 0 );

// If the sender id is present then try to get the name of the user
if( $sender_id != 0 )
{
	$sender_result = DB_GetSingleArray( DB_Query( "SELECT username FROM student WHERE id={$sender_id} LIMIT 1" ) );
		
	// There is a user with the uid = $sender, set to the name of the user
	if( count( $sender_result ) >= 0 )
	{
		$sender	= $sender_result[0];
	}
}

// Send the message to the group
if( isset( $group_id ) )
{
	DB_Query( "
			INSERT INTO 
				study_group_message
			(group_id, sender, message)
			VALUES
			({$group_id}, \"{$sender}\", \"{$message}\")
			");
			
	return '1';
}

// Make sure the user exists to send the message
$user = DB_GetSingleArray( DB_Query( "SELECT * FROM student WHERE id={$user_id}" ) );

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
	$sender_result = DB_GetSingleArray( DB_Query( "SELECT username FROM student WHERE id={$sender_id} LIMIT 1" ) );
		
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