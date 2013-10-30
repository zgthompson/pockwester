<?php
// remove_messages.php: Will remove messages of a given user and message ids
// $user_id: The userid to remove messages from
// $message_ids: A json object or message ids to remove or a single message id

DB_Connect();

$user_id = Get( 'user_id' );
$message_ids = Get( 'message_ids' );

// If the message ids is not numeric then there are multiple ids to process
if( !is_numeric( $message_ids ) )
{
	$message_ids = json_decode( str_replace( '\\', '', $message_ids ));

	// If the array could not be decoded then don't attempt to remove anything
	if( $message_ids == '' || !is_array( $message_ids ) || count( $message_ids ) <= 0 )
	{
		return '-1';
	}
}

if( is_array( $message_ids ) )
{
	// Build the in clause
	$in = '(';
	foreach( $message_ids as $id )
	{
		if( $in != '(' )
		{
			$in .= ',';
		}

		$in .= "{$id}";
	}

	$in .= ')';
}
else
{
	$in = "({$message_ids})";
}

// Delete the provided messages
DB_Query("DELETE FROM USER_MESSAGE WHERE USER_ID_RCV={$user_id} AND MESSAGE_ID IN {$in}");

return '1';

?>
