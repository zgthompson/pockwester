<?php

// get_college: Outputs a JSON object with the class subject in the database
// Arthur Wuterich
// 8/28/13

require '../database/database.functions.php';

DB_Connect();

// Get schools from db
$array = DB_GetArray( DB_Query( 'SELECT * from CLASS_ID' ) );

// Output JSON object
print json_encode($array);

?>