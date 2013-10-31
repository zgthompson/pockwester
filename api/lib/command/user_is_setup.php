<?php
//	user_is_setup.php: Will return 1 if the user has at least one class and one availability record
//	$user_id: The user id of the user

DB_Connect();

$user_id = Get('user_id');

// Right now there is a change in progress so the UID is going to be
// a composite key
if( !is_numeric($user_id) )
{
	$user_id = explode( ',', $user_id );
}
$where = '';
WhereAdd( $where, "USER_ID={$user_id[0]}" );

// Check for availability
$result = DB_GetSingleArray( DB_Query("SELECT COUNT(*) FROM USER_AVAILABILITY {$where}") );

// If there is no records in availability return 0
if( $result[0] <= 0 )
{
	return '0';
}

$where = '';
WhereAdd( $where, "student_id={$user_id[1]}" );

// Check for classes
$result = DB_GetSingleArray( DB_Query("SELECT COUNT(*) FROM student_course_instance {$where}") );

// If there is no records in availability return 0
if( $result[0] <= 0 )
{
	return '0';
}

// Student is setup
return '1';













?>