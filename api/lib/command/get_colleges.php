<?php
// get_colleges.php: Returns the colleges in the database
// Arthur Wuterich
// 8-3-13
//

DB_Connect();

// Get classes from db
$data = DB_GetArray( DB_Query( 'SELECT * from COLLEGE' ) );

// Output JSON object
exit( OutputFormatting( $data ) );

?>