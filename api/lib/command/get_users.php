<?php
// get_users.php: Returns all of the users in PWAPI
// Arthur Wuterich
// 8-3-13
//

DB_Connect();

// Get classes from db
$users = DB_GetArray( DB_Query( 'SELECT NAME from USER' ) );

// Output JSON object
exit( json_encode( $users ) );

?>
