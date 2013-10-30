<?php
//	get_new_messages.php: Returns the number of new messges for a user
//	$user_id: The user_id whoes new messages to count
// 10-17-2013
// Arthur Wuterich

DB_Connect();

$user_id = Get( 'user_id' );

// Return count of messages with flag 0 and this user
return OutputFormatting( DB_GetArray( DB_Query( "SELECT COUNT(*) AS \"NUMBER_NEW_MESSAGES\" FROM USER_MESSAGE WHERE USER_ID_RCV={$user_id} AND FLAG=0" ), true ) );





































?>