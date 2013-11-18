<?php
//	grab_updates.php: Will return current group and course_instance ids for given student
//		[$student_id]: Will filter the results based on a specific student id.
// ZT & AW
// 11-18-2013

DB_Connect();

$student_id = Get( 'student_id', true );

$groups = ( DB_GetSingleArray( DB_Query( "SELECT study_group_id FROM student_study_group WHERE student_id = {$student_id}" ) ) );
$instances = ( DB_GetSingleArray( DB_Query( "SELECT course_instance_id FROM student_course_instance WHERE student_id = {$student_id}" ) ) );
$looking = ( DB_GetSingleArray( DB_Query( "SELECT course_instance_id FROM student_course_instance WHERE student_id = {$student_id} AND looking_for_group = 'y'" ) ) );

return OutputFormatting( array( 'study_groups' => $groups, 'instances' => $instances, 'looking' => $looking ) );
?>
