<?php
//	user_is_setup.php: Will return the amount of user availability records and classes a user has
//	$user_id: The user id of the user

DB_Connect();

$user_id = Get('user_id');

$where = '';
WhereAdd( $where, "id={$user_id} AND availability LIKE '%2%' " );

// Results
$status = array();

// Check for availability
$result = DB_GetSingleArray( DB_Query("SELECT availability FROM student {$where}") );
$status[] = $result[0];

$where = '';

WhereAdd( $where, "student_id={$user_id}" );

// Check for classes
$result = DB_GetSingleArray( DB_Query("SELECT COUNT(*) FROM student_course_instance {$where}") );
$status[] = $result[0];

// Student is setup
return OutputFormatting( $status );













?>
