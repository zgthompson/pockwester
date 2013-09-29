<?php

//	set_user_config: Will update a property of the user in their config row
//	 $user_id: The user_id to be updated
//	 $field: The cfg field to be updated
//	 $value: The value to become assumed
//	 Precondition: The user has been created with a cfg file already
//	9/27/13
// Arthur Wuterich

DB_Connect();

$user_id =  Get( 'user_id' );
$field = strtoupper( Get( 'field' ) );
$value = Get( 'value' );

// Escape the data
$value = mysql_real_escape_string( $value );
$user_id = mysql_real_escape_string( $user_id );
$field = strtoupper( $field );

// Update the row
DB_Query( "UPDATE USER_CONFIG SET {$field}=\"{$value}\" WHERE USER_ID={$user_id}" );

return( '1' );


































?>