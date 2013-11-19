<?php
//	grab_updates.php: Will return current group and course_instance ids for given student
//		$student_id: Will filter the results based on a specific student id.
//		[$full]: Will return complete data about instances and study groups
// ZT & AW
// 11-18-2013

DB_Connect();

$student_id = Get( 'student_id', true );
$full = Get( 'full', false );

// If full is set then get more detailed data
if( isset( $full ) )
{
	// Get all of the study groups that the student is part of
	$groups = array();
	$post = array( 'student_id' => $student_id );
	$group_data = json_decode( PWTask( 'grab_study_groups', $post ) );
	foreach( $group_data->study_groups as $group )
	{
		$groups[] = $group;
	}
	
	// Get all of the class instances
	$instances = array();
	$post = array( 'student_id' => $student_id );
	$instance_data = json_decode( PWTask( 'grab_instances', $post ) );
	foreach( $instance_data->instances as $instance )
	{
		$instances[] = $instance;
	}
	
	$instances = $instances;
}
else
{
	$groups = ( DB_GetSingleArray( DB_Query( "SELECT study_group_id FROM student_study_group WHERE student_id = {$student_id}" ) ) );
	$instances = ( DB_GetSingleArray( DB_Query( "SELECT course_instance_id FROM student_course_instance WHERE student_id = {$student_id}" ) ) );
}

$looking = ( DB_GetSingleArray( DB_Query( "SELECT course_instance_id FROM student_course_instance WHERE student_id = {$student_id} AND looking_for_group = 'y'" ) ) );

return OutputFormatting( array( 'study_groups' => $groups, 'instances' => $instances, 'looking' => $looking ) );
?>
