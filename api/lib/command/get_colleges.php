<?php
// get_classes.php:	Command for the pockwester api
//					 -Returns the colleges in the database
//					 -Precondition: Constants in api.php are defined 
// Arthur Wuterich
// 8-3-13
//

DB_Connect();

// Get classes from db
$data = DB_GetArray( DB_Query( 'SELECT * from COLLEGE' ) );

// Output JSON object
exit( json_encode( $data ) );

?>