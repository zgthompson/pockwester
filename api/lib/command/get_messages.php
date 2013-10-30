<?php
//	get_messages.php: Will get all of the messages for the user
//	$user_id: The user_id whoes messages to retrieve
//	[$flag]: Will only return messages with the provided flag
//	[$like]: Content will be matched against this
//	[$sender]: Get messages from provided user_id or user string
// 10-10-2013
// Arthur Wuterich

DB_Connect();

$user_id = Get( 'user_id' );
$flag = Get( 'flag', false );
$like = Get( 'like', false );
$sender = Get( 'sender', false );

// Build the where clause
$where = '';

// Only messages from user
WhereAdd( $where, "USER_ID_RCV={$user_id}" );

// Only messages like
if( isset($like) )
{
	WhereAdd( $where, "MESSAGE LIKE \"%{$like}%\"" );
}

// Only messages from sender
if( isset($sender) )
{
	WhereAdd( $where, "( SENDER_NAME=\"%{$sender}%\" OR USER_ID_SND={$sender} )" );
}

// Only messages with flag
if( isset($flag) )
{
	WhereAdd( $where, "FLAG&{$flag}={$flag}" );
}

// Update the flag for any messages to show that they have been read
DB_Query( "UPDATE USER_MESSAGE SET FLAG=FLAG|1 WHERE FLAG=0" );


// Return all matched messages
return OutputFormatting( DB_GetArray( DB_Query( "SELECT * FROM USER_MESSAGE {$where} ORDER BY MESSAGE_ID DESC" ), true ) );





































?>