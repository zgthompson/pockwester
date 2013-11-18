<?php
//	set_lfg_flag.php: Will set the lfg flag for a student in a paticular course
//		$instance_id: The id of the instance
//		$student_id: The id of the student
//		$flag: if true set that the student is looking for a group
// ZT & AW
// 11-12-2013

DB_Connect();

$instance_id = Get( 'instance_id' );
$student_id = Get( 'student_id' );
$flag = Get( 'flag' );

$where = '';
WhereAdd( $where, "student_id = {$student_id}" );
WhereAdd( $where, "course_instance_id = {$instance_id}" );

if( $flag )
{
	$flag = 'y';
}
else
{
	$flag = 'n';
}

DB_Query( "UPDATE student_course_instance SET looking_for_group='{$flag}' {$where} LIMIT 1" );

// If the flag is yes then attempt for form a study group
if( $flag == 'y' )
{
	$post = array( 'instance_id' => $instance_id );
	PWTask( 'form_study_group', $post );
}


























?>
