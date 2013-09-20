<?php
// get_users.php: Returns the userss from the PWAPI
// Arthur Wuterich
// 8-3-13
//

DB_Connect();

// Get users from db
$users = DB_GetArray( DB_Query( 'SELECT NAME from USER' ) );

// Output JSON object
exit( json_encode( $users ) );

?>
