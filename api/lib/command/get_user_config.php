<?php

//	get_user_config.php: Will return the config information about a user in an assoc array
//	 $user_id: The user_id to be retrived
//	 Precondition: The user has been created with a cfg file already
//	9/27/13
// Arthur Wuterich

DB_Connect();

$user_id = Get( 'user_id' );

// Get the data
$config = DB_GetArray( DB_Query( "SELECT * FROM USER_CONFIG WHERE USER_ID={$user_id}" ), true );

return OutputFormatting( $config );
































?>