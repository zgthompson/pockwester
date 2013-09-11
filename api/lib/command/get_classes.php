<?php
// get_classes.php: Returns the classes from the PWAPI
// Arthur Wuterich
// 8-3-13
//

DB_Connect();

// Get classes from db
$classes = DB_GetArray( DB_Query( 'SELECT * from CLASS' ) );

// Output JSON object
exit( json_encode( $classes ) );

?>