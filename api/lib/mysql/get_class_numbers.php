<?php

// get_college: Outputs a JSON object with the possible class number values
// Arthur Wuterich
// 8/28/13

require '../database/database.functions.php';

DB_Connect();

// Get schools from db
$array = DB_GetArray( DB_Query( 'SELECT DISTINCT(CATALOG_NUMBER) from CLASS' ) );

// Output JSON object
print json_encode($array);

?>