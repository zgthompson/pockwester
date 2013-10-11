<?php
//	set_message_flag.php: Performs operations on message flags
//	$id: The id of the message
//	[$flag]: The new flag for the message
//	[$combine]: Will combine the flags
//	[$remove]: Will remove the flags
// 10-10-2013
// Arthur Wuterich

DB_Connect();

$id = Get( 'id' );
$flag = Get( 'flag', false, 1 );
$combine = Get( 'combine', false );
$remove = Get( 'remove', false );

// Find the user availability in the availability table
$message = DB_GetArray( DB_Query( "SELECT * FROM USER_MESSAGE WHERE MESSAGE_ID={$id} LIMIT 1" ), true );

if( count( $message ) <= 0 )
{
	return( 'Could not find message' );
}

// Combine flags if requested
if( isset( $combine ) )
{
	// Or the current flag with the new flag to get the combined key
	$flag = $flag|intval($message[0]['FLAG']);
	
}
// Remove flags
elseif( isset( $remove ) )
{
	// And the flipped provided field with the current flag
	$flag = (~intval($flag))&intval($message[0]['FLAG']);
}

// Set the flags
DB_Query( "UPDATE USER_MESSAGE SET FLAG={$flag} WHERE MESSAGE_ID={$id}" );

return( '1' );







































?>