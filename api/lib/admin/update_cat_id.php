<?php

// update_cat_id.php: Will update the unique SUBJECT value keys in the CLASS_ID table
// Arthur Wuterich
// 8/28/13

require '../database/database.functions.php';

DB_Connect();

// Clear the old contents of the id table
DB_Query( 'DELETE FROM CLASS_ID' );

// Get the new contents
$rows = DB_GetArray( DB_Query( 'SELECT DISTINCT(SUBJECT) FROM CLASS' ) );

//Insert each field into DB
foreach( $rows as $row )
{
	DB_Query( "INSERT INTO CLASS_ID ( ID ) VALUES (\"{$row[0]}\")" );
}


?>