<?php
// get_classes.php:	Command for the pockwester api
//					 -Returns the classes for provided campus
//					 -Precondition: Constants in api.php are defined 
// Arthur Wuterich
// 8-3-13
//

DB_Connect();

// Get classes from db
$classes = DB_GetArray( DB_Query( 'SELECT * from CLASS' ) );

// Output JSON object
exit( json_encode( $classes ) );

?>